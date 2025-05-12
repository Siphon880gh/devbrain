User might accidentally select text/pictures and then have blue highlighting regions. This breaks the feeling it’s an app.

So:
```
.noselect {
  user-select: none; /* Standard for modern browsers */
  -webkit-user-select: none; /* For Safari */
  -moz-user-select: none; /* For older versions of Firefox */
  -ms-user-select: none; /* For Internet Explorer/Edge */
}
```


