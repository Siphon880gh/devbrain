
<<
I have a bunch of elements with class name "font-row". How to make them alternate background-colors

\>>
To make elements with the class name "font-row" have alternating background colors, you can use the `:nth-child` pseudo-class in CSS. Here's how you can achieve this:

1. **Using `:nth-child` with even and odd values**:
```css
.font-row:nth-child(odd) {
    background-color: #f2f2f2; /* or any color you prefer for odd rows */
}

.font-row:nth-child(even) {
    background-color: #e0e0e0; /* or any color you prefer for even rows */
}
```

2. **Using `:nth-of-type`**:
If your elements are not direct siblings or if there are other elements in between, you might want to use `:nth-of-type` instead:
```css
.font-row:nth-of-type(odd) {
    background-color: #f2f2f2;
}

.font-row:nth-of-type(even) {
    background-color: #e0e0e0;
}
```

3. **Using JavaScript (jQuery)**:
If you prefer a JavaScript solution, especially if you're already using jQuery, you can do:
```javascript
$(document).ready(function() {
    $(".font-row:odd").css("background-color", "#f2f2f2");
    $(".font-row:even").css("background-color", "#e0e0e0");
});
```

Choose the method that best fits your needs. The CSS solution is generally preferred as it's more efficient and doesn't rely on JavaScript. However, if you have a more dynamic page where elements are being added or removed, the JavaScript solution might be more appropriate.