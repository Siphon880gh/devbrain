Yes—you can pull the exact image that’s running on Heroku down to your machine if the app was deployed via Heroku’s Container Registry. You can even extract the code from the image. And then you can sync the postgres from heroku into local, retaining all workflows and even the credentials (when asked to login at the n8n). Here’s how.

## Option A — Pull the running container image (Recommended)

Requirements: Heroku CLI and Docker installed.

```bash
# 1) Login
heroku login
heroku container:login

# 2) Pull the image for your process type (usually 'web')
heroku container:pull web -a <your-heroku-app-name>

# (If you also have a worker:)
# heroku container:pull worker -a <your-heroku-app-name>

# 3) See the image locally
docker images | grep <your-heroku-app-name>  # note the IMAGE ID or tag
```
^ Yes pull will still work if you're not the admin role (but a collaborator role) at Heroku

Run it locally (adjust the port/env as your app expects):

```bash
# Often Heroku apps expect PORT; map it to something on your host
docker run --rm -p 5001:5001 -e PORT=5001 <image-id-or-tag>
```

## Option B — Extract the filesystem (get the code/artifacts)

If you want the app files out of the image:

```bash
# Create a stopped container from the image
docker create --name app_tmp <image-id-or-tag>

# Find the workdir if you’re unsure (often /app)
docker inspect app_tmp | grep -i workdir -A1

# Copy files out (replace /app with the container’s WORKDIR)
docker cp app_tmp:/app ./app_export

# Clean up
docker rm app_tmp
```

You’ll now have `./app_export` with whatever was baked into the image (built assets, installed deps, etc.). Note: this may not look like your original repo (e.g., node_modules or compiled files may be present; git history will not).

## Option C — If you used Heroku Git (not Docker)

If you originally deployed with `git push heroku main` (buildpacks, not container):

```bash
heroku git:clone -a <your-heroku-app-name>
```

This won’t work if you deployed via Docker image only.

---

## Grab config vars (env) to run locally

Your image won’t include config vars/add-ons. You can export them:

```bash
# Writes KEY=VALUE pairs to .env (handle with care!)
heroku config -a <your-heroku-app-name> -s > .env
```

The resultant .env could look like:
```
DATABASE_URL='postgres://XXX:XXXX@c5cqb8h0eop3g3.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com:5432/XXX'
DB_POSTGRESDB_SSL_REJECT_UNAUTHORIZED=false
GENERIC_TIMEZONE=America/Los_Angeles
N8N_BASIC_AUTH_ACTIVE=true
N8N_BASIC_AUTH_USER='xx@xxxx.com'
N8N_ENCRYPTION_KEY=XXXX
N8N_PROTOCOL=https
N8N_REINSTALL_MISSING_PACKAGES=true
N8N_RUNNERS_ENABLED=true
PAPERTRAIL_API_TOKEN=xxx
WEBHOOK_URL='https://xxx.herokuapp.com/'

```

Then readjust the env file for local Postgres:
- Change database url to local
- Break down database details further
- Disable SSL ENABLED otherwise will error
- n8n protocol is now http because no SSL
- Adjust Webhook URL
```
DATABASE_URL=postgres://XXX:XXXX@host.docker.internal:5433/n8n

DB_TYPE=postgresdb
DB_POSTGRESDB_HOST=host.docker.internal
DB_POSTGRESDB_PORT=5433
DB_POSTGRESDB_DATABASE=n8n
DB_POSTGRESDB_USER=XXX
DB_POSTGRESDB_PASSWORD=XXXX

DB_POSTGRESDB_SSL_ENABLED=false
GENERIC_TIMEZONE=America/Los_Angeles
N8N_HOST=0.0.0.0
N8N_BASIC_AUTH_ACTIVE=true
N8N_BASIC_AUTH_USER=xx@xxxx.com
N8N_ENCRYPTION_KEY=XXXX
N8N_PROTOCOL=http
N8N_REINSTALL_MISSING_PACKAGES=true
N8N_RUNNERS_ENABLED=true
PAPERTRAIL_API_TOKEN=xxx
WEBHOOK_URL=http://localhost:5001/
```

---

Looking at the original .env file (remember you exported heroku envs an at earlier step):
```
DATABASE_URL='postgres://...us-east-1.rds.amazonaws.com:5432/...'
..
```

That's a remote postgres server. but you don't really need it. You can just sync remote to local with this command:
```
heroku pg:pull DATABASE_URL postgresql://XXX:XXXX@localhost:5433/XXX -a n8n-tc
```
^ No need to replace DATABASE_URL. That’s for Heroku to grab for you!

If errored "createdb: error: database creation failed: ERROR:  database "n8n" already exists":
- Delete that database:
![[Pasted image 20260311220451.png]]
- Then try the database pul command again

Postgres not installed?
- Are you using the driver on your computer?
- Or do you prefer a dockerized postgres* (Refer to next section)
- And do you have pgadmin4 as the gui to browse your postgres database/tables?
- Check the port your cli work is doing matches the port of the database. In postgres' pgadmin4, you can see at:
	- ![[Pasted image 20260311220748.png]]

---

If you want dockerized postgres - docker.yml:
```
services:
  postgres:
    image: postgres:15-alpine
    environment:
    - POSTGRES_DB=XXX
    - POSTGRES_USER=XXX
    - POSTGRES_PASSWORD=XXXX
    ports:
    - "127.0.0.1:5433:5432"
    volumes:
    - postgres_data:/var/lib/postgresql/data
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U n8n"]
      interval: 5s
      timeout: 5s
      retries: 5
  
volumes:
  postgres_data:
```

Have that container started so a postgres server is online on your localhost, then proceed

---

## Let's attempt to run it

Then get your image name by running and looking at:
```
docker images
```

Then (run docker on port 5001 internally and expose to host at 5001 via the host:container port syntax):
```bash
docker run --env-file .env -p 5001:5001 -e PORT=5001 <image-id-or-tag>
```

Eg.
cd /Users/wengffung/dev/web/xny/n8n-heroku
docker run --env-file .env -p 5001:5000 -e PORT=5001 baf40350bd5b

---

## Got this error failing running container?
WARNING: The requested image's platform (linux/amd64) does not match the detected host platform (linux/arm64/v8) and no specific platform was requested

Sorry you have to pull the image again but only pull the specific OS (no you can't run with another OS):
--platform=linux/amd64
So:
`docker pull --platform=linux/amd64 registry.heroku.com/n8n-tc/web:latest`

Then run to see image id (`docker images`), so you can run:
`docker run --env-file .env -p 5001:5001 -e PORT=5001 --platform=linux/amd64  <IMAGE_ID>`
^ Yes you indicate the platform again, otherwise you get an error saying "no specific platform was requested"

If then fails because of some vague error, then make it report errors more verbosely with `-it`:
```
docker run -it --env-file .env -p 5001:5001 -e PORT=5001 --platform=linux/amd64  <IMAGE_ID>
```

What that changes:
- i keeps STDIN open
- t gives you a terminal

If db fails to initialize, is postgres running? Is the port that postgres is running on the port that n8n listens to? Those are some the common problems with db fails to initialize errors.


---

## Other notes & gotchas

- Add-ons (Heroku Postgres/Redis) aren’t included. Point your local app to local services or remote URLs in `.env`.
    
- If your image uses a custom process type (e.g., `release`, `worker`), pull each with `heroku container:pull <type> -a <app>`.
    
- If your app was built in CI and only the image was pushed, the pulled image is your source of truth (no git history).
    

If you tell me the app name and process type(s), I can tailor the exact commands (ports, WORKDIR, run script) for your setup.
