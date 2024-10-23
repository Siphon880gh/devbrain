
```
<Image
  source={{ uri: 'your_image_url' }}
  style={{ width: 200, height: 200 }}
  resizeMode="contain" // Options: "cover", "contain", "stretch", "repeat", "center"
/>
```

**Key values for `resizeMode`:**
- **`contain`**: Scales the image to fit within the given dimensions without cropping.
- **`cover`**: Scales the image to fill the given dimensions, cropping if necessary.
- **`stretch`**: Stretches the image to fill both `width` and `height` (can distort the image).
- **`center`**: Centers the image within the dimensions without scaling.
  
You can adjust `resizeMode` based on how you want to handle image scaling. For preserving the aspect ratio, `contain` or `cover` is typically recommended.