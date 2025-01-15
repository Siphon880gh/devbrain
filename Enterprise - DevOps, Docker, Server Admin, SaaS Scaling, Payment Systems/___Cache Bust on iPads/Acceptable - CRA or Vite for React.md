## CRA or Vite for React is OKAY

Both **Create React App (CRA)** and **Vite** handle cache busting by default, albeit in slightly different ways, as part of their build process

Yes, both **Create React App (CRA)** and **Vite** handle cache busting by default, albeit in slightly different ways, as part of their build process:

### **Create React App (CRA)**

- CRA uses **Webpack** under the hood.
- When you run `npm run build` or `yarn build`, CRA generates minified and bundled JavaScript and CSS files.
- These files are named with a content hash included in their filenames (e.g., `main.[contenthash].js` and `main.[contenthash].css`).
- The `contenthash` changes whenever the content of the file changes, ensuring that browsers fetch the updated files instead of serving them from the cache.
- Example:
    
    ```
    static/js/main.8a5c1b2a.chunk.js
    static/css/main.8a5c1b2a.chunk.css
    ```
    

### **Vite**

- Vite also uses **hashed filenames** for cache busting in its production builds.
- When you run `vite build`, it generates output files with a hash derived from their content (e.g., `index.[hash].js` and `style.[hash].css`).
- The hash changes when the file content changes, ensuring proper cache invalidation.
- Vite’s build process is powered by **esbuild** and **Rollup**, making it faster and more efficient compared to CRA.

### **Key Benefits of This Approach**

1. **Cache Busting**: Since the file names change when the content changes, browsers are forced to fetch the updated files instead of using cached ones.
2. **Efficient Caching**: Files with unchanged content retain their hash and continue to be served from the cache, improving performance.

Both tools ensure proper cache busting with minimal configuration required, and their default behavior is suitable for most use cases.


---


## But Other Stacks Need Other Strategies

But say you're working on a vanilla js or a jquery project, then you need other strategies that deal with unique filename or unique url to the asset files. Refer to [[iPad Safari aggressively caches - 2. How to mitigate]]