### **What Are Design Tokens?**

Design tokens are **variables** that store design-related values (like colors, spacing, typography, etc.) in a structured way. They help maintain consistency across a design system.

Instead of hardcoding values like this:

```css
button {
  background-color: #3498db;
}
```

You define them as tokens:

```css
:root {
  --primary-color: oklch(62.2% 0.24 250);
}

button {
  background-color: var(--primary-color);
}
```

### **How ShadCN Uses Design Tokens**

ShadCN uses `oklch` in its design tokens for **better color theming** and **easier customization**. `oklch` is natively supported on modern web browsers, and you can read more about it at [[CSS OKLCH]]

For example, in `tailwind.config.ts`, ShadCN defines tokens like:

```ts
const { fontFamily } = require("tailwindcss/defaultTheme")

module.exports = {
  theme: {
    extend: {
      colors: {
        primary: "oklch(62.2% 0.24 250)",
        secondary: "oklch(40% 0.2 180)",
      }
    }
  }
}
```

This allows for **consistent colors** across all components, making it easier to adjust themes dynamically.

---

Even though **design tokens** can be thought of as **CSS variables**, they are more than that. Let's compare css variables to the concept design tokens.

### **Design Tokens vs. CSS Variables**

| Feature             | CSS Variables                | Design Tokens                                                                            |
| ------------------- | ---------------------------- | ---------------------------------------------------------------------------------------- |
| **Definition**      | Variables storing CSS values | Variables storing **design values** (colors, spacing, typography) in a structured format |
| **Scope**           | Limited to CSS               | Used across CSS, Tailwind, JS/TS, JSON, Figma, and design systems                        |
| **Format**          | `--primary: #3498db;`        | `{ "color.primary": "oklch(62.2% 0.24 250)" }` (JSON, TS, etc.)                          |
| **Purpose**         | Runtime styling              | Systematic, scalable theming across platforms                                            |
| **Use in Tailwind** | Used with `var(--color)`     | Used in `theme.extend.colors`                                                            |

### **Example: Using Design Tokens in CSS**

```css
:root {
  --color-primary: oklch(62.2% 0.24 250);
  --color-secondary: oklch(40% 0.2 180);
}

button {
  background-color: var(--color-primary);
}
```

### **Example: Using Design Tokens in Tailwind + ShadCN**

In **`tailwind.config.ts`**, you define tokens:

```ts
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: "oklch(62.2% 0.24 250)",
        secondary: "oklch(40% 0.2 180)",
      }
    }
  }
}
```

And in **JS/TS for a design system**, tokens can be stored in a JSON file:

```json
{
  "color.primary": "oklch(62.2% 0.24 250)",
  "color.secondary": "oklch(40% 0.2 180)"
}
```

This allows **cross-platform consistency** (web, mobile, Figma, etc.).


