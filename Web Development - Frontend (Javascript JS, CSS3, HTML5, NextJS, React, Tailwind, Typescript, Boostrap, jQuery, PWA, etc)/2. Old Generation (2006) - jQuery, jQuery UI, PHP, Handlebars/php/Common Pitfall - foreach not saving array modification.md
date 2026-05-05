foreach by default does NOT provide a reference to each element in the array, so any modifications made in the for-loops are reflected in the original array.

Here's how to explicitly make it by reference:
```
foreach ($array as &$element) {  
    // Modify $element  
}  
// Modifications to $element are reflected in $array
```


Status: Untested
Chat: https://chat.openai.com/c/d5e9940f-107d-4936-96fb-8aee25a58c49