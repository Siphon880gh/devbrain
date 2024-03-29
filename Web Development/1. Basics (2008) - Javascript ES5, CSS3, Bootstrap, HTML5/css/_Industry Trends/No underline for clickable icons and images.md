You want to retain the underline for `<a>` links but not `<a><span class="fa...` or `<a><img...`

This css does exactly that by removing underline if a tag has a direct child that is font awesome or img

```
a:has(> img), a:has(> .fa), a:has(> .fas) { 
	text-decoration: none;
}
```