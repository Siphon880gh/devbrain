

Access parent document from within an iframe
```
var parentWindow = window.parent.document;
```

-- OR --

Use JavaScript in the parent page to get a reference to the iframe's window:

```
var iframeWindow = document.querySelector('iframe').contentWindow;
```

Once you have the iframeWindow, you can access the global variables, functions, and the DOM of the iframe's document

---

Reworded:
```
// We are inside iframe and want to access parent window
var parentWindow = window.parent.document;

// We want to access an iframe's content
var iframeWindow = document.querySelector('iframe').contentWindow;
```
