```

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
```


It's from `request.is_json`. You likely didnt send the body correctly. Frontend should be: `body: JSON.stringify(payload)`.