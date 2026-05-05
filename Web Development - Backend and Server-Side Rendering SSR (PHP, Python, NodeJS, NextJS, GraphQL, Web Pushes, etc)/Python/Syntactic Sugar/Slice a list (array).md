- **Slice Notation**: Using slice notation creates a new list that is a subset of the original list:

    
```
array = [1, 2, 3, 4]
shortened_array = array[1:]
    
# Creates a new list from the original, excluding the first element print(shortened_array)
# Output will be [2, 3, 4]
```

Reworded: Shift away the first item in a list:
```
some_list = some_list[1:]
```
    
In Python community discussions and documentation, "slicing" is the commonly used term for obtaining a subsequence of a list, array, string, or any other sequence type. It doesn't imply deletion from the original list but rather creating a new list from a selected range of elements.


---

Mnemonic. Remember that `some_list[0]` returns a specific element. But with the double quote, this returns more than one element - as a new list of elements.