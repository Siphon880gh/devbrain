To set the class list of an HTML element using JavaScript, you can use the `classList` property and assign a string of classes separated by spaces. Here's an example:

```javascript
const element = document.getElementById("yourElementId"); // Replace "yourElementId" with the actual ID of your element
element.classList = "flex row";
```

In the example above, `getElementById("yourElementId")` retrieves the element with the specified ID. Then, `classList` is set to the string `"flex row"`, which assigns the classes "flex" and "row" to the element.

Please make sure to replace `"yourElementId"` with the actual ID of the element you want to modify.