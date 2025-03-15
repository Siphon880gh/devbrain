<<
React is complaining about my for in <label for="id">

>>
In React, you should use the `htmlFor` attribute instead of `for` when working with labels. The reason for this is that `for` is a reserved keyword in JavaScript, so using it directly in JSX will cause a syntax error.

Here's an example of how you should write the `label` element in JSX:

```
<label htmlFor="id">Label Text</label>
```

In this example, `htmlFor` is used instead of `for`, and "id" should be replaced with the actual ID of the element you want to associate the label with.

Using `htmlFor` ensures that the JSX code is correctly transpiled to JavaScript and avoids any potential conflicts with the reserved `for` keyword.