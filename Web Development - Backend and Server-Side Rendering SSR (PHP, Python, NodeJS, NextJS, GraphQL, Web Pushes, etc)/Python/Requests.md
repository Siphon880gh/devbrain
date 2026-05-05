They are python's http requests made synchronously

```
import requests

def handle_response(response):
    # Process the response here
    print(response.json())

# Making an HTTP GET request
response = requests.get('https://api.example.com/data')

# Handling the response
handle_response(response)

```