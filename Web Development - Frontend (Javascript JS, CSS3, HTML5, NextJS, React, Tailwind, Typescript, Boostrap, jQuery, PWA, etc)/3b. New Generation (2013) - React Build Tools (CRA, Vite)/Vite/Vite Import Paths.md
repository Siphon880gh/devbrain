
### **1. Serving Static Assets (`public` folder)**

Vite serves static assets from the `/public` folder. However, these assets should be referenced with absolute URLs in templates, not imported directly in JavaScript:

```html
<img src="/logo.png" alt="Logo" />
```

In JavaScript, you typically use `import.meta.env.BASE_URL` for dynamic asset paths:

```js
const logo = `${import.meta.env.BASE_URL}logo.png`;
```

> **❌ Unlike Next.js**, you **cannot** do `import Logo from "/logo.png"` because Vite does not process imports from `/public`.

---

### **2. Relative Imports**

Vite supports standard relative imports for local files:

```js
import data from "./data/users.mock.json";
import data from "data/users.mock.json"; // If module resolution allows
```

---

### **3. Importing Node Modules**

Vite automatically resolves modules from `node_modules`:

```js
import { createApp } from 'vue';
import SomePackage from 'some-package';
```

> **⚠️ Unlike Next.js**, Vite **does not** have built-in support for Google Fonts (`next/font/google`). You must manually include them in `index.html` or use a CSS import.

---

### **4. Absolute Imports**

Vite supports absolute imports if configured in `vite.config.js`. The default is `@` mapped to `src/`:

```js
import '@/styles/global.css';
```

If you need custom aliases, define them in `vite.config.js`:

```js
import { defineConfig } from 'vite';

export default defineConfig({
  resolve: {
    alias: {
      '@': '/src'
    }
  }
});
```
