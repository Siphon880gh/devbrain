TLDR: RxJS

---

## Dev - JS Observables, Observers, Subscribers

<< Does JS have observables and subscribers and observers? Or do I need to do setInterval to implement it?

  

\>>

Dev - JS Observables, Observers, Subscribers
<< Does JS have observables and subscribers and observers? Or do I need to do setInterval to implement it?

\>>
JavaScript itself doesn't have a built-in concept of Observables and Subscribers like some other languages or frameworks, but you can certainly implement an Observable pattern in JavaScript.

1. **Using Libraries**: The most common way to use Observables in JavaScript is through libraries such as RxJS. RxJS (Reactive Extensions for JavaScript) provides an implementation of the Observable type, which allows you to work with asynchronous data streams in a more functional reactive programming style.

2. **Custom Implementation**: If you prefer not to use external libraries, you can implement your own simple version of the Observable pattern. This involves creating an `Observable` class that maintains a list of subscribers and notifies them when an event occurs.

3. **Alternatives to `setInterval`**:
   - **Event Emitters**: In Node.js, the EventEmitter class is often used to handle asynchronous events.
   - **Promises and Async/Await**: For handling asynchronous operations, JavaScript's native Promises, along with the async/await syntax, offer a more modern approach.
   - **WebSockets and Server-Sent Events (SSE)**: For real-time updates, WebSockets or Server-Sent Events can be used instead of repeatedly polling a server with `setInterval`.

Using `setInterval` can be a straightforward method for certain use cases, but it's more of a polling mechanism rather than a true observable pattern. It's best suited for scenarios where you need to perform a task repeatedly at regular intervals, but it doesn't provide the same level of flexibility and scalability as Observables in managing asynchronous data streams.

https://chat.openai.com/c/bbdac317-59f9-487f-85f2-5bd2679c7aa7

  ---

Refer to [[RxJS Crash Course]]