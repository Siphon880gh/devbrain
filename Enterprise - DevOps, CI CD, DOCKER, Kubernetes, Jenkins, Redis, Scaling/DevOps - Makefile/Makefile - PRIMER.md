Think of Makefile as a collection of shell .sh files, each .sh file running commands to prepare the app (build dist files) or manage the app (restart, shutdown) etc. But all the commands are written in sections in the Makefile and each section is named. You run the `make` command in the same folder where there's a Makefile, followed by the section name, eg. `make clean`

The syntax is pretty simple so I will just provide boilerplates and sample, then explain afterwards

---

## Snippet: C Example

```
build:
    gcc -o myprogram main.c

clean:
    rm -f myprogram
```

This `Makefile` defines two rules or targets: `build` and `clean`. Here's an explanation of each:

1. **`build`**:
   - **Command**: `gcc -o myprogram main.c`
   - This command tells the `gcc` (GNU Compiler Collection) to compile `main.c` and output an executable file called `myprogram`. 
   - `gcc -o myprogram main.c`:
     - `-o myprogram`: Specifies that the output file should be named `myprogram`.
     - `main.c`: This is the C source code file that is being compiled.

2. **`clean`**:
   - **Command**: `rm -f myprogram`
   - This command removes the `myprogram` file if it exists.
   - `rm -f myprogram`:
     - `rm`: This is the command to remove files.
     - `-f`: This flag forces the removal without prompting the user for confirmation, even if the file does not exist.

In summary:
- **`build`** compiles `main.c` into an executable named `myprogram`.
- **`clean`** deletes the executable `myprogram` if it exists, cleaning up the directory.

---

## Snippet: Docker compose - Prisma - yarn

```
.PHONY: up down stop shell-c shell-d shell-s  
  
default: up  
  
install:  
	@echo "Installing..."  
	cp .env_EXAMPLE .env  
	docker-compose up -d  
	yarn   
	yarn prisma migrate dev  
	yarn dev  
	  
up:  
	@echo "Running..."  
	docker-compose up -d  
	yarn dev  
	  
down:  
	@echo "Removing containers."  
	docker-compose down  
  
  
stop:  
	@echo "Stopping containers..."  
	@docker-compose stop  
  
  
shell-d:  
	docker exec -u 0 -ti app_postgresdb_1 sh
```

Note here up and down just means up and running vs down offline.


This `Makefile` defines a set of commands to streamline Docker-based development tasks for a project. Here's an explanation of each target:

1. **`.PHONY: up down stop shell-c shell-d shell-s`**
   - This line declares that the listed targets (`up`, `down`, `stop`, etc.) are "phony," meaning they do not represent actual files. This ensures that `make` will always run these commands, even if a file with the same name exists in the directory. **More on this on a later section.**

2. **`default: up`**
   - The default target is `up`. This means that if you run `make` without specifying a target, it will automatically run the `up` target.

3. **`install:`**
   - This target is used for setting up the environment and installing dependencies.
   - It first prints "Installing..." as feedback to the user.
   - Then, it copies the example environment file `.env_EXAMPLE` to `.env`.
   - It brings up the Docker containers in detached mode (`docker-compose up -d`).
   - It runs the `yarn` package manager to install dependencies.
   - It runs `yarn prisma migrate dev` to apply database migrations using Prisma.
   - Finally, it starts the development server with `yarn dev`.

4. **`up:`**
   - This target is responsible for running the application.
   - It prints "Running..." as feedback.
   - It runs `docker-compose up -d` to start the Docker containers in detached mode.
   - It starts the development server using `yarn dev`.

5. **`down:`**
   - This target shuts down the Docker containers.
   - It prints "Removing containers." to inform the user.
   - Then it runs `docker-compose down`, which stops and removes the containers, networks, volumes, and images created by `docker-compose`.

6. **`stop:`**
   - This target stops the running Docker containers without removing them.
   - It prints "Stopping containers..." and runs `docker-compose stop` to halt the containers while keeping the environment intact.

7. **`shell-d:`**
   - This target opens an interactive shell inside the PostgreSQL Docker container (`app_postgresdb_1`).
   - It runs `docker exec` with the `-u 0` flag to execute as the root user, and `-ti` to open an interactive terminal (`sh`) inside the container.


---

## Snippet: PM2 Ecosystem Example

```
.PHONY: default ls restart stop log\:app

# Default message when no target is specified
default:
	@echo "Please choose one of the commands after '.PHONY:'"
	@head -1 Makefile

ls:
	@ls -la --group-directories-first

# Build the .env file for development
restart:
	@pm2 restart ecosystem.config.js --env production

# Build the .env file for production
stop:
	@pm2 delete ecosystem.config.js --env production

# See log
log\:app:
	@pm2 logs --lines 100 | grep -i "APP_NAME"

```

---

## Phony

```
.PHONY: build clean install

build:
    gcc -o myprogram main.c

clean:
    rm -f *.o myprogram

install:
    cp myprogram /usr/local/bin/
```

if my Makefile has clean for `rm -f *.o myprogram` but I have a file named "clean" in the same folder as Makefile, what happens when I run `make clean`?

### Why Phony

Without `.PHONY`, `make clean` might not run if a file named `clean` exists, as it assumes the target is up to date. With `.PHONY`, `make` always runs the `clean` target, ignoring the `clean` file.

Why: `make` was originally designed for file-based dependencies in software builds, where targets represent files that need to be updated. It skips commands if a target file exists and is up to date. When developers began using `make` for non-file actions, `.PHONY` was introduced to mark such targets, ensuring they run even if a file with the same name exists. This behavior stems from `make`'s original file-focused purpose.

---

## Why @


In your terminal, whatever command you type, you can see the command you just typed. By having @ preceding a command in Makefile, it hides the command from being spelled out. It looks better like that in most cases.

---

## How to Run and How to Run Default

Very simple! Just run with "make" followed by the section name. Eg. `make clean`, `make build`

Other examples, depending on your Makefile:
```
make up  
make down  
make help
```

If you've set a default:
```
make
```

^That was from Makefile:
```
.PHONY: install up down stop shell example  
  
# Default target  
default: help

# Help command to display available commands  
help:  
	@echo "Available commands:"  
	@echo "  make install   - Simulate installation process"  
	@echo "  make up        - Simulate starting the application"  
	@echo "  make down      - Simulate stopping the application"  
	@echo "  make stop      - Simulate stopping containers"  
	@echo "  make shell     - Simulate opening a shell in a container"  
	@echo "  make example   - Simulate any custom example process"
	
	
# The rest ...

```

