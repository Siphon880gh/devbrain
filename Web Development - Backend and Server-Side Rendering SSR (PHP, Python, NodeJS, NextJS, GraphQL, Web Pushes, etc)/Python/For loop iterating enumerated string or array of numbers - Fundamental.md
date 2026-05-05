For loop iterating enumerated string or array of numbers
Can take string or array of numbers
```
for index,value in enumerate(someString)
```

```
def twoSum(nums, target):
  numMap = {}
  for i, num in enumerate(nums):
    complement = target - num
    if complement in numMap:
      return [numMap[complement], i]
    numMap[num] = i
  return []
```

---

## All through the array

Goes from 0 to length-1 
``` 
for i in range(len(some_list)): 
``` 


  

---

  

## Offsetting the start

Goes from 1 to length -1

In Python, the `range()` function allows you to generate a sequence of numbers. By default, it starts at 0 and increments by 1. If you want to start the sequence at 1 and end at `len(equally_divided)-1`, you would adjust the start and stop values like this:

  

```python

for i in range(1, len(some_list)):

    # Your code here

```

  

This loop will start `i` at 1 and go up to, but not include, `len(equally_divided)`, effectively giving you the numbers from 1 to `len(equally_divided)-1`.


---

Iterating keys  in an array
        for i in range(1, len(floored)):

        for i in range(1, len(floored)):

Iterating values  in an array
        for value in some_list


Logically why: range creates a list of countable numbers (aka discrete numbers). Therefore, it’s values acting like keys for your array.