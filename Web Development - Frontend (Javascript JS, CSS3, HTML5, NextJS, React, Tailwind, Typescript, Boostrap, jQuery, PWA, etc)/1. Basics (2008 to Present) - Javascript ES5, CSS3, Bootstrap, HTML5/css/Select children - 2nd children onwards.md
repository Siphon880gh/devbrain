
```
            .audios-list > :nth-child(n+2) {
                margin-top: 1rem;
            }
```

This is because from n=0,1,2,... infinity
The actual indexes will be  0+2, 1=1,2=1.. infinity, which is 2,3,.. infinity
CSS classes are counted from 1 to infinity
Therefore this is 2nd child onwards

---

Reworded:
The `:nth-child(n+2)` selector in CSS targets all children of a parent starting from the second child onwards. Here's a breakdown of how it works:

- `n` is a counter that starts at 0 and increments by 1 (0, 1, 2, 3, ...).
- `n+2` means "start counting from 2" (so when `n` is 0, `n+2` is 2; when `n` is 1, `n+2` is 3, and so on).

When you apply `:nth-child(n+2)`, you're effectively saying, "Select every child from the 2nd one onwards." This is because when `n` is 0 (the starting point), `n+2` equals 2, targeting the second child. As `n` increments (1, 2, 3, ...), `n+2` targets the 3rd, 4th, 5th, etc., children, effectively selecting all children from the second one onwards.

Here's an example to illustrate:

```html
<ul>
  <li>First item</li>
  <li>Second item</li>
  <li>Third item</li>
  <li>Fourth item</li>
</ul>
```

```css
li:nth-child(n+2) {
  color: red;
}
```

In this example, the second, third, and fourth items will be colored red because they are matched by `:nth-child(n+2)`. The first item remains unaffected because it's not selected by this pseudo-class.