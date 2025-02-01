
### Syntax

ES6 (ECMAScript 2015) introduced the native `import` and `export` syntax for modules, which provides a more standardized and powerful way of handling modules compared to CommonJS's `require()`. 

However, `require()` is still available in environments that use CommonJS, such as Node.js, for backward compatibility.

### URL to module

esm.sh is a modern CDN that allows you to import [es6 modules](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules) from a URL:

```
import confetti from "https://esm.sh/canvas-confetti@1.6.0"
```

Instead of having to do `npm install` for that module.
