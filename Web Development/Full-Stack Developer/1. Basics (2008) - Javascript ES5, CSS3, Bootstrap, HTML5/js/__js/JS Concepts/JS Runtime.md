
Learned from: 
https://medium.com/@preethika200154200435/what-is-runtime-environment-in-js-9d5a57a66bd6


There are two runtime environments
- Browser
- NodeJS

Both runtimes use the JS Engine


Here is a diagram of the browser context:
![](https://i.imgur.com/hA5rFPZ.png)

Here’s a quick overview of what each part represents:

- **JS Engine**: This is where the JavaScript code is executed. It contains the Memory Heap for memory allocation and the Call Stack where the code execution happens.
    
- **Memory Heap**: This is where the memory allocation for variables and functions happens.
    
- **Call Stack**: This is the place where the stack frames (or function calls) are pushed and popped as the functions begin and end execution.
    
- **Web/Browser APIs**: These are APIs provided by the browser environment that JavaScript can interact with, like the DOM (Document Object Model), Web Storage API, and Web Workers API. These APIs can be used to perform tasks like DOM manipulation, store data locally, and run scripts in the background, respectively.
    
- **Event Loop**: This is a constantly running process that checks if the call stack is empty. If it is, it checks the queues for any tasks that need to be executed.
    
- **Microtasks Queue**: This is where smaller tasks like promises are queued. These are processed at the end of each run of the event loop, after the stack is cleared, and before rendering.
    
- **Tasks Queue**: Also known as the callback queue, this is where callbacks from the APIs (like those from `setTimeout` or `setInterval`) are placed. They will be moved to the call stack by the event loop when the call stack is empty.
    

The arrows show the flow of execution and how tasks are moved from one part of the environment to another. It illustrates that while JavaScript is single-threaded (with one call stack), the runtime can perform non-blocking operations with the help of the event loop and queues, making it asynchronous.