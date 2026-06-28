

In JavaScript, to check if an element has the `disabled` attribute, you can use the `hasAttribute` method on the element. Here's a step-by-step guide on how you can do this:

1. **Select the Element**: First, you need to have a reference to the DOM element you want to check. You can select an element using methods like `document.getElementById()`, `document.querySelector()`, etc.

   ```javascript
   var element = document.getElementById('myElement'); // Replace 'myElement' with your element's ID
   ```

2. **Check for the Attribute**: Once you have the element, you can use the `hasAttribute` method to check if the `disabled` attribute is present.

   ```javascript
   if (element.hasAttribute('disabled')) {
       console.log('The element is disabled.');
   } else {
       console.log('The element is not disabled.');
   }
   ```

Here's how you might use this in a complete snippet:

```javascript
// Select the element
var element = document.getElementById('myElement'); // Replace with your element's ID

// Check if the 'disabled' attribute is present
if (element.hasAttribute('disabled')) {
    console.log('The element is disabled.');
} else {
    console.log('The element is not disabled.');
}
```

Remember to replace `'myElement'` with the actual ID or selector for your element. This code will log to the console whether the element is disabled or not based on the presence of the `disabled` attribute.