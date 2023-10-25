
Yes, you can make a `<textarea>` element automatically expand to fit its content using a combination of JavaScript and CSS. Here's a simple approach to achieve this:

1. **CSS**: Reset the default `overflow` and `resize` properties of the `<textarea>`.

```css
.auto-expand {
    overflow-y: hidden;  /* Hide vertical scrollbar. */
    resize: none;        /* Disable textarea resizing. */
}
```

2. **JavaScript**: Adjust the height of the `<textarea>` based on its scroll height.

```javascript
document.addEventListener('input', function (e) {
    if (e.target.tagName.toLowerCase() === 'textarea' && e.target.classList.contains('auto-expand')) {
        e.target.style.height = 'auto';             // Reset height to auto before calculating the scroll height.
        e.target.style.height = e.target.scrollHeight + 'px';
    }
});
```

3. **HTML**: Apply the `auto-expand` class to any `<textarea>` that you want to have this behavior.

```html
<textarea class="auto-expand"></textarea>
```

Now, as you type or paste content into the `<textarea>`, it will automatically expand in height to fit its content.

Keep in mind that this is a basic approach. Depending on the specific requirements and use cases, you might need to make some adjustments. For instance, if you want to set a maximum height for the expanding textarea, you can adjust the CSS and JavaScript accordingly.