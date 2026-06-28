To make an image appear all white using CSS, you can use the `filter` property to apply a high brightness value to the image, effectively making it white. Here's how you can do it:

```css
img {
  filter: brightness(100);
}
```

This CSS rule applies to all `<img>` tags in your HTML and sets the brightness to a very high value (100 times the normal brightness), which will make the image appear all white. If the image still shows some detail, you can increase the brightness value further.

Here's an example of how to use this in your HTML:

```html
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>White Image Example</title>
<style>
  img {
    filter: brightness(100);
  }
</style>
</head>
<body>
  <img src="path_to_your_image.jpg" alt="Sample Image">
</body>
</html>
```

Replace `"path_to_your_image.jpg"` with the actual path to your image. This should render the image in white, obscuring its original content.