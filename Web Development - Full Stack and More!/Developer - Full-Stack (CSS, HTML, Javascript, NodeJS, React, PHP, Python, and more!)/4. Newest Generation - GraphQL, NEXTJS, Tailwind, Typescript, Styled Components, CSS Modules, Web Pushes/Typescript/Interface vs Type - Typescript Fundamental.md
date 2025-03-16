In TypeScript, both `interface` and `type` are used to define the shape of data (like objects). They are often interchangeable, but there are certain scenarios and features that might lead you to choose one over the other. Here's a comparison to help you understand when and why you might use `interface` instead of `type`:
### Interface
1. **Extension**: Interfaces are extendable. They can be extended by other interfaces to create new ones. This can be very handy in a scenario where you have objects with a shared base set of properties. Extension promotes a clear inheritance structure and can be more intuitive when you're modeling objects that fit into a hierarchical class-like structure.
2. **Declaration Merging**: Interfaces can be declared multiple times and they will be merged into a single definition. This is particularly useful in augmentation of existing types or in modular code where an interface might be extended or augmented in different files.
3. **Implementing in Classes**: When working with classes, `implements` is typically used with interfaces, which can be a more natural fit for OO-style programming.
4. **Intention**: By using an interface, you are signaling that the object being defined is meant to be an API or an object that's expected to be implemented/extended.

### Type
1. **Union and Intersection Types**: Types can define unions and intersections that allow you to combine existing types in various ways, creating a powerful and flexible way to express complex type relationships.
2. **Mapped Types**: You can use mapped types with `type` to create new types based on transformations of existing ones, which is powerful for a wide range of applications.
3. **Type Operations**: Types can perform certain operations like picking certain properties from an existing type (`Pick`), or omitting properties from a type (`Omit`).

### When to Use Interface over Type

Considering the above, you might choose to use an `interface` over a `type` when:
1. **You Expect Extension or Inheritance**: If you're designing a complex object structure where you expect entities to extend or implement the base objects, interfaces are a natural fit.
2. **You're Defining a Public API**: If you're creating a public API for a library or a service, interfaces can signal that these objects are meant to be implemented or extended, following a contract-like pattern.
3. **You Need Declaration Merging**: In scenarios involving augmentation of existing types, especially in modular projects, interfaces can be a great tool due to their ability to merge declarations.
  
### General Advice
- **Interchangeability**: For many scenarios, `type` and `interface` are interchangeable. If you're not sure which to use, and you don't need the specific features of interfaces, a `type` might be simpler. It's often a matter of personal or team preference.
- **Consistency**: Consistency is key in a codebase. If your team or project has a convention, it's generally best to stick with it unless there's a specific reason to use the other.
- **Evolution of TypeScript**: TypeScript has evolved over time, and the differences between `type` and `interface` have blurred with newer versions. Always check the current capabilities of TypeScript when making a decision.

In summary, whether you choose `interface` or `type` often comes down to the specific needs of your application, personal or team preferences, and the context in which you're working. Both are powerful constructs that can effectively describe the shape of data in TypeScript.