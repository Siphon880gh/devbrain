
```
from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/process_data', methods=['POST'])
def process_data():
    # Check if the incoming request contains JSON
    if request.is_json:
        # Parse the JSON data from the request
        data = request.get_json()

        # Now you can use the `data` dictionary as needed
        # For example, you can access a value with data['key'] if your JSON contains that key

        # Return a JSON response or any other response as needed
        return jsonify({"message": "Data processed", "yourData": data}), 200
    else:
        # If request does not contain JSON, return an error
        return jsonify({"message": "Request must be JSON"}), 400

if __name__ == '__main__':
    app.run(debug=True)

```

You may want to get a specific key's value, so you can run this after `data = request.get_json()`:
```
some_val = data.get('key', 'Default Value')
```

~ Getting other types (TODO: Check if exhaustive)
```
    if request.is_json:
        data = request.get_json()
    elif request.form:
        data = request.form.to_dict()
    elif request.args:
        data = request.args.to_dict()
    else:
        data = request.data
    print(data)
```