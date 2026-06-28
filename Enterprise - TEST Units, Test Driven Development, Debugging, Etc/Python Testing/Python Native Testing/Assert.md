In Python, an `assert` statement is used to set a condition that you expect to hold true at a certain point in the code. If the condition is `True`, the program continues to execute. If the condition is `False`, the program raises an `AssertionError` exception with the optional error message provided.

Here's the syntax:

```python
assert condition, "Error message if condition is False"
```

For example:

```python
x = 5
y = 10
assert x == y, "x should have equaled y"
```

In this example, the `assert` statement would cause an `AssertionError` because `x` does not equal `y`, and the error message "x should have equaled y" would be displayed.