
Place this after `var md = window.markdownit();` but before `var result = md.render(source); document.querySelector(".container").innerHTML = result;`

```
const defaultRender = md.renderer.rules.link_open || function(tokens, idx, options, env, self) {
    return self.renderToken(tokens, idx, options);
};

md.renderer.rules.link_open = function (tokens, idx, options, env, self) {
    // Add a "target" attribute

    tokens[idx].attrPush(['target', '_blank']);

    // Add a "rel" attribute to prevent potential security issues with `target="_blank"`

    tokens[idx].attrPush(['rel', 'noopener noreferrer']);

    // pass token to default renderer.

    return defaultRender(tokens, idx, options, env, self);
};
```