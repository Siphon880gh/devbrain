
# Overview of Steps

1. **Create a Dockerfile**: This is a text document that contains all the commands a user could call on the command line to assemble an image. The Dockerfile may want to reference a `requirements.txt`  file that lists the python packages and versions you need. This minimizes the "it works on my machine" problem and ensures reliability. Dockerfile is also where you specify the starting commands, for example, starting flask server. Below will be instructions on how to get the current package versions that work on your local machine so you can have the same packages running on the server but only for this particular app (hence it’s containerized or dockerized).
2. **Build the Docker Image**: Using the Dockerfile, you can build the image that includes all the necessary components. Docker stores this image in its local image registry which is essentially a database on your machine where Docker keeps all the images, either pulled from remote repositories (like Docker Hub) or built locally. This means you have to build separately on local machine (when testing locally) and server (when production ready).
3. **Run the Docker Container**: After building the image, you can run it as a container. A common need is to read/write files in real time from your docker to your server or file structure without needing to rebuild the image (aka mounting or virtualizing), often times when users affect your file contents through an user interface. Another need is to expose a specific port (for example, Dockerfile could have flask running at :5001), but the Docker may block 5001 from accessing your server unless you expose it. Both these use cases are setup during the run command.

---
## Get version of Python for Dockerfile

How to find out versions of python and python3 on your computer.
- Type `python --version` and press Enter. This will display the version of Python 2, if it's installed.
- Then, type `python3 --version` and press Enter. This will display the version of Python 3, if it's installed.

Once you have the python version that works with your app on your local machine, you can write this version number in the Dockerfile

  
---

## Get versions of Python Packages for requirements.txt

How to get the current package versions that work on your local machine so you can have the same packages running on the server but only for this particular app (hence it’s containarized or dockerized).

This is crucial when offering an API service, as it minimizes the "it works on my machine" problem and ensures reliability.

This command will create a `requirements.txt` file with all the packages currently installed in that environment, along with their versions.

Then you can remove the irrelevant packages and keep the packages that are relevant to your containerized app.

Quick tip. Your py file may have a module name that isn’t exactly spelled the same as the package name at the generated requirements.txt. For instance, your server.py could have "flask_cors” which corresponds to "Flask-Cors”. Module names are lowercased and snake-cased. Some packages at your .py doesn’t need to be installed as part of pip: For instance, `import datetime` , `import json` , `import math`  are already part of the Python Standard Library so no need. And some packages your .py are part of other packages: For instance, `from bson import ObjectId` comes from the package pymongo

 ```
 pip freeze > requirements.txt 
```


