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