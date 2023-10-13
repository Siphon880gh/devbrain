Yes, Python allows the definition of nested functions, which are functions defined inside other functions. The inner function (or nested function) can access variables from the outer function, but the outer function cannot access variables from the inner function (unless they are returned or passed as parameters).

Here's a simple example of a nested function:

```python
def outer_function(x):
    def inner_function(y):
        return x + y
    return inner_function(5)

result = outer_function(10)
print(result)
```

In the example above:

1. The `outer_function` takes a parameter `x`.
2. Inside `outer_function`, we define an `inner_function` that takes a parameter `y`.
3. The `inner_function` returns the sum of `x` and `y`.
4. The `outer_function` calls `inner_function` with `y` set to `5` and returns the result.
5. When we call `outer_function(10)`, it returns `15` because `10 + 5 = 15`.

Nested functions can also be used to create closures, which are a way to retain the state or values even after the outer function has finished execution. Would you like to see an example of that?