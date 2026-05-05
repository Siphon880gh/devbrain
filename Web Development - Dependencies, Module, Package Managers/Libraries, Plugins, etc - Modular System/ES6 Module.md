
\<< What is `<script type="module">`?

\>>
The `<script type="module">` tag in HTML is used to include JavaScript modules in web pages. It signifies that the script should be treated as an ECMAScript module (ES Module), which allows you to use features like `import` and `export` statements natively in the browser. This is a part of the ECMAScript 6 (ES6) specification and is supported by modern web browsers.

Here are some key points about using `<script type="module">`:

1. **ES Module Syntax**: You can use ES6 module features like `import` and `export` within scripts marked as modules. This allows for organizing JavaScript code into reusable modules.

2. **Deferred Execution**: Scripts with `type="module"` are deferred by default. This means they do not block HTML parsing and are executed after the document has been fully parsed, similar to scripts with the `defer` attribute.

3. **Strict Mode**: JavaScript code inside a module runs in strict mode automatically. This means certain error-prone behaviors of JavaScript are eliminated, and some mistakes throw errors instead of silently failing.

4. **Cross-Origin Restrictions**: Modules are fetched using CORS. This means that if you're importing a module from a different origin, the server must provide appropriate CORS headers.

5. **No Duplicate Module Execution**: If a module is imported multiple times in different scripts or other modules, it is only executed once.

6. **Support for Top-Level Await**: In modules, you can use the `await` keyword outside of async functions, at the top level of your code.

7. **Different Global Scope**: Scripts with `type="module"` have a different global scope. For example, a top-level `var` or `function` declaration in a module does not create a property on the global `window` object.

Here's a basic example of how to use it:

```html
<script type="module">
  import { myFunction } from './myModule.js';

  myFunction();
</script>
```

In this example, `myModule.js` is a separate file that exports `myFunction`, which is then imported and used in the script. This makes it easier to organize and manage large JavaScript codebases.