```
# Example request http://127.0.0.1:5001/files/read/foo.txt
@app.route("/files/read/<filename>", methods=["GET"])
def readFile2(filename):
    if(filename):
        return jsonify({"filename":filename}), 200
    else:
        return jsonify({"message": "No filename provided."}), 400

if __name__ == "__main__":
    app.run(debug=True, port=5001)
```