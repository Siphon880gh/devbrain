The client can request the server. It can request in many different ways. Some ways include fetch, jQuery ajax, and XMLHttpRequest. Requesting the server using fetch is called Fetching.

The server can be the PHP server, a server.js node that's running at specific port, a python server, among many.

#Fetching with GET request
Default method is get, so you don't need to specify the method
```
fetch('/api/animals').then(response => {
    if (response.ok) {
      return response.json();
    }
    alert('Error: ' + response.statusText);
  })
  .then(animals => {
    console.log(animals);
  });
```

#Fetching with POST JSON request:
```
fetch('http://localhost:3001/api/characters/', {
  method: 'POST',
  headers: {
    "Accept": 'application/json',
    'Content-Type': 'application/json'
  },
body: JSON.stringify({
    name: "X",
    age: 200
})
})
  .then(response => {
    if (response.ok) {
      return response.json();
    }
    alert('Error: ' + response.statusText);
  })
  .then(postResponse => {
    console.log(postResponse);
  });

  app.post("/api/characters", (req, res) => {
    const newCharacter = req.body;
    res.send(req.body);
    return;
  });
```


# Fetching with POST URL query
```
fetch('http://localhost:3001/api/characters/?name=Y&age=100', {
  method: 'POST',
})
  .then(response => {
    if (response.ok) {
      return response.json();
    }
    alert('Error: ' + response.statusText);
  })
  .then(postResponse => {
    console.log(postResponse);
  });

  app.post("/api/characters", (req, res) => {
    const newCharacter = req.body;
    res.send(req.body);
    return;
  });

  app.post("/api/characters", (req, res) => {
    const newCharacter = req.query;
    const keys = Object.keys(newCharacter);
    if (Object.keys(newCharacter).length && Object.keys(newCharacter).includes("name")) {
        characters.push(newCharacter);
        res.json(characters);
    } else {
        res.status(400).send("Not expected queries for new character");
    }
})
```


---