Common pitfall. Make sure that the package names in the generated requirements.txt are version numbers and not a path to a file (eg. 
[file:///private/var/folders/nz/j6p8yfhx1mv_0grj5xl4650h0000gp/T/abs_9ctftfb254/croot/flask_1671217361609/work](file:///private/var/folders/nz/j6p8yfhx1mv_0grj5xl4650h0000gp/T/abs_9ctftfb254/croot/flask_1671217361609/work)). If it’s a path to a file, that means those packages are installed directly from a local directory or a git repository, or are locally modified versions. In such cases, you'll need to either find an alternative package on PyPI or set up your Docker build process to include these local packages. If the file path doesn’t exist on your computer, it indicates that these packages might have been installed in an unconventional way, possibly related to a Conda environment or a build process specific to a different machine or setup. Like it’s Conda, then you can get the conda’s package version with:

```
conda list flask  
```

And btw you can get all conda python flask versions with: `conda list` 

Now you can replace the file paths with the correct versions

---

Dockerfile and requirements.txt

```
# Use an official Python runtime as a parent image  
FROM python:3.10.9  
  
# Set the working directory in the container  
WORKDIR /usr/src/app  
  
# Copy the current directory contents into the container at /usr/src/app  
COPY . .  
  
# Install any needed packages specified in requirements.txt  
RUN pip install --no-cache-dir -r requirements.txt  
  
# Make port 5001 available to the world outside this container  
EXPOSE 5001  
  
# Define environment variable  
# ENV NAME World  
  
# Run server.py when the container launches  
CMD ["python3", "server.py"]
```

In the Dockerfile, you'll need a `requirements.txt` file in your project that includes modules that your python file uses. For example, Flask, Flask-Cors, and PyMongo. But because there’s Flask, you also need Werkzeug which Flask depends on because Werkzeug is WSGI for routing etc.

An example `requirements.txt` might look like this:
```
# FROM python:3.10.9
Flask==2.2.2
Werkzeug==2.2.2
Flask-Cors==4.0.0
pymongo==4.6.0
```

---
# Building the Docker Image

After creating these files, you can build your Docker image with the following command:

```
docker build --no-cache -t your-app-name .
```

^ No-cache? To prevent errors/pitfalls. If you've previously built an image and it's using cached layers, there might be some inconsistency.

Remember that we run the docker by the image name, not the Dockerfile. Once Dockerfile is built, the host machine remembers the image name

---

# Running the Docker Image

Then, run your Docker container using:

```
docker run your-app-name
```

Or you run with ports
```
docker run -p 5001:5001 your-app-name
```

^Make sure your Flask app is configured to run on `0.0.0.0` to be accessible outside the container:

```python

app.run(host='0.0.0.0', port=5001)

```

^ And make sure your Dockerfile had exposed the port: `EXPOSE 5001`

^ Changing the exposures will require rebuilding the image

^ This command will start a container from your image, mapping your local port 5001 to the container's exposed port 5001. 

And/or with virtualization/mounting:
```
# Format  
docker run -v /path/on/host:/path/in/container your-image-name
```

Example:
```
docker run -v $(pwd):/usr/src/app docker-flask
```

^A common need is to read/write files in real time from your docker to your server or file structure without needing to rebuild the image (aka mounting or virtualizing), often times when users affect your file contents through an user interface. 

^Notice the : separates. The `/path/in/container`  is found in your Dockerfile. Notice the $(pwd) is more reliable than “./”

Combined with a need for virtualization/mountaing and port exposure, it’s:
```
docker run -p 5001:5001 -v $(pwd):/usr/src/app docker-flask
```

^Your python script’s file pathing doesn’t need to change because the server.py that’s running inside Flask is in the same folder as /usr/src/app

---

# Example of a successful docker

Background: Flask file that connects to mongo and reads files from a virtualized path (the current path Dockerfile is in)

## Commands ran:
```
docker build -t docker-flask .  
docker run -p 5001:5001 -v $(pwd):/usr/src/app docker-flask
```

Those commands are for:
File structure:
```
files/  
  foo.txt  
.gitignore  
Dockerfile  
requirements.txt  
server.py
```

## Dockerfile:
```
# Use an official Python runtime as a parent image  
FROM python:3.10.9  
  
# Set the working directory in the container  
WORKDIR /usr/src/app  
  
# Copy the current directory contents into the container at /usr/src/app  
COPY . .  
  
# Install any needed packages specified in requirements.txt  
RUN pip install --no-cache-dir -r requirements.txt  
  
# Make port 5001 available to the world outside this container  
EXPOSE 5001  
  
# Define environment variable  
# ENV NAME World  
  
# Run server.py when the container launches  
CMD ["python3", "server.py"]
```


requirements:
```
Flask==2.2.2
Flask-Cors==4.0.0
pymongo==4.6.0

```

server.py:
```
from flask import Flask, request, jsonify
from flask_cors import cross_origin
from pymongo import MongoClient
from flask_cors import CORS
import datetime

# For ObjectId to work
from bson import ObjectId
import json

app = Flask(__name__)
CORS(app)

def is_running_in_docker():
    """Check if the current environment is a Docker container."""
    return os.path.exists('/.dockerenv')


# MongoDB connection
# client = MongoClient("mongodb://localhost:27017/")
# client = MongoClient(f"mongodb://host.docker.internal/")
mongo_host = "host.docker.internal" if os.path.exists('/.dockerenv') else "localhost"
client = MongoClient(f"mongodb://{mongo_host}:27017/")
db = client["docker-python-mongo"]


# Custom JSONEncoder to serialize ObjectId
class JSONEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, ObjectId):
            return str(obj)
        return json.JSONEncoder.default(self, obj)

# http://127.0.0.1:5001/
@app.route("/", methods=["GET"])
def front():
    return jsonify({"message": "This is to test a Dockerized Flask + MongoDB server that's been Gunicorned, and whether it can still have access to a folder that has been virtually mounted. Just to easily test all routes, I have them as GET."}), 200

# http://127.0.0.1:5001/db/seed
@app.route("/db/seed", methods=["GET"])
def dbSeed():
    foo_collection = db['foo']
    foo_collection.delete_many({})
    timeVal = str(datetime.datetime.now(datetime.timezone.utc))
    inserted = foo_collection.insert_one({"time":timeVal})
    _id = str(inserted.inserted_id)
    
    print("Data seeded successfully.")
    
    return jsonify({"seeded":{"_id":_id, "time":timeVal}}), 201

# http://127.0.0.1:5001/db/create
@app.route("/db/create", methods=["GET"])
def dbCreate():
    foo_collection = db['foo']
    # foo_collection.delete_many({})
    timeVal = str(datetime.datetime.now(datetime.timezone.utc))
    inserted = foo_collection.insert_one({"time":timeVal})
    _id = str(inserted.inserted_id)
    
    print("Data seeded successfully.")
    
    return jsonify({"seeded":{"_id":_id, "time":timeVal}}), 201


# http://127.0.0.1:5001/db/read
@app.route("/db/read", methods=["GET"])
def dbRead():
    # Retrieve all documents
    foo_collection = db['foo']
    documents = list(foo_collection.find())
    
    # Serialize the list of documents using the custom JSONEncoder
    json_data = json.dumps(documents, cls=JSONEncoder)

    return json_data, 200

# Example request http://127.0.0.1:5001/files/read/foo.txt
@app.route("/files/read/<filename>", methods=["GET"])
def readFile2(filename):
    testInstructions = "This is to test whether the server can read a file from a folder that has been virtually mounted if running in Docker. If it can read, then it can write."
    if(filename):
        try:
            with open(f"./files/{filename}") as my_file:
                contents = my_file.read()
                return jsonify({"testInstructions": testInstructions, "filename":filename, "contents": contents}), 200
        except FileNotFoundError:
            return jsonify({"testInstructions": testInstructions, "error":"File not found"}), 200
        except IOError:
            return jsonify({"testInstructions": testInstructions, "error":"An error occurred while reading the file."}), 200
    else:
        return jsonify({"message": "No filename provided."}), 400

if __name__ == "__main__":
    # app.run(debug=True, port=5001)
    app.run(host='0.0.0.0', port=5001)

```

  
^ Makes sure your Flask app is listening on `0.0.0.0` instead of `127.0.0.1` so that it can accept connections from outside the container.

^ Because you want your Flask application to connect to MongoDB running on the host machine, you can use `host.docker.internal` to refer to the host.

## Troubleshooting - Error while building docker

Ask ChatGPT with this prompt (Replace {..} appropriately)


I got this error while building image from Docker:
```
{My error}
```

  
Here is my Dockerfile:
```
{Its contents}
```


Here is my requirements.txt:
```
{Its contents}
```


* * *
## Troubleshooting - Get logs of your container

You can’t get the logs by the docker image. You can get it by the container image. All containers that are running are assigned docker IDs.

Get a list of all the Ids of dockers that are running with:  

```
docker ps -q
```

Then you can get the logs for that specific docker with:

```
docker logs [container_id]
```

* * *

## Troubleshooting - Did a container have conflict with another port?

Get a list of all the Ids of dockers that are running with:  

```
docker ps -q
```

Kill a docker with:

```
docker stop [container_id]
```

* * *

## Deep Dive - Mongo inside Flask inside container, and Mongo connects to Host’s Mongo

Code checks if Docker is running. If running, it connects to a different Mongodb 

```
import os
from pymongo import MongoClient

mongo_host = "host.docker.internal" if os.path.exists('/.dockerenv') else "localhost"

# Determine the MongoDB host
mongo_host = "host.docker.internal" if is_running_in_docker() else "localhost"

client = MongoClient(f"mongodb://{mongo_host}:27017/")


```