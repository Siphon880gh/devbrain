
For example, to access the second value of the tuple associated with the key `2` in the dictionary, you would first access the tuple using the key, and then index into the tuple:

```python
my_dict = {
    1: ('apple', 'red'),
    2: ('banana', 'yellow'),
    3: ('cherry', 'red')
}

second_value = my_dict[2][1]  # Access the second item of the tuple associated with key 2
print(second_value)  # Outputs 'yellow'
```

In the line `second_value = my_dict[2][1]`, `my_dict[2]` retrieves the tuple `('banana', 'yellow')`, and the `[1]` accesses the second element of that tuple (since indexing in Python starts at 0).