Type guards are a TypeScript feature that allows you to narrow down the type of a variable within a conditional block. Essentially, they let you inform TypeScript about the type of a variable when the type isn't known at compile time.

**Example of Type Guards:**

```typescript
function isString(test: any): test is string {
    return typeof test === "string";
}

function example(foo: any) {
    if (isString(foo)) {
        // foo is treated as a string only within this block
        console.log(foo.toUpperCase());
    } else {
        console.log(foo);
    }
}
```

In this example, `isString` is a user-defined type guard. Notice the `test is string` part, which tells TypeScript that whenever the `isString` function returns true, the `test` variable should be treated as a string at the applicable block or scope.

### Type Assertions
Type assertions are a way to tell the TypeScript compiler to treat an entity as a different type than the type inferred by it. It’s like type casting in other languages but does not perform any special checking or restructuring of data.

**Example of Type Assertions:**

Let's say
```typescript
let someValue: any = "this is a string";
```

Then
```
let strLength: number = (someValue as string).length;
// Or
let strLengthAlternative: number = (<string>someValue).length;
```

Here, `someValue` is declared as `any`, but we assert that `someValue` is a string when accessing its length.

### Mapped Types
Mapped types allow you to take an existing model and transform each of its properties into a new type. They are a powerful feature to create new types based on old types programmatically.

**Example of Mapped Types:**

```typescript
type Readonly<T> = {
    readonly [P in keyof T]: T[P];
};

type Optional<T> = {
    [P in keyof T]?: T[P];
};

type Person = {
    name: string;
    age: number;
};

type ReadonlyPerson = Readonly<Person>;
type OptionalPerson = Optional<Person>;
```

`ReadonlyPerson` is a new type where each property of `Person` is read-only. `OptionalPerson` makes each property of `Person` optional.

