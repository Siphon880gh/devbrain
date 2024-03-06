

Annoying point:
your devtools.html is not the one loaded into the devtools sidebar (rather, it's panel.js) -devtools.html loads devtools.js, then devtools.js sets the panel to panel.js

So why is it like this?:

The `devtools_page` property in a Chrome extension's manifest points to an HTML file because it sets up an environment for scripts and provides a structure for initializing the DevTools extension. Here's why it's an HTML file:

1. **Initialization**: The HTML file serves as an entry point for the DevTools extension. When you open Chrome DevTools, the specified HTML file is loaded, which in turn can load and execute associated JavaScript files.

2. **Script Loading**: By using an HTML file, you can use `<script>` tags to load one or more JavaScript files. This allows for modular code organization, where you can separate different functionalities into different JS files and load them in a specific order if needed.

   ```html
   <script src="script1.js"></script>
   <script src="script2.js"></script>
   ```

3. **Event Listeners**: The scripts loaded by the `devtools_page` HTML can set up event listeners, such as those listening for panel creation or interactions within the DevTools extension.

4. **Flexibility**: While the primary purpose is to load scripts, having an HTML file allows for more flexibility. If needed, developers can add inline styles, meta tags, or even inline scripts.

5. **Consistency with Other Extension Pages**: Other parts of a Chrome extension, like popups (`browser_action` or `page_action`), also use HTML as their entry point. Using HTML for `devtools_page` maintains consistency across different components of the extension.

6. **Legacy Reasons**: Earlier versions of Chrome extensions (Manifest V1 and V2) used HTML pages for various components, including background pages. While Manifest V3 has moved away from persistent background pages in favor of service workers, the `devtools_page` remains an HTML file for the reasons mentioned above and to provide a familiar structure for developers.

In essence, the HTML file for `devtools_page` provides a structured and flexible way to initialize and configure the DevTools extension's behavior.