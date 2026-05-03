
You can have a Code Node that will pass the same inputs to the outputs, allowing you to see that data through the window of the "Outputs" on the right.

![[Pasted image 20250705232836.png]]

The inputs on the left will show on the right inside the Code Node (data not shown):
![[Pasted image 20250705232915.png]]

The Javascript should be:
```
return $input.all();
```

You can disable all the debug points
![[Pasted image 20250705232953.png]]

So that if an issue arrives later, you can re-activate the debug point that's possibly close to the issue

A deactivated node wont break the workflow. The data will just pass through unaltered (although our Code Node doesn't alter the data anyways)
![[Pasted image 20250705233142.png]]