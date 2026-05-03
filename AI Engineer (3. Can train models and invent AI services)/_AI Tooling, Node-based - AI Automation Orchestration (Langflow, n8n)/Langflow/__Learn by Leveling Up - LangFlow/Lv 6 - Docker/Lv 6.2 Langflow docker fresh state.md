Their doc's official instructions on how to run langflow via docker:
https://docs.langflow.org/Deployment/deployment-docker

### Clone repo and build Docker container[​](https://docs.langflow.org/Deployment/deployment-docker#ba89773aa8b8425b985bfe7ba91c35cc "Direct link to Clone repo and build Docker container")

1. Clone the LangFlow repository:
	```
	git clone https://github.com/langflow-ai/langflow.git
	```
2. Navigate to the `docker_example` directory:
	```
	cd langflow/docker_example
	```
	
3. Run the Docker Compose file:
	```
	docker compose up
	```

4. LangFlow will now be accessible at `http://localhost:7860/`.