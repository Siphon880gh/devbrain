
To achieve a CSS style where text is limited to a width of 100px and an ellipsis ("...") is added when the text overflows, you can use the `text-overflow`, `overflow`, and `white-space` properties in conjunction with a fixed width. Here is an example of how to do this:

```css
.ellipsis {
  width: 100px;        /* Set the width of the container to 100px */
  white-space: nowrap; /* Ensure the text stays in a single line */
  overflow: hidden;    /* Hide the overflowed text */
  text-overflow: ellipsis; /* Add ellipsis at the end of the text */
}
```

And in your HTML, you would use this class for the elements you want to apply this style to:

```html
<div class="ellipsis">This is some long text that will be cut off with an ellipsis.</div>
```

This code will ensure that any text inside an element with the class `ellipsis` will be confined to a width of 100px. If the text exceeds this width, it will be truncated and an ellipsis ("...") will be displayed at the end of the visible text.