Aka: Getting Started

By having a css file end with “.module.css, then NextJS (among other JS frameworks) will locally scope the css file to that component only and a rule set become pullable using the `style.`  object as long as the rule set is a single class selection. All other rule sets that have mixed selection (or tag selection, id selection, etc) will be ignored by the `style.`  block and there will be no error or warning thrown.  

CSS Modules (`.module.css`) are a general feature supported in various JavaScript frameworks and bundlers that use Webpack, Vite, or similar tools.  
### Where CSS Modules Work:

1. **Next.js** – Uses CSS Modules out of the box for scoped styles.
2. **React (CRA or Vite)** – Works with `.module.css` files when configured correctly.
3. **Vue (via `*.module.css`)** – Works with Vue’s style system.
4. **Svelte** – Uses a different scoped styling approach, but CSS Modules can be configured.
5. **Webpack Projects** – Requires `css-loader` with `modules: true` in the Webpack config.
6. **Vite** – Supports CSS Modules natively.  

### Key Benefits of CSS Modules:

- **Scoped styles** (avoids class name collisions).
- **Automatic unique class names** (hashed class names in production).
- **Works well with component-based architectures**.

  
CSS Modules are first-class supported in Next.js and Vite, but for the other JavaScript environments, it may require proper configuration.

---

Example use:  
Let’s say we do this on NextJS.

Create `/app/ui/home.module.css` :
```
.shape {  
  height: 0;  
  width: 0;  
  border-bottom: 30px solid black;  
  border-left: 20px solid transparent;  
  border-right: 20px solid transparent;  
}  

```

Import shape utility classes to be used
```
import styles from '@/app/ui/home.module.css';  
// ...

<div className={styles.shape} />  
```

---

The css selectors in the `*.module.css` file must be classes. If you include **non-class selectors** (like `body`, `h1`, `p`, or `@keyframes`) inside a **CSS Module** (`.module.css` file), Next.js (and Webpack) **will not throw an error**, but you won’t be able to access them via `styles`.