## 🔄 Design Tokens vs. CSS Variables (and How Tailwind Supports Both)

### 🔹 What Are Design Tokens?

**Design tokens** are the visual design decisions of your brand—like colors, typography, spacing—stored in a platform-neutral format (typically JSON or YAML). They provide a **central source of truth** for design systems across platforms like web, iOS, Android, and Flutter.

Example:

```json
{
  "color": {
    "primary": {
      "value": "#ff0000",
      "type": "color",
      "description": "Primary brand color for the app."
    }
  }
}
```

This token can be transformed into:

- **CSS**: `--color-primary: #ff0000;`
- **Swift**: `let primaryColor = UIColor(hex: "#ff0000")`
- **XML**: `<color name="primary">#ff0000</color>`
    
### 🔹 What Are CSS Variables?

**CSS Variables** (also known as custom properties) are a feature of CSS that lets you define reusable styling values, scoped globally or locally.

```css
:root {
  --primary-color: #ff0000;
}
```

They're dynamic, allowing updates in real time via JavaScript, and they apply only to the web.

---

### 🔍 Design Tokens vs. CSS Variables

|Feature|Design Tokens|CSS Variables|
|---|---|---|
|**Purpose**|Abstract, reusable design values|Web-based styling reuse|
|**Format**|JSON, YAML, etc.|CSS `.css` or inline styles|
|**Platform Neutral**|✅ Yes|❌ No (Web-only)|
|**Dynamic Updates**|Build-process required|Yes (via JS)|
|**Includes Metadata**|✅ Descriptions, types, hierarchy|❌ None|
|**Cross-Platform Use**|✅ Supports iOS, Android, Web, etc.|❌ CSS-only|

---

## 🌀 Using Design Tokens in Tailwind CSS

Tailwind allows you to define **design tokens** within `tailwind.config.js`. This creates a consistent and scalable design system while maintaining flexibility for theming and dark mode.

### ✅ Example: Defining Tokens in Tailwind

But Tailwind also makes a distinction between two types of Design tokens (See the comments "Primitive Tokens" and "Semantic Tokens")

```js
module.exports = {
  darkMode: 'class', // or 'media'
  theme: {
    extend: {
      colors: {
        // Primitive Tokens
        blue: {
          50: "#f0f9ff",
          100: "#e0f2fe",
          500: "#0ea5e9",
          900: "#0c4a6e"
        },
        gray: {
          50: "#f9fafb",
          800: "#1f2937",
          900: "#111827"
        },
      },
      semanticTokens: {
        // Semantic Tokens
        primary: "blue.500",
        background: {
          light: "gray.50",
          dark: "gray.800",
        },
        text: {
          light: "gray.900",
          dark: "gray.100",
        },
      },
    },
  },
  plugins: [],
};
```

**Primitive tokens** and **semantic tokens** are both types of **design tokens** — the distinction between them is a **naming convention or conceptual layer**, not a different technology. Tailwind didn’t invent the idea, but it has helped popularize and formalize the distinction in practical usage.

| Token Type           | Description                                 | Example                 |
| -------------------- | ------------------------------------------- | ----------------------- |
| **Primitive Tokens** | Raw values with no context                  | `blue.500`              |
| **Semantic Tokens**  | Purposeful mapping of primitives to meaning | `primary`, `text.light` |

---

### 🎨 How to Use Semantic Tokens in Tailwind

You can now use tokens meaningfully in your components:

```html
<button class="bg-primary text-white">Primary Button</button>

<div class="bg-background text-text">
  <p>Hello, World!</p>
</div>
```

Tailwind intelligently maps `background` and `text` tokens to the correct values depending on light/dark mode.

---

### 🌓 Dark Mode with Tokens

Enable Tailwind dark mode like this:

```js
module.exports = {
  darkMode: "class",
};
```

Then use the `dark` class to toggle themes:

```html
<html class="dark">
  <body class="bg-background text-text">
    ...
  </body>
</html>
```

---

## 🧩 Integration Workflow for Design Tokens

1. **Define tokens** in a neutral format (JSON, YAML).
2. Use tools like **Style Dictionary** to generate Tailwind, CSS, Swift, XML, or Android equivalents.
3. In Tailwind, **define them directly** in `tailwind.config.js`.
4. Use semantic classes in your markup for meaningful styling.

---

### ✅ Summary

- **Design Tokens** are centralized, platform-neutral design values that can be transformed into platform-specific variables (CSS, Swift, XML, etc.).
- **CSS Variables** are web-specific and great for dynamic updates via JavaScript.
- **Tailwind** supports design tokens (and distinguishes between primitive tokens and semantic tokens) through its config system, making it easy to build consistent, theme-aware designs—especially with dark mode support.
- Use **primitive tokens** for raw values and **semantic tokens** for meaningful styling that scales.

---

Weng's personal notes:
https://www.getmerlin.in/chat/6c4af635-39cf-4e9b-9e1d-0f3745b22969