This tutorial assumes you already know how to design your Langflow flow and then deploy that flow via docker such that anyone can run the docker-compose.yml and can use your flow right away. 

Or you can migrate the docker to an online server and make the flow accessible on the internet (remember that a Langflow server in addition to opening the canvas gui, can accept http request to run the flow, and that http request can accept prompt and respond with AI)

---

**Quick Reference**

Default environmental variables:
[https://docs.langflow.org/configuration-global-variables#default-environment-variables](https://docs.langflow.org/configuration-global-variables#default-environment-variables)

---

## Check

Run your dockerized Langflow and check that you didn't already accidentally protected your sensitive keys:

Case 1 - This is protected:
![[Pasted image 20250212025549.png]]

Case 2 - This is unprotected, because the API key is literally spelled out in the canvas, which means it's literally spelled out in the exported flow json file:
![[Pasted image 20250212025722.png]]

Case 3 - This is you attempting to secure your API keys but failed at it because the environmental variable name is treated as a literal string:
![[Pasted image 20250212025826.png]]

If it looked like Case 1, then you're good. Only continue reading if you're not sure how you even did that, or need to repeat the steps that you don't know for other protected API keys in your flow.

---

## Two Approaches

You have two approaches.

### Approach 1 - Fix exported flow json:

You could either modify your exported flow json file so that you replace all hard coded API keys with the environmental variable name and set load_from_db to true (because Langflow saves your environmental variables to the PostgreSQL database for the app)

At a section for OpenAI key here, unprotected was:
```
            "template": {  
              "_type": "Component",  
              "api_key": {  
                "_input_type": "SecretStrInput",  
                "advanced": false,  
                "display_name": "OpenAI API Key",  
                "dynamic": false,  
                "info": "The OpenAI API Key to use for the OpenAI model.",  
                "input_types": [  
                  "Message"  
                ],  
                "load_from_db": false,  
                "name": "api_key",  
                "password": true,  
                "placeholder": "",  
                "required": true,  
                "show": true,  
                "title_case": false,  
                "type": "str",  
                "value": "sk-proj-UTxxxxxxxxxxxx"  
              },
```

Changed to this (two changes):
```
            "template": {  
              "_type": "Component",  
              "api_key": {  
                "_input_type": "SecretStrInput",  
                "advanced": false,  
                "display_name": "OpenAI API Key",  
                "dynamic": false,  
                "info": "The OpenAI API Key to use for the OpenAI model.",  
                "input_types": [  
                  "Message"  
                ],  
                "load_from_db": true,  
                "name": "api_key",  
                "password": true,  
                "placeholder": "",  
                "required": true,  
                "show": true,  
                "title_case": false,  
                "type": "str",  
                "value": "OPENAI_API_KEY"  
              },
```

The environmental variables must be one of the list default environmental variables for this to work:
[https://docs.langflow.org/configuration-global-variables#default-environment-variables](https://docs.langflow.org/configuration-global-variables#default-environment-variables)

Then the end user or the target server where you deploy the dockerized Langflow must run Langflow with the default environmental variables configured already. For instance, their docker-compose.yml will contain under environment:
```
      - OPENAI_API_KEY=sk-proj-UTxxxxxxxxxxxx
```

So the docker-compose.yml could look like:
```
services:
  langflow:
    image: langflowai/langflow:latest # or another version tag on https://hub.docker.com/r/langflowai/langflow
    pull_policy: always  # set to 'always' when using 'latest' image
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
      - OPENAI_API_KEY=sk-proj-UTxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
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

If you're distributing to the public, then you may need to create a README.md explaining that they need to add in their API key at docker-compose.yml, and as usual, to make sure the path to the exported flow json file is adjusted.

### Approach 2 - Re-export flow json:

The other approach is to design the flow in Canvas to use environmental variables, then export the json. The final result will be the same json file as if you had fixed it (Approach 1)

However you run Langflow in order to fix the canvas, then export it, you must run with environmental variables

Remember that only the default environmental variables listed in the docs are officially supported, so stick to these environmental variables only:
[https://docs.langflow.org/configuration-global-variables#default-environment-variables](https://docs.langflow.org/configuration-global-variables#default-environment-variables)

Running langflow without docker
```
OPENAI_API_KEY="your-api-key-here" python -m langflow run
```

**Or** Running langflow with docker compose? Make sure the environment:
```
- OPENAI_API_KEY=sk-proj-UTxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

- So the docker-compose.yml could look like:
	```
	services:
	  langflow:
	    image: langflowai/langflow:latest # or another version tag on https://hub.docker.com/r/langflowai/langflow
	    pull_policy: always  # set to 'always' when using 'latest' image
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
	      - OPENAI_API_KEY=sk-proj-UTxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
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

Go into editing your canvas and see if clicking the globe at where the API key would be inputted will bring up environmental variables that you've launched Langflow with:
![[Pasted image 20250212032104.png]]

![[Pasted image 20250212025549.png]]


If that kind of user interaction is possible, then it means Langflow recognized your environmental variable.

Now if you export the flow as a json file by going to Project settings near the Save status at the top center -> Export
![[Pasted image 20250212011028.png]]

And you make sure to **include** the API keys (is fine because they're only saving as variable names rather than their actual values):
![[Pasted image 20250212011129.png]]

So the exported flow json file will have load_from_db to true and the value is the default environmental variable name:
```
            "template": {  
              "_type": "Component",  
              "api_key": {  
                "_input_type": "SecretStrInput",  
                "advanced": false,  
                "display_name": "OpenAI API Key",  
                "dynamic": false,  
                "info": "The OpenAI API Key to use for the OpenAI model.",  
                "input_types": [  
                  "Message"  
                ],  
                "load_from_db": true,  
                "name": "api_key",  
                "password": true,  
                "placeholder": "",  
                "required": true,  
                "show": true,  
                "title_case": false,  
                "type": "str",  
                "value": "OPENAI_API_KEY"  
              },
```

^ Key points are that the value must be a recognized default environmental variable from their docs and that `"load_from_db": true` because when Langflow runs it checks for environmental variables then reloads it into PostgreSQL so that at the canvas or api side, it can be pulled in by the user or the api.

**Congratulations!** Now not only did you deploy your flow that can immediately be used, triggered with http requests, or answered your text gen prompts with a http request - but your API keys is secured using environmental variables.

----

## Supplement - A Third Approach?

Another approach is to have no environmental variables and no hard coded API keys. This is **not recommended**.

The section of the exported flow json would have a blank value and load_from_db would be false, either because you edited the json file or you exported with blank API key fields:
```
            "template": {  
              "_type": "Component",  
              "api_key": {  
                "_input_type": "SecretStrInput",  
                "advanced": false,  
                "display_name": "OpenAI API Key",  
                "dynamic": false,  
                "info": "The OpenAI API Key to use for the OpenAI model.",  
                "input_types": [  
                  "Message"  
                ],  
                "load_from_db": true,  
                "name": "api_key",  
                "password": true,  
                "placeholder": "",  
                "required": true,  
                "show": true,  
                "title_case": false,  
                "type": "str",  
                "value": ""  
              },
```

However this approach would be very confusing for your user or your future self.

The Readme would be either to hard code the API key at specific lines of the json file or to make a http request with the API key:
```
TWEAKS = {  
  "ChatInput-9FOSJ": {},  
  "ParseData-f3zpS": {},  
  "Prompt-DJHnM": {},  
  "ChatOutput-sHzFM": {},  
  "SplitText-Tb2qB": {},  
  "File-EXg8c": {},  
  "OpenAIModel-N0opB": {},  
  "HuggingFaceInferenceAPIEmbeddings-uzQoe": {  
    "api_key": {  
        "load_from_db": False,  
        "value": os.getenv("HUGGINGFACE_API_KEY")  
    }  
  },  
  "OpenRouter-HUmNL": {  
    "api_key": {  
        "load_from_db": False,  
        "value": os.getenv("OPENROUTER_API_KEY")  
    }  
  },  
  "Chroma-dFezZ": {}  
}
```

For a review on how to make API requests when a Langflow server is running: [[Lv 5 - Langflow API Endpoint]]