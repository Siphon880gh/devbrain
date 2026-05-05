
```
const eventSource = new EventSource('/your-sse-endpoint');  
  
// Function to check the connection status  
function checkConnectionStatus() {  
    switch (eventSource.readyState) {  
        case EventSource.CONNECTING:  
            console.log("The connection is being established or re-established.");  
            break;  
        case EventSource.OPEN:  
            console.log("The connection is open and active.");  
            break;  
        case EventSource.CLOSED:  
            console.log("The connection is closed.");  
            break;  
        default:  
            console.log("Unknown connection state.");  
    }  
}  
  
// Example of how to check the connection status manually  
checkConnectionStatus();  
  
// You can also check the status at any point in your code  
setTimeout(() => {  
    checkConnectionStatus();  
}, 5000);
```


- `EventSource.CONNECTING (0)`: The connection is being established or re-established.
- `EventSource.OPEN (1)`: The connection is open and active, meaning the client is receiving events.
- `EventSource.CLOSED (2)`: The connection has been closed, either by the server or due to an error.