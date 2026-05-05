### Main benefits
- When writing generic **libraries or utilities** where the operations performed depend on the types of the inputs. The variability here is that the developer using your library or utility may use other types.
- During run time: Conditional types allow the codebase to adapt its behavior based on the types of the data it processes. For instance, handling different **API responses** differently based on their structure, or adapting UI components based on the data they are supposed to display, all while ensuring type safety and reducing the risk of runtime type errors.

### Basic

Conditional types in TypeScript are a bit like ternary operators at the type level: they select one of two possible types based on a condition expressed as a type relationship test.

**Example of Conditional Types:**

typescriptCopy code

```
type Check<T> = T extends string ? "String" : "Not String";

type Type1 = Check<string>;  // Type1 is "String"
type Type2 = Check<number>;  // Type2 is "Not String"
```

This uses the ternary-like syntax to check if `T` extends `string`. If yes, it resolves to `"String"`, otherwise to `"Not String"`.

---

### Polymorphic function
Imagine you are building a function that needs to handle both single and array inputs. You can use conditional types to create a type that automatically adjusts its output based on whether the input is an array or a single item.

```typescript
type Unpacked<T> = T extends (infer U)[] ? U : T;

function unwrapOrFirst<T>(arg: T): Unpacked<T> {
    if (Array.isArray(arg)) {
        return arg[0];  // correct type is inferred
    }
    return arg; // correct type is inferred
}

let single = unwrapOrFirst(123);  // single is inferred as number
let array = unwrapOrFirst([1, 2, 3]);  // array is inferred as number
```

This kind of dynamic and intelligent behavior based on types is what makes TypeScript's type system particularly powerful for developing complex applications.

### API Responses


In many real-world applications, API responses can vary significantly, often depending on whether the request was successful or if an error occurred. You might receive either a data object or an error message. Conditional types can be extremely helpful here to ensure type safety across different response types.

#### TypeScript Setup

First, define some basic types for the responses and the API fetch function:

```typescript
// API response types
interface ApiResponse<T> {
    data: T;
    error: null;
}

interface ApiError {
    data: null;
    error: string;
}

// Conditional type to determine the response structure
type HandleApiResponse<T> = T extends { error: null } ? T['data'] : T['error'];

// Function to simulate fetching data
async function fetchData<T>(url: string): Promise<ApiResponse<T> | ApiError> {
    try {
        const response = await fetch(url);
        const data: T = await response.json();
        return { data, error: null };
    } catch (error) {
        return { data: null, error: 'Failed to fetch data' };
    }
}
```

#### Using Conditional Types in Practice

With the API set up, you can use conditional types to handle different types of responses in a type-safe manner:

```typescript
async function processUserData(url: string) {
    const result = await fetchData<{ name: string; age: number }>(url);

    // Use a type guard to check the response structure
    if (result.error === null) {
        const userData: HandleApiResponse<typeof result> = result.data;
        console.log('User data:', userData);
    } else {
        const errorMessage: HandleApiResponse<typeof result> = result.error;
        console.error('Error fetching user data:', errorMessage);
    }
}
```

#### Explanation

1. **Type Definitions**:
   - `ApiResponse<T>` and `ApiError` define the possible shapes of responses from any API.
   - `HandleApiResponse<T>` is a conditional type that checks if the response contains an error. If `error` is `null`, it extracts the type of `data`; otherwise, it extracts the type of `error`.

2. **Fetch Function**:
   - `fetchData<T>` simulates an API request. It attempts to fetch data and parse it as JSON. If successful, it returns data; otherwise, it returns an error object.

3. **Processing Function**:
   - `processUserData` uses `fetchData` to request user data. It then checks the result using a simple conditional check (a JavaScript-level runtime check) and processes the response accordingly.
   - TypeScript ensures that the handling of `userData` and `errorMessage` is type-safe according to the structure defined by the conditional type.

This example showcases how TypeScript's conditional types can be used to manage different response structures from APIs, providing compile-time safety checks that help avoid common errors like accessing properties on `null` or undefined values. This approach not only reduces runtime errors but also makes the code more predictable and easier to maintain.