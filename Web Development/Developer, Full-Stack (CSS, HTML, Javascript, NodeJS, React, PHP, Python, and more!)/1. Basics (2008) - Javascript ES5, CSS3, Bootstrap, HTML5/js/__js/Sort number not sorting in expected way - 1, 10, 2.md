
`[1,10,4,3].sort()` gives `[1,10,3,4]`


In JavaScript, the default behavior of the `.sort()` method on an array treats each element as a string. Therefore, when you sort an array of numbers without providing a comparison function, it sorts the numbers lexicographically (as if they were words, not numbers). This is why you see an order like `1, 10, 2, 3` instead of `1, 2, 3, 10`.

To sort numbers numerically, you need to pass a comparison function to the `.sort()` method that handles numerical values correctly. Here’s how you can do it:

```javascript
let numbers = [1, 10, 2, 3];
numbers.sort(function(a, b) {
  return a - b;
});

console.log(numbers);
```

This comparison function takes two numbers from the array, subtracts one from the other, and returns the result. If the result is negative, `a` is placed before `b`. If it's positive, `b` is placed before `a`. This will sort the array in ascending numerical order.

Now it gives what you expect:
`[1,3,4,10]`