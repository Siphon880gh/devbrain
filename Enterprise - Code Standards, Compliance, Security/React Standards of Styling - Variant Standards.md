## 🖌️ Design System Variants with `cva`

As your Tailwind CSS project scales, maintaining consistent component styles (e.g., `primary`, `secondary`, `sm`, `lg`) becomes more important. This is where `cva` shines: it helps you structure variant-based class logic cleanly and predictably.

---

### 🚀 Create Reusable Variants with `cva`

[`cva`](https://cva.style/) stands for **Class Variance Authority**—a playful nod to Marvel's Time Variance Authority. Just like the TVA manages timelines, `cva` helps manage consistent Tailwind class variants.

```ts
import { cva } from 'class-variance-authority';

export const button = cva('px-4 py-2 rounded font-semibold', {
  variants: {
    intent: {
      primary: 'bg-blue-600 text-white',
      secondary: 'bg-gray-300 text-black',
    },
    size: {
      sm: 'text-sm',
      lg: 'text-lg',
    },
  },
  defaultVariants: {
    intent: 'primary',
    size: 'sm',
  },
});
```

---

### ℹ️ Optional: Merge Extras with `cn`

If you want to **add custom classes conditionally** or **layer in dynamic styles**, you can combine `cva` with the `cn` utility.

Quick review of `cn`: 
- The `cn` utility wraps both `clsx` and `tailwind-merge` to simplify and safeguard your className logic:
	- **`clsx`**: Adds flexible conditional logic by allowing any number of arguments. Each argument can be:
	    - A string of classes
	    - A short-circuit expression (e.g. `isActive && 'bg-blue-500'`)
	    - A ternary (e.g. `isDark ? 'text-white' : 'text-black'`)
	    - An object with conditional keys
	    - An array of any of the above
	      
	    This means you can dynamically compose class strings without worrying about missing spaces or manually concatenating. It also works with libraries that return non-string values which eventually resolve to class names.
	- **`tailwind-merge` (aka `twMerge`)**: Automatically resolves conflicting Tailwind classes by understanding Tailwind’s utility groups (like `text-*`, `bg-*`, `p-*`, etc). It removes overlapping or redundant classes before they reach the web browser, ensuring consistent and predictable styling.

This pattern is common in UI libraries like [shadcn/ui](https://ui.shadcn.dev/).

#### Setup at `utils/cn.ts`:

```ts
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}
```

### 📂 Example: `cva` + `cn` in Action

```tsx
import { cn } from './utils/cn';
import { button } from './styles/button';

export default function Home() {
  const readyToGenerate = false;

  return (
    <main className="flex flex-col justify-center items-center min-h-screen gap-6">
      <h1 className="text-4xl font-bold">
        Welcome to the AI-powered image generator
      </h1>

      <button
        className={cn(
          button({ intent: 'secondary', size: 'lg' }),
          'w-full mt-4',
          !readyToGenerate && 'opacity-50 cursor-not-allowed'
        )}
      >
        Continue
      </button>
    </main>
  );
}
```

Rendered HTML:

```html
<button class="px-4 py-2 rounded font-semibold text-lg bg-gray-300 text-black w-full mt-4 opacity-50 cursor-not-allowed">
  Continue
</button>
```

---

### 🔄 Summary

|Tool|Purpose|Bonus Mnemonic / Use Case|
|---|---|---|
|`cva`|Create reusable variant-based class systems|"Class Variance Authority" → Marvel TVA|
|`cn` _(optional)_|Clean merging of dynamic, conflict-prone styles|Used in shadcn, modern Next.js/React component kits|

With `cva` at the core and optional `cn` for flexibility, you can scale your design system with clarity and ease.