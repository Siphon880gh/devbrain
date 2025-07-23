
```
from flask import Flask, request, jsonify
from flask_cors import cross_origin
from pymongo import MongoClient
from service.elevenlabs import generateSpeech
from bson import ObjectId
from flask_cors import CORS
import sys

app = Flask(__name__)
CORS(app)


# MongoDB connection
client = MongoClient("mongodb://localhost:27017/")
db = client["sample_db"]

# http://127.0.0.1:5001/login
@app.route("/login", methods=["POST"])
def authLogin():
    if request.is_json:
        users = db["users"]
        data = request.get_json()
        user = users.find_one(
            {"login": data.get("login"), "password": data.get("password")}
        )
        if user:
            return (
                jsonify(
                    {
                        "data": user["data"]
                    }
                ),
                201,
            )
        else:
            return jsonify({"message": "unauthorized"}), 401
    else:
        return jsonify({"error": "JSON not accepted"}), 400




# http://127.0.0.1:5001/media/samples  
@app.route("/media/samples", methods=["GET"])  
def getMediaSamples():  
    if request.args.get("userId"):  
          
        def getUserId():  
            return request.args.get('userId')  
  
        users = db['users']  
        user = users.find_one({"_id":ObjectId(getUserId())})  
  
        if(user):  
            return jsonify({"message":"success", "data":{ "musicUrl": user["musicUrl"] }}), 201  
        else:  
            return jsonify({"error":"User ID not found so unable to update to user's document"}), 400  
  
    else:  
        return jsonify({"error": "Not sent to Flask server. Either misformed JSON request or no userId provided in URL"}), 400  
```