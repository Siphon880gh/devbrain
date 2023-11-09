
In Python, formatted strings can be created in several ways:

1. **f-strings** (Literal String Interpolation) - Introduced in Python 3.6, this is a convenient and readable way to create formatted strings. You prefix the string with `f` or `F` and write expressions inside curly braces `{}` which will be evaluated at runtime and formatted using the specified format.

    ```python
    name = "Alice"
    age = 30
    greeting = f"Hello, {name}. You are {age} years old."
    print(greeting)  # Output: Hello, Alice. You are 30 years old.
    ```

    You can also include format specifiers:

    ```python
    number = 123.4567
    formatted_number = f"{number:.2f}"  # Rounds to two decimal places
    print(formatted_number)  # Output: 123.46
    ```

2. **str.format() method** - Before f-strings, this was a common way to create formatted strings. The placeholders `{}` are replaced by the arguments provided to the `format()` method in order.

    ```python
    name = "Bob"
    age = 25
    greeting = "Hello, {}. You are {} years old.".format(name, age)
    print(greeting)  # Output: Hello, Bob. You are 25 years old.
    ```

    You can also use positional or keyword arguments:

    ```python
    greeting = "Hello, {1}. You are {0} years old.".format(age, name)
    print(greeting)  # Output: Hello, Alice. You are 30 years old.
    ```

    And with explicit indices or names:

    ```python
    greeting = "Hello, {name}. You are {age} years old.".format(name=name, age=age)
    print(greeting)  # Output: Hello, Bob. You are 25 years old.
    ```

3. **Percent (%) formatting** - An older method that uses the `%` operator. It's less readable and versatile than the previous two methods, but you might encounter it in older Python code.

    ```python
    name = "Charlie"
    age = 40
    greeting = "Hello, %s. You are %d years old." % (name, age)
    print(greeting)  # Output: Hello, Charlie. You are 40 years old.
    ```

Each of these methods allows you to format strings in a different way, but the preferred modern method is to use f-strings for their clarity and performance.