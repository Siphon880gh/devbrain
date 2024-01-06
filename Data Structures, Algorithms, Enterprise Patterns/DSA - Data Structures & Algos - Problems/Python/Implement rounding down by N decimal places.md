
```
import math  
  
def round_down(n, decimals=2):  
    multiplier = 10 ** decimals  
    return math.floor(n * multiplier) / multiplier  
  
# Example  
number = 41.9999  
rounded_number = round_down(number)  
print(rounded_number)  # Output: 41.99
```