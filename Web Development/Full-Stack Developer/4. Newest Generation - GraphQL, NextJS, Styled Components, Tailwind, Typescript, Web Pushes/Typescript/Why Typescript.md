## Less Buggy Code

Less buggy because all your variable types are typed and not allowed to be ambiguous (type safety) unless you specifically mean for any type. Typescript also looks out for a lot of gotchas that make buggy apps such as more runtime depended methods that could return null, unless you assert it is definitely not going to be null. Your team will be on the same page about the logic. Your different architecture layers that will pass data between each other will error if you add variable to one layer and forget to adjust another layer.

---

## Lint in IDE

Typescript also gives you errors before you have to run it in a web browser or node js instance. In VS Code, see the problems tab when I treated an object key as if it's case-insensitive

LinkedList

```
//...
nodeMap[NAME] = { NAME, type, prev: [], next: [] };  
//...
```

![](https://i.imgur.com/QQcxX4w.png)


And clicking on it jumps to that line in question.:

```
interface Node {  
  name: string;  
  type: string;  
  text?: string;  
  textLeft?: string; // Text explaining the left connection  
  textRight?: string; // Text explaining the right connection  
  prev: Node[];  
  next: Node[];  
}  

```
  

But resolves when:

```
interface Node {  
  NAME: string;  
  type: string;  
  text?: string;  
  textLeft?: string; // Text explaining the left connection  
  textRight?: string; // Text explaining the right connection  
  prev: Node[];  
  next: Node[];  
}
```

Did you catch the problem that was resolved? Case sensitive NAME key name


---

## Compile and Runtime

Typescript benefits you at both compile time and run time

---

## Type-safe

The term "type safe" in programming refers to a language feature or coding practice that prevents type errors during compilation or execution. Type safety is a critical feature of statically typed languages like TypeScript, which enforce data type constraints. It essentially means that the language enforces rules on how data of various types can be interchanged and manipulated, ensuring that operations are performed only on compatible data types.

**Key aspects of Type-safe**

1. **Compile-Time Checks:** Type safety is often enforced at compile time, meaning that the language compiler checks that operations on variables are performed only with compatible types. For example, you can't accidentally add a string to a number without explicitly converting one type to the other. This prevents type errors that could occur at runtime, leading to bugs and crashes.

2. **Explicit Type Declarations:** In a type-safe environment like TypeScript, variables, function parameters, and return types can be explicitly declared. TypeScript will then enforce that the values assigned to these variables or returned from these functions match the declared type.

3. **Type Inference:** Type safety also involves the compiler's ability to infer the types of variables when they are not explicitly declared. TypeScript, for instance, can deduce the type of a variable based on the value it is initialized with, and it will enforce this inferred type in subsequent operations.

4. **Safe Type Conversions:** Type-safe languages allow for type conversions but typically require explicit casting or conversion functions, making the programmer consciously decide to convert between types. This reduces the risk of accidental data corruption or unexpected behavior.

5. **Error Prevention:** By enforcing type rules, type-safe languages prevent errors such as attempting to perform incompatible operations on data (e.g., attempting to execute a method that doesn't exist on a particular type). This ensures that many potential runtime errors are caught during development.

**Benefits of Type Safety**

- **Reliability:** Programs are more reliable as many errors are caught early in the development process.
- **Maintainability:** It’s easier to maintain and refactor code because you can quickly understand types and functions.
- **Readability:** Code readability improves as types provide documentation for what kind of data functions accept and return.
- **Productivity:** Developers can catch a significant class of bugs during compilation, reducing debugging and testing time.

Overall, type safety is about making sure that the operations on data are valid according to the data type and catching mistakes before they cause problems in a running application. This is a cornerstone of modern software development, particularly in complex systems where such errors can be costly and difficult to trace.