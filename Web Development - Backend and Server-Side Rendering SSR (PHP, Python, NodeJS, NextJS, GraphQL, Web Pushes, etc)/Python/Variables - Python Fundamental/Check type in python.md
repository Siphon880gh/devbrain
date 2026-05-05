
```
isinstance(MOTION_EFFECTS[i], list):
```

^ Returns true or false

More practical:
```
def check_variable_type(variable): if isinstance(variable, list): return "list" elif isinstance(variable, tuple): return "tuple" elif isinstance(variable, array.array): return "array.array" elif isinstance(variable, np.ndarray): return "numpy.ndarray" else: return "not an array/list"
```