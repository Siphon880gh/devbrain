
URL queries in Flask are treated as args. You can think of them as keyword args, like python functions do

```

# Example request http://127.0.0.1:5001/files/read/?filename=foo.txt
@app.route("/files/read/", methods=["GET"])
def readFile():
    filename = request.args.get('filename', default=None, type=str)
    if(filename):
        return jsonify({"filename":filename}), 200
    else:
        return jsonify({"message": "No filename provided."}), 400

if __name__ == "__main__":
    app.run(debug=True, port=5001)

```