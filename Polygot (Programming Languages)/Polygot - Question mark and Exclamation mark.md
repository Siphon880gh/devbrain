## JS Optional chaining ?:
1. **Object property access:** `obj?.prop`
2. **Array item access:** `arr?.[index]`
3. **Function or method call:** `func?.(args)`

## TS optional ?
```
interface Person { 
	name: string; 
	age?: number; // The age property is optional 
} 

const bob: Person = { name: "Bob" }; // This is valid 
const alice: Person = { name: "Alice", age: 25 }; // This is also valid
```

## TS non-null assertion !
Used after a variable name is known as the non-null assertion operator. This operator is a way to tell the TypeScript compiler that you are certain that a value is not `null` or `undefined` even when TypeScript's type checking would consider these as possibilities. It effectively removes `null` and `undefined` from the type of the operand, allowing you to access properties or methods without TypeScript raising type errors.


---

## Swift Optional ? and Unwrap Types !

In Swift, the exclamation mark (`!`) and question mark (`?`) are used to handle values that might be `nil`. These symbols are related to Swift's type safety features and its approach to dealing with the absence of values. Here's an overview of each and how they are used in Swift, particularly for iOS development.

### Question Mark (`?`): Optional Type

In Swift, a question mark (`?`) is used to declare an optional type. An optional is a type that can hold either a value or `nil` to indicate the absence of any value. Optionals are used extensively in Swift because they force developers to explicitly deal with `nil` values, preventing runtime errors related to null reference exceptions.

Here's how you declare and use optionals:

```swift
var name: String? = "Alice"
name = nil  // This is allowed because name is an optional

// Optional Binding to safely unwrap
if let safeName = name {
    print("The name is \(safeName)")
} else {
    print("The name is nil")
}
```

### Exclamation Mark (`!`): Forced Unwrapping and Implicitly Unwrapped Optionals

The exclamation mark (`!`) is used in two main contexts in Swift: forced unwrapping of optionals and declaring implicitly unwrapped optionals.

#### Forced Unwrapping

If you have an optional and you are sure that it is not `nil`, you can force-unwrap it with `!` to get its underlying value. This is risky and should only be done when you're absolutely sure the optional does contain a value, otherwise, your app will crash if the optional is `nil`.

```swift
var age: Int? = 30
print("Age is \(age!)")  // This will crash if age is nil
```

#### Implicitly Unwrapped Optionals

These are declared with `!` instead of `?`. They are assumed to always contain a value after they are first set and are mainly used in cases where a value cannot be set during initialization but can be guaranteed to be set before use, such as properties that need to be set immediately after initializing an object but must be non-nil while the object is in use.

```swift
var website: String!

// Later on
website = "https://example.com"
print("Website URL is \(website)")  // No need to unwrap
```

### Practical Uses in iOS Development

In iOS development, you frequently deal with optionals. For instance, when working with user interface elements where a property might not be set, or when handling data that could be missing (like JSON data from a network request).

- **Interface Builder Outlets:** Outlets are usually declared as implicitly unwrapped optionals because they are set up in the storyboard and connected before they are used.
  
  ```swift
  @IBOutlet weak var label: UILabel!
  ```

- **Handling Data Responses:** When parsing JSON data, you might declare variables as optionals because the keys might not exist.

  ```swift
  let json: [String: Any]? = ...
  let value = json?["key"] as? String
  ```

The use of `?` and `!` reflects Swift's emphasis on safety and clarity in code. By forcing developers to handle `nil` cases explicitly, Swift aims to reduce runtime crashes due to null references.