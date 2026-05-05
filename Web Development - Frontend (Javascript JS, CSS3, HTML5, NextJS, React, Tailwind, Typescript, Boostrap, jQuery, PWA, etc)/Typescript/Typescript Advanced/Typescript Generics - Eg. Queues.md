
The generic can ensure that your queue implementation can initialize to any data type at execution, but once initialized, then all further items are the same type

Let's look at this example:
```
class Queue<T> {
    private data: T[] = [];

    enqueue(item: T) {
        this.data.push(item); // `item` must be of type `T`
    }

    dequeue(): T | undefined {
        return this.data.shift(); // returns `T` or `undefined` if empty
    }

    peek(): T | undefined {
        return this.data?.[0]; // looks at the first element, returning `T` or `undefined`
    }
}

const queue = new Queue<number>();
queue.enqueue(1);
queue.enqueue(2);
console.log(queue.dequeue()); // Correctly outputs 1
console.log(queue.peek());    // Correctly outputs 2

const stringQueue = new Queue<string>();
stringQueue.enqueue("hello");
stringQueue.enqueue("world");
console.log(stringQueue.dequeue()); // Correctly outputs "hello"
console.log(stringQueue.peek());    // Correctly outputs "world"

// This will result in a compile-time error
// stringQueue.enqueue(5);  // Error: Argument of type 'number' is not assignable to parameter of type 'string'.

```


In this class:

- `Queue<T>` is a generic class that works with any data type.
- The `enqueue`, `dequeue`, and `peek` methods handle elements according to the specific type `T` used to create an instance of the class.
- It's possible to receive `undefined` as a return value from the `dequeue()` or `peek()` methods because these methods may be called when the queue is empty. Let's review how this happens and what it means in terms of handling such cases:
- Instances `queue` and `stringQueue` show how the same `Queue` class can be used for both numbers and strings with full type safety.

When you create an instance of the `Queue` class and specify a type, say `number`, TypeScript ensures that:

- Only numbers can be enqueued in this particular queue instance.
- The dequeue method will only return numbers (or `undefined` if the queue is empty).
- Any attempt to enqueue a different type (like a string or boolean) will result in a compile-time error.

This provides strong type safety by preventing runtime errors that could occur if different types were mixed in the same collection, leading to bugs that are often hard to trace and debug.