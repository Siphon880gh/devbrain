Microservices are each with different port and whether port binds to anywhere (internet and local) or only locally

You have microservices with different ports. You may find it problematic and a security concern to expose those ports to the internet

In your nginx server block for port 80 and 443 you can write in a location like /api or /whatever-service and reverse proxy it to the actual port.

But let's say it's an api then your endpoint would include the /api or /whatever-service. That's not ideal when you're working on the code on your development environment and then pushing it to the online production environment, and on your development environment you're going to connect to the port directly, hence your api won't need that extra path in the endpoint because you're not forced to reverse proxy by pathname location

 Your api can look for and the strip away that preceding pathname before matching routes, thereby allowing you to easily work production or development:
```
from flask import Flask, request  
  
class StripApiMiddleware:  
def __init__(self, app):  
self.app = app  
  
def __call__(self, environ, start_response):  
# Strip "/api" from the request path if it exists  
if environ['PATH_INFO'].startswith('/api'):  
environ['PATH_INFO'] = environ['PATH_INFO'][4:] # Remove "/api"  
return self.app(environ, start_response)  
  
app = Flask(__name__)  
app.wsgi_app = StripApiMiddleware(app.wsgi_app)  
  
@app.route('/example')  
def example_route():  
return 'This is an example route.'  
  
if __name__ == '__main__':  
app.run(port=5001)
```