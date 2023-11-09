

```
arr = ["a","b","c"]

assert "a" in arr, "a in arr - should be True"

assert 0 in range(len(arr)), "0 in range->len->arr - should be True"
```

length returns 3
range of 3 will return [0,1,2,]
and yes, 0 is in [0,1,2]

You can do for loop over the indexes of an array this way, then inside the for loop round, you can `arr[index]`

