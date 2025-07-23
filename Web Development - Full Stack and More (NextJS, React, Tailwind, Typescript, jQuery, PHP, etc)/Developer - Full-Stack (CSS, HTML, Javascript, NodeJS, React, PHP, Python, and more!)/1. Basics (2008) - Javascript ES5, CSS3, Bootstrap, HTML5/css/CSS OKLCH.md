`oklch` is **natively supported by modern browsers** starting from **Chrome 111, Edge 111, Safari 16.4, and Firefox 113**. It is not exclusive to ShadCN.

### **Native Browser Support**

You can use `oklch` directly in CSS without relying on ShadCN or Tailwind:
```
body {
  background-color: oklch(70% 0.2 200);
  color: oklch(30% 0.1 220);
}
```

Since it is part of the **CSS Color 4 specification**, more browsers will continue to support it over time.

### **Why Use?**

`oklch` provides better color consistency, contrast, and accessibility when defining design tokens.