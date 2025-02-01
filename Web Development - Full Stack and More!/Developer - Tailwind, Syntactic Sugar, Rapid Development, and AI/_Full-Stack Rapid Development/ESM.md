esm.sh is a modern CDN that allows you to import [es6 modules](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules) from a URL:

```javascript
import Module from "https://esm.sh/PKG@SEMVER[/PATH]";
```


This is Rapid because there's no build step. And you can be specific about the version, like:

```
import confetti from "https://esm.sh/canvas-confetti@1.6.0"
```


