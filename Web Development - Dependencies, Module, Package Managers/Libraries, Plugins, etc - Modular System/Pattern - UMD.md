UMD - Aka Universal Module Definition

UMD, or Universal Module Definition, is a module definition format that aims to be compatible with both CommonJS and AMD, and as a global variable if neither available. It also allows you to export the module as a global variable that you can include in your application through a simple `<script>` tag.

Reworded: An UMD file is structured in the UMD pattern, making it compatible with various module systems like AMD and CommonJS, as well as usable as a global variable in environments without a module loader.

So the traditional `<script src="..."/>` works if nothing else.

Usually the file is named like:
`http://www.to.cdn.path/index.umd.js
`

---

How to find js libraries on Google that are UMD that lets you connect to the script file directly in the HTML? You dont want to bother with using webpack or rollup because it's a small app / website that you want to finish asap.

Search for:
js __library__ umd

---

**Case Study**
Used ChatGPT because was trying to add a markdown-it script called markdown-it-anchor, but all the instructions seem to be for the require() version.

\<<
still doesnt work. is the markdownitanchor here universal module (umd)?

\>>
The issue you're experiencing might be related to the module format of `markdown-it-anchor`. It's possible that the version of `markdown-it-anchor` you're trying to use via CDN is not a UMD (Universal Module Definition) build, which is required to make it compatible with direct browser inclusion without a module bundler like Webpack or Rollup.

Many modern JavaScript libraries and plugins are published in formats like ES Modules, which are not directly compatible with all browser environments without additional tooling. If `markdown-it-anchor` is not available in UMD format via a CDN, you might face issues like the one you're encountering.

Here are a couple of alternatives to consider:

1. **Check for UMD Builds**: Look for a UMD build of `markdown-it-anchor` that is specifically designed for direct browser use. Sometimes, library authors provide separate builds for different environments.
    
2. **Local Build**: If a UMD version is not available via CDN, you can download the `markdown-it-anchor` package and create a UMD build using a tool like Webpack or Rollup. This would involve some setup but would ensure compatibility.
    
3. **Alternative Plugins or Libraries**: If `markdown-it-anchor` doesn't suit your needs due to these issues, you might need to look for alternative plugins or libraries that offer similar functionality and have UMD builds available.
    
4. **Simpler Approach without Plugin**: As a simpler approach, if your use case is straightforward, you could manually add IDs to your markdown headings and then convert them using `markdown-it` without a plugin. This would bypass the need for `markdown-it-anchor` but requires manual ID management.
    
5. **Server-Side Rendering**: If you have the option, you could handle Markdown processing server-side (using Node.js, for example), which allows more flexibility in terms of modules and doesn't have the same constraints as client-side JavaScript in a browser.
    

Unfortunately, without a compatible UMD build of the `markdown-it-anchor` plugin, using it directly in the browser (through a CDN link) can be challenging. You might need to consider these alternative approaches depending on your specific requirements and environment.

----

Indepth:
Universal Module Definition (UMD) is actually designed to work in both browser and server environments, not just the browser. UMD is a pattern of JavaScript module definition that allows a module to work with different module systems, such as AMD, CommonJS, and as a global variable when neither is present. This makes UMD highly versatile, especially for libraries that need to be compatible with various environments and module loaders.

Here's a basic outline of how UMD works:

- It first checks for the presence of an AMD loader (like RequireJS). If one is found, it defines the module using AMD's `define` function.
- If no AMD loader is detected, it then checks for a CommonJS environment (like Node.js). In this case, it exports the module using CommonJS's `module.exports`.
- If neither AMD nor CommonJS is present, the module is attached to a global variable, usually `window` in browsers, making it accessible as a global variable.

By incorporating this pattern, UMD allows JavaScript modules to be more universally usable across different JavaScript environments and module systems. Here's a simple example of what UMD syntax might look like:

```javascript
(function(root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['dependency'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node. Does not work with strict CommonJS, but
        // only CommonJS-like environments that support module.exports,
        // like Node.
        module.exports = factory(require('dependency'));
    } else {
        // Browser globals (root is window)
        root.returnExports = factory(root.dependency);
    }
}(typeof self !== 'undefined' ? self : this, function(dependency) {
    // Actual module code goes here
    return myModule;
}));
```

This code ensures that the module is compatible with AMD, CommonJS, and plain browser environments.