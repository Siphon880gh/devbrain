
```toc
```

## Basics

WebSockets provide a full-duplex communication channel over a single TCP connection, allowing real-time, bidirectional communication between clients and servers. Here’s how WebSockets work between Python and JavaScript:

1. **Handshake:**
   - **Client-Side (JavaScript):** The client initiates a WebSocket connection by sending an HTTP request with an `Upgrade` header to the server.
   - **Server-Side (Python):** The server responds to the handshake request, upgrading the connection from HTTP to WebSocket if it supports WebSocket connections.

2. **Connection Establishment:**
   - After the handshake, a WebSocket connection is established. Both the client and server can now send messages to each other at any time.

3. **Message Exchange:**
   - **Client-Side (JavaScript):** Use the `WebSocket` API to open a connection and send/receive messages.
     ```javascript
     const ws = new WebSocket('ws://localhost:8080');
     ws.onopen = () => {
       ws.send('Hello, Server!');
     };
     ws.onmessage = (event) => {
       console.log('Message from server:', event.data);
     };
     ```
   - **Server-Side (Python):** Use a WebSocket library like `websockets` or `socket.io` for Python to handle WebSocket connections.
     ```python
     import asyncio
     import websockets

     async def handle_connection(websocket, path):
         async for message in websocket:
             print(f"Received message: {message}")
             await websocket.send("Hello, Client!")

     start_server = websockets.serve(handle_connection, "localhost", 8080)
     asyncio.get_event_loop().run_until_complete(start_server)
     asyncio.get_event_loop().run_forever()
     ```

4. **Close Connection:**
   - Either the client or the server can initiate a connection close. Both sides need to handle connection close events to clean up resources.

   **Client-Side (JavaScript):**
   ```javascript
   ws.onclose = () => {
     console.log('Connection closed');
   };
   ```

   **Server-Side (Python):**
   ```python
   async def handle_connection(websocket, path):
       async for message in websocket:
           print(f"Received message: {message}")
           await websocket.send("Hello, Client!")
       print('Connection closed')
   ```

In summary, WebSocket enables real-time communication by maintaining an open connection, allowing instant exchange of data between Python (server-side) and JavaScript (client-side).

---

## Sending messages

Here is how to send messages from both the server and the client using WebSockets.

### Sending Messages from the Server (Python)

Using the `websockets` library in Python, you can send messages to the client. Here’s how:

1. **Install the `websockets` library:**

   ```bash
   pip install websockets
   ```

2. **Python WebSocket Server Example:**

   ```python
   import asyncio
   import websockets

   async def handle_connection(websocket, path):
       # Send a message to the client
       await websocket.send("Hello, Client!")

       async for message in websocket:
           print(f"Received message: {message}")
           # Echo the message back to the client
           await websocket.send(f"Server received: {message}")

   start_server = websockets.serve(handle_connection, "localhost", 8080)

   asyncio.get_event_loop().run_until_complete(start_server)
   asyncio.get_event_loop().run_forever()
   ```

   In this example:
   - The server sends an initial message `"Hello, Client!"` when the connection is established.
   - It also echoes any message it receives from the client.

### Sending Messages from the Client (JavaScript)

Using the `WebSocket` API in JavaScript, you can send messages to the server. Here’s how:

1. **JavaScript WebSocket Client Example:**

   ```javascript
   const ws = new WebSocket('ws://localhost:8080');

   ws.onopen = () => {
     console.log('Connection opened');
     // Send a message to the server
     ws.send('Hello, Server!');
   };

   ws.onmessage = (event) => {
     console.log('Message from server:', event.data);
   };

   ws.onclose = () => {
     console.log('Connection closed');
   };
   ```

   In this example:
   - The client sends a message `"Hello, Server!"` to the server when the connection is opened.
   - It listens for messages from the server and logs them to the console.

### Summary

- **Server-Side (Python):** Use `await websocket.send("message")` to send messages to the client. You can send messages both initially and in response to received messages.
- **Client-Side (JavaScript):** Use `ws.send("message")` to send messages to the server. This can be done as soon as the connection is opened or at any other point as needed.

