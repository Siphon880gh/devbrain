```
tp = (1,2)
tp2 = (3,4)
lst = [tp,tp2];
for x1,x2 in lst:
  print(x1, x2)
```

Here's a breakdown of how it works:

Tuple Creation: Two tuples, tp and tp2, are created with values (1, 2) and (3, 4) respectively.
List Creation: A list named lst is created containing the tuples tp and tp2.
Looping through the List: The for loop iterates over each element in lst. Since each element is a tuple, the loop uses tuple unpacking to extract the values into variables x1 and x2.
Printing Values: Inside the loop, the values x1 and x2 are printed. For each tuple in lst, this will print the first and second elements of the tuple.

Output:
(1, 2)
(3, 4)