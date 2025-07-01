Status: Theoretical. Have not tested through that there won't be bugs

Required knowledge: 
- You know how to deploy your designed Langflow flow as a docker. Someone else running that docker will see the exact flow you designed [[Lv 6.3 Langflow deploy your flow with docker]]

---

Let's run two Langflow servers at port 7860 and 7861.

We setup two docker compose files

docker-compose.yml:
```
services:
  langflow:
    image: langflowai/langflow:latest # or another version tag on https://hub.docker.com/r/langflowai/langflow
    pull_policy: always               # set to 'always' when using 'latest' image
    ports:
      - "7860:7860"
    depends_on:
      - postgres
    environment:
      - LANGFLOW_DATABASE_URL=postgresql://langflow:langflow@postgres:5432/langflow
      # This variable defines where the logs, file storage, monitor data and secret keys are stored.
      - LANGFLOW_CONFIG_DIR=app/langflow
      # Add an environment variable if Langflow supports specifying a default flow file      
      - LANGFLOW_LOAD_FLOWS_PATH=/app/langflow/flows
      - LANGFLOW_AUTO_LOGIN=true
      - OPENAI_API_KEY=sk-proj-UTxxxxxxxxxxxx
    volumes:
      - langflow-data:/app/langflow
      # Mount your local flow file into the container
      - /Users/wengffung/dev/web/langflow/docker/:/app/langflow/flows

  postgres:
    image: postgres:16
    environment:
      POSTGRES_USER: langflow
      POSTGRES_PASSWORD: langflow
      POSTGRES_DB: langflow
    ports:
      - "5432:5432"
    volumes:
      - langflow-postgres:/var/lib/postgresql/data

volumes:
  langflow-postgres:
  langflow-data:

```


docker-compose2.yml:
```
services:
  langflow1:
    image: langflowai/langflow:latest # or another version tag on https://hub.docker.com/r/langflowai/langflow
    pull_policy: always               # set to 'always' when using 'latest' image
    ports:
      - "7861:7860"
    depends_on:
      - postgres1
    environment:
      - LANGFLOW_DATABASE_URL=postgresql://langflow:langflow@postgres:5432/langflow
      # This variable defines where the logs, file storage, monitor data and secret keys are stored.
      - LANGFLOW_CONFIG_DIR=app/langflow
      # Add an environment variable if Langflow supports specifying a default flow file      
      - LANGFLOW_LOAD_FLOWS_PATH=/app/langflow/flows
      - LANGFLOW_AUTO_LOGIN=true
      - OPENAI_API_KEY=sk-proj-UTxxxxxxxxxxxx
    volumes:
      - langflow-data1:/app/langflow
      # Mount your local flow file into the container
      - /Users/wengffung/dev/web/langflow/docker/:/app/langflow/flows

  postgres1:
    image: postgres:16
    environment:
      POSTGRES_USER: langflow
      POSTGRES_PASSWORD: langflow
      POSTGRES_DB: langflow
    ports:
      - "5433:5432"
    volumes:
      - langflow-postgres1:/var/lib/postgresql/data

volumes:
  langflow-postgres1:
  langflow-data1:

```

We run the two docker composes as follows (because the second compose file is a custom filename):

At a terminal instance:
```
docker compose up
```

At another terminal instance:
```
docker compose -f docker-compose2.yml up
```

Both terminals will falsely report the same port number:
![[Pasted image 20250213021235.png]]


However you'll be able to visit both instances at
http://localhost:7860/
http://localhost:7861/


And you can perform API calls at their respective ports to invoke their respective flows as well.

Going to the API screen will show you the API calls with their respective ports:
![[Pasted image 20250213021409.png]]

Calling either API calls at different ports should both work

If you have difficulty making more than one docker work, try combining them into one docker-compose.yml file.

---

**Discussion**

The diff of the second docker compose file:
services:
```
langflow1:
	image: langflowai/langflow:latest # or another version tag on https://hub.docker.com/r/langflowai/langflow
    pull_policy: always               # set to 'always' when using 'latest' image
    ports:
      - "7861:7860"
    depends_on:
      - postgres1
    environment:
      - LANGFLOW_DATABASE_URL=postgresql://langflow:langflow@postgres:5432/langflow
      # This variable defines where the logs, file storage, monitor data and secret keys are stored.
      - LANGFLOW_CONFIG_DIR=app/langflow
      # Add an environment variable if Langflow supports specifying a default flow file      
      - LANGFLOW_LOAD_FLOWS_PATH=/app/langflow/flows
      - LANGFLOW_AUTO_LOGIN=true
      - OPENAI_API_KEY=sk-proj-UTxxxxxxxxxxxx
    volumes:
      - langflow-data1:/app/langflow
      # Mount your local flow file into the container
      - /Users/wengffung/dev/web/langflow/docker/:/app/langflow/flows

  postgres1:
    image: postgres:16
    environment:
      POSTGRES_USER: langflow
      POSTGRES_PASSWORD: langflow
      POSTGRES_DB: langflow
    ports:
      - "5433:5432"
    volumes:
      - langflow-postgres1:/var/lib/postgresql/data

volumes:
  langflow-postgres1:
  langflow-data1:
```


What's been changed are:
- Service names `langflow1` and `postgres1` (otherwise Docker will close the other instance if you try to run both docker compose files with the same service names)
- Volume paths on computer drive or on Docker Desktop virtual drive (if on Mac)
- Host port number for both langflow and postgres.