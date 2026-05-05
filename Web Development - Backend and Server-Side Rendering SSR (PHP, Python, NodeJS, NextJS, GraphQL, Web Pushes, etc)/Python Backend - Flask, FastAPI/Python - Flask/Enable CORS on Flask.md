Use case: 
Your 8888 port MAMP website trying to connect to your 5000 port Python Flask and it complains of CORS restriction.

You'll need to set the CORS from Python Flask

---

Cross-Origin Resource Sharing (CORS) is a security feature that allows or restricts resources on a web page to be requested from another domain outside the domain from which the resource originated. If you are developing a web application with a Flask backend and you're finding that CORS policies are blocking your requests, you can use the `flask_cors` extension to enable CORS in your Flask application.

Here’s how you can set it up:

### Step 1: Install flask_cors

You can install `flask_cors` using pip:

```sh
pip install flask-cors
```

### Step 2: Import and Initialize CORS

In your Flask application, import and initialize the `CORS` class from the `flask_cors` module.

```python
from flask import Flask
from flask_cors import CORS

app = Flask(__name__)
CORS(app)
```

The `CORS(app)` line will enable CORS for all routes and methods by default. This might be fine for development, but for security reasons, it is usually a good idea to only allow specific origins in production.

### Step 3: Configure CORS Options (optional)

If you want to configure CORS to be more restrictive, you can pass additional parameters:

```python
CORS(app, resources={r"/api/*": {"origins": "*"}})
```

In the example above, CORS is enabled for all origins (`"*"`) but only for paths that match `/api/*`. You can replace `"*"` with a list of allowed origins to be more specific.

### Step 4: Fine-Grained Control (optional)

If you need different CORS settings for different routes, you can use the `cross_origin` decorator:

```python
from flask_cors import cross_origin

@app.route('/some-route')
@cross_origin(origin='*', headers=['Content-Type', 'Authorization'])
def some_route():
    return 'This has CORS enabled for all origins with specific headers'
```

### Step 5: Confirm CORS Headers

After setting up `flask_cors`, make sure to check the response headers of your API requests. You should see headers like `Access-Control-Allow-Origin` in the response, indicating that CORS headers are being set correctly.

### Final Notes

When deploying your application, be sure to limit the allowed origins to the domains you control to prevent security risks associated with allowing all origins (`origins="*"`). For example:

```python
CORS(app, resources={r"/api/*": {"origins": "https://yourappdomain.com"}})
```

This will restrict CORS only to requests from `https://yourappdomain.com`.

Remember that enabling CORS does not completely prevent access to your API; it just allows web pages from other origins to make cross-origin requests to your server. You should still implement authentication, authorization, input validation, and other security practices to protect your application.