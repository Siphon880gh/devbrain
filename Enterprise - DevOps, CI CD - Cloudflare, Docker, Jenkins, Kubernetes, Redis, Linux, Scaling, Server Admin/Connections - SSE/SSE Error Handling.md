
After starting an event source connecting to a route to your backend:

```
eventSource.onerror = function(event) {  
    console.error("Error occurred:", event);  
      
    // You can handle the error or retry logic here  
    if (event.readyState === EventSource.CLOSED) {  
        console.log("Connection was closed.");  
    }  
};
```