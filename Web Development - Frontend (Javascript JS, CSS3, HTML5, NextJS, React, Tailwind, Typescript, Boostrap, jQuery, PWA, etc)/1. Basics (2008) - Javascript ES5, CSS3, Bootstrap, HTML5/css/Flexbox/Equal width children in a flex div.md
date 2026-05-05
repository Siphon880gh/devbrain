Flexbox is a CSS layout module that makes it easy to design flexible and efficient layouts. It is particularly useful for distributing space and aligning items in a container, even when their size is unknown or dynamic.

When you want to equally divide children in a flex container, you need to use the `display: flex;` property on the parent element. This will turn the parent into a flex container, and its direct children will become flex items.

Here's a basic example:

```html
<div class="flex-container">
  <div class="flex-child">Child 1</div>
  <div class="flex-child">Child 2</div>
</div>
```

```css
.flex-container {
  display: flex;
}

.flex-child {
  flex: 1;
}
```

In this CSS, `flex: 1;` is shorthand for `flex-grow: 1; flex-shrink: 1; flex-basis: 0%;`. It means that each child will grow to fill the space equally. The `flex-grow` property defines the ability for a flex item to grow if necessary, so setting it to 1 ensures that all children will share the available space equally.
