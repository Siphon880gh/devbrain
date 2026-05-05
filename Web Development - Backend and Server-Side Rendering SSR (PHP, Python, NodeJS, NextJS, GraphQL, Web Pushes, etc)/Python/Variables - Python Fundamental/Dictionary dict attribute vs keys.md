
- dictionary keys are accessed with square bracket notation
- dictionary attributes (not your custom data points) are accessed with dot notation


my_dict = {
    "delay_start": 3,
    "duration": 360,
    "volume": 0.5,
    "path": "pics - grandmas/tea-time-135015.mp3"
}

# Correct way to access a value in a dictionary:
duration = my_dict['duration']

In Python, dictionaries have a set of built-in methods that you can call on them. These methods are sometimes referred to as dictionary attributes or properties. Here are some common dictionary attributes/methods:

1. `.keys()`: This method returns a view object that displays a list of all the keys in the dictionary.
2. `.values()`: Similar to `.keys()`, but returns a view of all the values in the dictionary.
3. `.items()`: Returns a view of the dictionary's key-value pairs (as tuples).
4. `.get(key, default=None)`: This method returns the value for the specified key if the key is in the dictionary. If not, it returns `None` or a specified default value.
5. `.clear()`: Removes all items from the dictionary.
6. `.pop(key[, default])`: Removes the specified key and returns the corresponding value. If the key is not found, default is returned if provided, otherwise KeyError is raised.
7. `.update([other])`: Updates the dictionary with the key-value pairs from another dictionary or from an iterable of key-value pairs.
8. `.copy()`: Returns a shallow copy of the dictionary.
9. `.setdefault(key[, default])`: Returns the value of a key if it is in the dictionary; if not, it inserts the key with a value of default and returns default.

These attributes/methods are part of the dictionary's own built-in functionality, and they're not to be confused with the individual items you can store within a dictionary. When you want to work with the contents of a dictionary, you'll typically use the keys to access values, or the methods mentioned above to manipulate the dictionary as a whole.