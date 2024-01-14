
https://your_domain:5001 possible

Use HTTPS for Your Python Server: The most secure option is to configure your Python server to use HTTPS. This would involve obtaining an SSL certificate for your server, similar to what you did for your main domain, and configuring your Python server to use it. This ensures end-to-end encryption and avoids mixed content issues.

It’s having your python server.py file be connectable over https and 5001 simultaneously.

You want to serve your Python application over HTTPS (SSL/TLS), so you can do so by configuring your Python server to use SSL/TLS encryption. Note your ssl_context need to load the correctly paired certificate file and file.key

```
from flask import Flask, request, jsonify  
from flask_cors import cross_origin  
from pymongo import MongoClient  
from service.elevenlabs import generateSpeech  
from bson import ObjectId  
from flask_cors import CORS  
import ssl # comes with standard python  
  
ssl_context = ssl.create_default_context(ssl.Purpose.CLIENT_AUTH)  
ssl_context.load_cert_chain('/path/to/file.crt', '/path/to/file.key')  
  
import sys  
sys.path.append('../slideshow-creator')  
from perform_vlai import performVLAI  
  
app = Flask(__name__)  
CORS(app)  
  
# MongoDB connection  
client = MongoClient("mongodb://localhost:27017/")  
db = client["storyway-videolistings"]  
  
# http://127.0.0.1:5001/  
@app.route("/", methods=["GET"])  
def front():  
    return jsonify({"message": "Success! This is to test a Docker alternative. This is Supervisor with pyenv for specific python interpreter and pipenv for specific python packages in a Flask application."}), 200  
  
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
            with open("./files/" + filename) as my_file:  
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
    # app.run(host='0.0.0.0', port=5001)  
    app.run(ssl_context=ssl_context, host='0.0.0.0', port=5001)
```