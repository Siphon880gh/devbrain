In Python, the term "list" is used to refer to the built-in data type that is an ordered collection of items, which can be of mixed types. The term "array" in other programming languages often refers to a similar concept but usually with the requirement that all items be of the same type.

Python does have arrays in the form of the `array` module, which is used for compact storage of basic data types like bytes, integers, floats, etc., but this is less commonly used than lists for general purposes. When you use the `array` module, it is more akin to arrays in languages like C, as it is meant for more efficient storage of numerical data.

Here's how you can use an array from the `array` module:

```python
import array

# Creates an array of integer type ('i' is the type code for integers)
int_array = array.array('i', [1, 2, 3, 4])
```

For most cases in Python, when you hear someone refer to an "array," they are typically talking about a "list," unless they specifically mention they are using the `array` module or a third-party library like NumPy which provides a more powerful array type suitable for numerical computations.