The provided code snippet is **the boilerplate** of using the Fetch API in JavaScript to make a  network GET requests (the default method of requests when you don't specify a method in the fetch code). Here's a breakdown of its functionality:

1. `fetch('url')`: This initiates a network request to the specified URL. The `fetch` function returns a promise that resolves to the response of the request.
    
2. `.then(response => { ... })`: This is the first `.then()` method chained to the promise returned by `fetch`. It receives the `response` object as its argument. Inside this block:
    
    - `if (!response.ok)`: This line checks if the response is not okay (usually meaning a status code outside the range 200-299). If the condition is true, it indicates a network error or an unsuccessful HTTP status.
    - `throw new Error('Network response was not ok')`: This line throws a new error if the response was not okay, which will be caught by the `.catch()` method later in the chain.
    - `return response.json()`: If the response is okay, this line parses the response body as JSON. It also returns another promise that resolves with the result of parsing the body text as JSON.
3. `.then(data => { ... })`: This is the second `.then()` method. It receives the parsed JSON data as its argument. Inside this block:
    
    - `console.log(data)`: This line logs the parsed JSON data to the console. This is where you would typically process or use the fetched data.
4. `.catch(error => { ... })`: This `.catch()` method is used for error handling. It catches any errors that occur during the fetch operation or in any of the `.then()` blocks.
    
    - `console.error('There has been a problem with your fetch operation:', error)`: This line logs the error message to the console, along with a custom message indicating that there was a problem with the fetch operation.
```
fetch('url')  
  .then(response => {  
    if (!response.ok) {  
      throw new Error('Network response was not ok');  
    }  
    return response.json();  
  })  
  .then(data => {  
    // Process your data here  
    console.log(data);  
  })  
  .catch(error => {  
    // Handle the error here  
    console.error('There has been a problem with your fetch operation:', error);  
  });
```

---

The provided code snippet is a JavaScript example of how to use the Fetch API to send data to a server using a POST request. Here's a detailed description:

1. **Endpoint and Data Preparation**
   - `const url = 'https://your-api-endpoint.com/data';`: This line defines the URL of the API endpoint where the request will be sent.
   - `const data = { key1: 'value1', key2: 'value2' };`: Here, a JavaScript object named `data` is created, which contains the data you want to send to the server. The object has two key-value pairs in this example.

2. **Setting Request Headers**
   - `const headers = new Headers({ ... });`: This line creates a new `Headers` object which includes the headers for the request. Headers typically contain metadata about the request.
   - `'Content-Type': 'application/json'`: This header indicates that the body of the request is in JSON format.
   - `'Authorization': 'Bearer YOUR_AUTH_TOKEN'`: This is an authorization header, often used for API security. `'YOUR_AUTH_TOKEN'` should be replaced with an actual authentication token.

3. **Making the Fetch Request**
   - `fetch(url, { ... })`: The `fetch` function is used to make the network request. It takes two arguments: the URL and an options object.
   - `method: 'POST'`: This specifies that the HTTP method for the request is POST, which is used for sending data to a server.
   - `headers: headers`: This attaches the previously defined headers to the request.
   - `body: JSON.stringify(data)`: The data object is converted to a JSON string and set as the request body.

4. **Handling the Response**
   - `.then(response => { ... })`: This block handles the response from the server. It checks if the response was successful.
   - `if (!response.ok) { throw new Error(`HTTP error! status: ${response.status}`); }`: If the response was not successful (indicated by `response.ok` being false), an error is thrown with the HTTP status.
   - `return response.json();`: If the response is successful, it's assumed to be in JSON format and is parsed as such.

5. **Processing the Response Data**
   - `.then(data => { console.log('Success:', data); })`: If the response is successfully parsed, this block will execute, logging the response data to the console.

6. **Error Handling**
   - `.catch(error => { console.error('Error:', error); })`: This block catches any errors that occur during the fetch operation or in the previous `.then()` blocks, logging them to the console.

```
// Your endpoint and data you want to send  
const url = 'https://your-api-endpoint.com/data';  
const data = {  
  key1: 'value1',  
  key2: 'value2'  
};  
  
// Create a request header  
const headers = new Headers({  
  'Content-Type': 'application/json',  
  'Authorization': 'Bearer YOUR_AUTH_TOKEN' // Replace YOUR_AUTH_TOKEN with your actual token  
});  
  
// Use fetch with POST method, headers, and body  
fetch(url, {  
  method: 'POST', // Specify the method  
  headers: headers,  
  body: JSON.stringify(data) // Convert the JavaScript object to a JSON string  
})  
.then(response => {  
  if (!response.ok) {  
    throw new Error(`HTTP error! status: ${response.status}`);  
  }  
  return response.json(); // or .text() if the response is not in JSON format  
})  
.then(data => {  
  console.log('Success:', data);  
})  
.catch(error => {  
  console.error('Error:', error);  
});
```

---

In JavaScript, when using fetch, it does not automatically throw an error or reject the promise when the response contains an HTTP error status, like 400 or 500. Instead, the fetch promise will only be rejected if the request itself cannot be made, such as due to network issues. If the request is successful, but the server responds with an error status, fetch will resolve the promise with the response object, and you need to check the response status manually to handle such errors

It’s where `!response.ok` will trigger the `.catch()` block. By throwing an error when the response is not ok, you are explicitly rejecting the promise, which will then be caught by the `.catch()` block. Here’s how you can do it:
```
fetch('/your-endpoint', {  
  // your fetch options here  
})  
.then(async(response)=>{  
  // Check if the response status is not ok (e.g., status code 400, 500, etc.)  
  if (!response.ok) {  
    // Throw an error with the status text, which will be caught by the catch block  
    const responseBack = await response.text();  
    console.error(responseBack);  
    throw new Error(`Error: ${response.statusText}`);  
  }  
  return response.json(); // or .text(), etc. depending on the response type  
})  
.then(data => {  
  // Handle your data here  
  console.log(data);  
})  
.catch(error => {  
  // Handle any errors thrown in the then block or network errors  
  console.error('Error fetching data:', error);  
});```