You can sync local MongoDB (often viewed in Compass) to remote Atlas and the other way around, quite easily.


We will create this file structure:
```
.
├── .env
├── example.env
├── Makefile
├── mongodb-atlas-backup
│   ├── .env
│   ├── example.env
│   └── run_automater.sh
├── mongodb-compass-backup
│   ├── .env
│   ├── example.env
│   └── run_automater.sh
```


Makefile:
```
.PHONY: setup  
  
# List your required files here, eg. .env  
REQUIRED_FILES = ./mongodb-atlas-backup/.env ./mongodb-compass-backup/.env ./.env  
  
setup:  
	@echo "🔍 Checking required files..."  
	@for file in $(REQUIRED_FILES); do \  
		if [ ! -f $$file ]; then \  
			echo "❌ Missing: $$file — please set up this file."; \  
		fi \  
	done  
  
	@echo "🔧 Making all .sh files executable..."  
	@find . -name "*.sh" -exec chmod u+x {} \;  
  
atlas2local:  
	@echo "🔍 Migrating MongoDB Atlas to local database..."  
	@cd mongodb-atlas-backup && ./run_automater.sh  
	@cd mongodb-atlas-backup && mongorestore --drop --gzip dump/  
  
local2atlas:  
	@echo "🔍 Migrating local database to MongoDB Atlas..."  
	@cd mongodb-compass-backup && ./run_automater.sh  
	@set -a && source .env && set +a && cd mongodb-compass-backup && mongorestore --drop --uri "$$MONGODB_URI" dump/
```

^Notice we can call `make atlas2local` to sync from remote database to local database.
^Notice we can call `make local2atlas` to sync from local database to remote database.

Create .env from these example.env's:
- ./example.env:
	```
	MONGODB_URI="<Remote_mongodb_at_machine>"
	```

- ./mongodb-atlas-backup/example.env:
	```
	MONGODB_URI="<Remote_mongodb_at_machine>"
	```

- ./mongodb-compass-backup/example.env:
	```
	DB_NAME="<Local_MongoDB_Compass_DB_to_backup>"
	```

Setup your .env files. You can validate they work by running:
```
make setup
```

If there are missing .env files, you'll be warned:
![[Pasted image 20250608014325.png]]

Now let's create the scripts:
- mongodb-atlas-backup/run-automater.sh

```
#!/bin/bash

# Source the .env file
if [ -f .env ]; then
    source .env
else
    echo "Error: .env file not found"
    exit 1
fi

# If dump/ exists, delete it
if [ -d "dump" ]; then
    rm -rf dump
fi

# Run mongodump
mongodump --uri "$MONGODB_URI" --gzip --out ./dump
```


- mongodb-compass-backup/run-automater.sh
```
#!/bin/bash

# Source the .env file
if [ -f .env ]; then
    source .env
else
    echo "Error: .env file not found"
    exit 1
fi

# If dump/ exists, delete it
if [ -d "dump" ]; then
    rm -rf dump
fi

# Run mongodump
mongodump --db $DB_NAME --out ./dump
```


Make the sh files executable with `chdmod u+x ...` or running:
```
make setup
```


## Usage

We can call `make atlas2local` to sync from remote database to local database.

We can call `make local2atlas` to sync from local database to remote database.
