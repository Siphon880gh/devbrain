
Div margin 0 auto centering only works if parent div has a width


Yes, in most cases, for a child div with `margin: 0 auto` to center itself horizontally within a parent div, the parent div should have a specified width. 

Here's why:

1. **Auto Margins**: When you set `margin: 0 auto` on a block-level element like a `<div>`, it tells the browser to automatically calculate and distribute equal margins on the left and right sides of the element. This centers the element horizontally within its containing block.

2. **Containing Block**: The containing block is the nearest ancestor element that establishes the context for positioning and sizing of an element. In the case of horizontal centering using `margin: 0 auto`, the containing block is typically the parent element.

3. **Width of Containing Block**: For the auto margins to work correctly and center the child element horizontally, the containing block (parent element) must have a specified width. If the parent element doesn't have a width defined, it will typically expand to fill the available horizontal space, and there won't be any space left for the child element to center itself within.

Here's an example of HTML and CSS to illustrate this concept:

```html
<div class="parent">
  <div class="child">Centered</div>
</div>
```

```css
.parent {
  width: 300px; /* Set a specific width for the parent */
  background-color: lightgray;
}

.child {
  margin: 0 auto; /* Center the child horizontally */
  width: 200px; /* Set a specific width for the child (optional) */
  background-color: lightblue;
}
```

In this example, the child `<div>` will be centered horizontally within its parent because the parent has a specified width.

If you remove the `width` property from the parent, the child won't be able to center itself because the parent will expand to fill the available width of its container.

So, to achieve horizontal centering using `margin: 0 auto`, ensure that the parent div has a specified width. If you want the parent to expand based on its content but still center the child, you can use other techniques like `display: flex` or `text-align: center` on the parent element.