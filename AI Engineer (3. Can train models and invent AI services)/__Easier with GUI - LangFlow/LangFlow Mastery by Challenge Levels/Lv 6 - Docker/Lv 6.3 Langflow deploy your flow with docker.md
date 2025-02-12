Unlike many youtube and online tutorials you find, where they teach you how to install and run Langflow with Docker from a fresh slate, this tutorial will let you design a flow in Langflow then deploy it ready for use with docker.

---

Export your flow that you want to deploy as docker. A good flow to test is Basic Prompting template (make sure you finish configuring it so it can take input and respond with an answer)

- Project settings near the Save status at the top center -> Export
	![[Pasted image 20250212011028.png]]
	
- For now, let's export the API keys. A future challenge will be to parametrize that API key as an environment variable, but one step at a time. Keep the API Keys:
	![[Pasted image 20250212011129.png]]

Notice that the export flow is a json file. Also notice that the flow id will not change between your Langflow and the Docker Langflow, meaning when we run the docker and expose the port, when we send an api request, that api request is the same endpoint with the same flow id that had worked on your Langflow.
![[Pasted image 20250212011324.png]]

Get the docker_example from [[Lv 6.2 Langflow docker fresh state]], however instead of running a fresh state of Langflow via the `docker_example/docker-compose.yml`, we add environmental variable and volume to it so that docker can run off your flow json file!

1. Create a folder where your json files will be loaded from the Dockerized Langflow. Place your exported flow json file there. Keep this folder's path in mind
2. At `docker-compose.yml`, add these:
	   
	- environment:
		```
		# Add an environment variable to have Langflow load saved flows from another folder
		- LANGFLOW_LOAD_FLOWS_PATH=/app/langflow/flows
		- LANGFLOW_AUTO_LOGIN=true
		```
	
	- volumes:
		```
		# Mount your local flow files into the container
		- /Users/wengffung/dev/web/langflow/docker/:/app/langflow/flows
		```

	- So at volume, you add the path where you have your exported flow json file and you map it to docker's internal path /app/langflow/flows, where the dockerized langflow will see the jsonfiles (after docker mounted and mapped your folder path)
	- Your `docker-compose.yml` file may look like:
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
      # Add an environment variable to have Langflow load saved flows from another folder  
      - LANGFLOW_LOAD_FLOWS_PATH=/app/langflow/flows  
      - LANGFLOW_AUTO_LOGIN=true  
    volumes:  
      - langflow-data:/app/langflow  
      # Mount your local flow files into the container  
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

---

Run with:
```
docker compose up
```

**Congratulations! Your flow is now deployed via docker**

---

**Checkpoint A**

You will not be able to make changes to any json flows at your folder path
Renaming:
![[Pasted image 20250212021341.png]]
To:
![[Pasted image 20250212021348.png]]

It will just bounce back to the old name, especially after restarting the docker:
![[Pasted image 20250212021406.png]]

However, this is because your exported json file will never be edited the the Dockerized Langflow. 

You could however make a duplicate, then start editing - those changes will persist because they're saved to PostgreSQL which is persisted by being mounted to a path at Docker Desktop's virtual system:
![[Pasted image 20250212022635.png]]

---

**Checkpoint B**

The API keys are currently hard coded into your flow json file which is not good practice.

The next challenge will be to parametrize that API key as an environmental variable.