These examples provide a basic framework for sending and receiving messages between a WebSocket server and client.

---

## Practical - Send message when user clicks a button

To send a message from a WebSocket client when a user clicks a button, you'll need to add an event listener to the button that triggers the message sending process. Here's a step-by-step tutorial:

### HTML

1. **Create an HTML file with a button:**

   ```html
   <!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>WebSocket Client</title>
   </head>
   <body>
       <button id="sendMessageButton">Send Message</button>
       <script src="client.js"></script>
   </body>
   </html>
   ```

### JavaScript

2. **Create a JavaScript file (`client.js`) to handle the WebSocket connection and button click:**

   ```javascript
   // Connect to the WebSocket server
   const ws = new WebSocket('ws://localhost:8080');

   // Handle connection open event
   ws.onopen = () => {
     console.log('Connection opened');
   };

   // Handle incoming messages from the server
   ws.onmessage = (event) => {
     console.log('Message from server:', event.data);
   };

   // Handle connection close event
   ws.onclose = () => {
     console.log('Connection closed');
   };

   // Get the button element
   const button = document.getElementById('sendMessageButton');

   // Add click event listener to the button
   button.addEventListener('click', () => {
     // Send a message when the button is clicked
     const message = 'Hello, Server! Button clicked.';
     ws.send(message);
     console.log('Message sent:', message);
   });
   ```

### Explanation

- **HTML File:**
  - Defines a button with the ID `sendMessageButton`.
  - Includes a script that will handle WebSocket communication and the button click event.

- **JavaScript File (`client.js`):**
  - Creates a WebSocket connection to the server at `ws://localhost:8080`.
  - Sets up event handlers to log messages when they are received or when the connection opens or closes.
  - Adds an event listener to the button so that when it's clicked, a message is sent to the WebSocket server.

### Summary

1. **Create an HTML button.**
2. **Use JavaScript to connect to the WebSocket server and handle the button click event.**
3. **Send a message to the server when the button is clicked.**

This setup will enable the client to send a message to the server whenever the user clicks the button on the webpage.


---


## Closing connection

Here's a brief tutorial on how to handle closing WebSocket connections based on specific keywords, both from the server side (Python) and the client side (JavaScript).

### Server-Side (Python)

To close the connection when the client sends a specific keyword, you can use the `websockets` library. Here's a simple example:

1. **Install the `websockets` library:**

   ```bash
   pip install websockets
   ```

2. **Python WebSocket Server Example:**

   ```python
   import asyncio
   import websockets

   async def handle_connection(websocket, path):
       async for message in websocket:
           print(f"Received message: {message}")
           if message == "CLOSE_CONNECTION":
               print("Closing connection as per client request.")
               await websocket.close()
               break
           await websocket.send(f"Echo: {message}")

   start_server = websockets.serve(handle_connection, "localhost", 8080)

   asyncio.get_event_loop().run_until_complete(start_server)
   asyncio.get_event_loop().run_forever()
   ```

   In this example, the server will close the connection if the client sends the message `"CLOSE_CONNECTION"`.

### Client-Side (JavaScript)

To close the connection when the server sends a specific keyword, you can use the `WebSocket` API. Here’s how you can implement this:

1. **JavaScript WebSocket Client Example:**

   ```javascript
   const ws = new WebSocket('ws://localhost:8080');

   ws.onopen = () => {
     console.log('Connection opened');
     ws.send('Hello, Server!');
   };

   ws.onmessage = (event) => {
     console.log('Message from server:', event.data);
     if (event.data === 'CLOSE_CONNECTION') {
       console.log('Server requested to close connection');
       ws.close();
     }
   };

   ws.onclose = () => {
     console.log('Connection closed');
   };
   ```

   In this example, the client closes the connection if it receives the message `"CLOSE_CONNECTION"` from the server.

### Summary

- **Server-Side:** Use the `websockets` library in Python to close the connection when a specific keyword is received from the client.
- **Client-Side:** Use the `WebSocket` API in JavaScript to close the connection when a specific keyword is received from the server.

By setting up these handlers, you can ensure that connections are closed appropriately based on the keywords exchanged.