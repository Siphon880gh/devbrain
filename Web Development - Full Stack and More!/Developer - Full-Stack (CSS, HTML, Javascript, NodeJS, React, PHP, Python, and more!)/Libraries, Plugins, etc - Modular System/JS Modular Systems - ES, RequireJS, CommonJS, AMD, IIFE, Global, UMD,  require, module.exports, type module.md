The module systems in the last decades have been:
- **E**: ES Modules (ECMAScript Modules)
- **R**: RequireJS
- **C**: CommonJS
- **A**: AMD
- **I**: IIFE
- **G**: Global Scripts
- **U**: UMD

**Mnemonic Phrase:**  
- "**Encrypt Raw Code And Introduce Global Updates**"  
- "**Every Readily Clever Artist Instantly Gets Universal**"
- "**Explorers rarely choose anything insignificant - Greatness Unfolds**"
- "**Electrons repel charged atoms inside galactic universes**"

### Module Types and Their Usage

1. **ES Modules (ECMAScript Modules)**
	- **Usage**: Uses `import` and `export` to allow static analysis and tree shaking.
	- **Where**: Widely used in modern web browsers and Node.js projects. On web browsers, you declare `<script type="module">`. On NodeJS apps, we have `type: module` in package.json.
	- **Mnemonic Hint ("**Encrypt**")**: Think of “**Encrypt**” as representing the standard, modern more secured way by ECMAScript.

1. **RequireJS**
	- RequireJS is an implementation of AMD, which supports asynchronous module loading in the browser, while also preserving the spirit of CommonJS by using familiar module identifiers and patterns—such as require() for importing and module.exports for exporting.
	- **Mnemonic Hint ("**Raw**")**: Think of “**Raw**” as representing an aggressive usurping of the modules because having it called RequireJS will confuse while they’re already using CommonJS’ require

1. **CommonJS**
	- **Usage**: Uses `require` and `module.exports` for module loading, primarily in Node.js environments. As of 4/5/2025, this is the default module system though NodeJS encourages migrating to the newer ES Modules (package.json needs a “type:module”)
	- **Where**: Traditional module system on the server side, especially with NodeJS (unless specified “type:module” in package.json).
	- **Mnemonic Hint ("Code")**: “Code” reminds you that although NodeJS and NPM recommends the newer ESModules (Import/Export) over the traditional CommonJS (Require, Exports.require), much of the internet’s code on GIthub uses the traditional CommonJS.

5. **AMD (Asynchronous Module Definition)**
	- **Usage**: Loads modules asynchronously using a `define` function.
	- **Where**: Historically popular in browser environments where asynchronous loading is essential.
	- **Mnemonic Hint ("And")**: This is an additional thing to all the other modules. This system loads asynchronously.

7. **IIFE (Immediately Invoked Function Expression)**
	- **Usage**: Wraps code in a function that executes immediately, creating a private scope. The most common pattern is to set `window.YOUR_LIBRARY_NAME` 
	- **Where**: Used in scripts that need to run right away upon being loaded, often to avoid polluting the global scope.
	- **Mnemonic Hint ("Introduce")**: “Introduce” reminds you that the function runs immediately without waiting for an import/export cycle. It’s like when you’re at a business meeting and you have to forcefully introduce yourself by stepping forward and offering your hand. It forcefully introduces an object into window.

9. **Global Scripts**
	- **Usage**: Scripts that simply attach functions or variables to the global object (`window`) without any modular encapsulation. These are the plain js files that you can source directly in the `<script>` tag.
	- **Where**: Common in legacy and simple web projects where modularity isn’t required.
	- **Mnemonic Hint ("Global")**: "Globals" signifies that the code is globally available or that variables are automatically accessible in the global scope. For example, you can open DevTools console and check a variable that’s been plainly executed from the global script without enclosures.

10. **UMD (Universal Module Definition)**
	- **Usage**: Designed to work in multiple module systems (CommonJS, AMD) as well as attaching to the global scope.
	- **Where**: Provides a one-stop solution for libraries that need to run in any environment (browser, Node.js, etc.) You can source directly in the `<script>` tag as if it's any plain global script.
	- **Mnemonic Hint ("Updates")**: “Updates” stresses its goal to be adaptable and usable anywhere even to the then, updated new module systems.


### Re-emphasis on NPM’s modular systems

NPM traditionally used CommonJS (require for importing and module.exports for exporting), but newer version pushes for ES Modules (but to prevent the breaking of apps, package.json requires `type: module`).