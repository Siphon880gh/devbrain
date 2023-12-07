In python I have a list [1,2,3,4]

I want to create another list of size N
How to have the code circle through 1,2,3,4,1,2,3,4,1... N

```
original_list = [1, 2, 3, 4]  
N = 10  # Example size for the new list  
  
new_list = []  
  
for i in range(N):  
    # Append the element at current index mod the length of the original list  
    new_list.append(original_list[i % len(original_list)])  
  
print(new_list)
```