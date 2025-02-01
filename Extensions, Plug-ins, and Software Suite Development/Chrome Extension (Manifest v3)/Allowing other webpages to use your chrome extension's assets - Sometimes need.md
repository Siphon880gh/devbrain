Web accessible resources from chrome extension to other content

TLDR:

- `web_accessible_resources` field specifies the resources within an extension that can be publicly accessible by web pages or other extensions. gs. it's exposing your extension's files to other contents
- To enable subdirectories you have to path it with "*/"

---

In the Chrome extension's `manifest.json`, the `web_accessible_resources` field specifies the resources within an extension that can be publicly accessible by web pages or other extensions. These resources can be accessed via the extension's resource URL.

The wildcard character `*` in the path `"assets-framework-css/*"` is used as a placeholder for any set of characters (excluding the directory separator `/`). This means it will match any file directly inside the `assets-framework-css` directory, but it does not recursively include files in subdirectories.

For example, it will include:

- `assets-framework-css/style.css`
- `assets-framework-css/script.js`

But it will **not** include:

- `assets-framework-css/subdirectory/style.css`
- `assets-framework-css/another/subdirectory/script.js`

If you want to include resources in subdirectories, you would need to specify their paths explicitly or use a wildcard that includes the subdirectory, like so:

  
```json

"web_accessible_resources": [

    {

      "resources": [

        "assets-framework-css/*",

        "assets-framework-css/*/*",  // for one level of subdirectory

        "assets-framework-css/*/*/*",  // for two levels of subdirectory

        // ... as many as needed depending on the depth of your directory structure

        "assets-icons/*",

        "https://fonts.googleapis.com/*",

        "*"

      ],

      "matches": ["<all_urls>"]

    }

  ],

```

  

Remember, being explicit is better than using wide-ranging wildcards for performance and security reasons. You should only make web-accessible the resources that need to be.