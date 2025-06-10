You separate them in blocks:
```
# http://127.0.0.1:5001/media/samples  
@app.route("/media/samples", methods=["POST"])  
# ...  
  
# http://127.0.0.1:5001/media/samples  
@app.route("/media/samples", methods=["GET"])  
# ...
```