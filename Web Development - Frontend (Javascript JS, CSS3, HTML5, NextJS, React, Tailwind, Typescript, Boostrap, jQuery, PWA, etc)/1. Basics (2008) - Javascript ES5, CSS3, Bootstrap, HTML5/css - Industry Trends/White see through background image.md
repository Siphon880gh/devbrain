
If you want to apply a white filter over the background image to make it appear vivid white, you can use a pseudo-element such as `::before` or `::after` to create the overlay effect. Here's how you can do it:

```css
body::before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.7); /* Adjust the opacity as needed */
  z-index: -1; /* Place it below the content */
}

body {
  background: url("assets/background.jpg") no-repeat center center fixed;
  background-size: cover;
}
```

In this example, we're using the `::before` pseudo-element to create a white overlay with a specified opacity (in this case, 0.7 to make it semi-transparent). Adjust the opacity value to your preference. The `z-index` property is set to -1 to ensure that the overlay is placed below the content.

This will create a white filter over your background image, making it appear vivid white.