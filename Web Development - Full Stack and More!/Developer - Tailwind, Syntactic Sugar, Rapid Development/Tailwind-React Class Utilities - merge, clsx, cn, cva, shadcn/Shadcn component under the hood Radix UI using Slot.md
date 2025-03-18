Refer to Shadcn at [[_History of merge, clsx, cn, cva, shadcn - PRIMER]] if you want to see how you can see the underlying code that uses Radix UI library and Radix UI utilities (Slot) behind any component that you add to your codebase using the Shadcn CLI tool.

When viewing the underlying code for any component you add with Shadcn CLI (truncated parts of the code for brevity):
```
import * as React from "react"
import { Slot } from "@radix-ui/react-slot"
import { cva, type VariantProps } from "class-variance-authority"

import { cn } from "@/lib/utils"

const buttonVariants = cva(
  "inline-flex items-center...", // base classes
  {
    variants: {
      variant: {
        default:
          "bg-primary text-primary-foreground shadow hover:bg-primary/90",
        destructive:
          "bg-destructive text-destructive-foreground shadow-sm hover:bg-destructive/90",
        // ...
      },
      size: {
        default: "h-9 px-4 py-2",
        // ...
      },
    },
    defaultVariants: { // if a variant option not passed when initiating button
      variant: "default", // use the classes at variants.variant.default
      size: "default",
    },
  }
)

export interface ButtonProps
  extends React.ButtonHTMLAttributes<HTMLButtonElement>,
    VariantProps<typeof buttonVariants> {
  asChild?: boolean
}

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>(
  ({ className, variant, size, asChild = false, ...props }, ref) => {
    const Comp = asChild ? Slot : "button"
    return (
      <Comp
        className={cn(buttonVariants({ variant, size, className }))}
        ref={ref}
        {...props}
      />
    )
  }
)
Button.displayName = "Button"

export { Button, buttonVariants }
```

### What is `Slot` doing in this Button component?

The `Slot` component from **Radix UI** is used here to allow the `Button` component to **render a different element instead of a `<button>`**, while still applying the same styles and props.

---

### 🔹 Normal Behavior (Without `asChild`)

By default, the `Button` component renders a `<button>` tag:

```tsx
<Button>Click Me</Button>
```

👉 This outputs:

```html
<button class="bg-primary text-primary-foreground ...">Click Me</button>
```

---

### 🔹 `asChild={true}` (Replacing `<button>` with another element)

If you pass `asChild`, `Slot` will replace the default `<button>` with whatever child element you provide.

Example:

```tsx
<Button asChild>
  <a href="/dashboard">Go to Dashboard</a>
</Button>
```

👉 This outputs:

```html
<a href="/dashboard" class="bg-primary text-primary-foreground ...">Go to Dashboard</a>
```

### 🔹 Why is `Slot` Needed?

Normally, if you wrap a button inside an `<a>` tag without `Slot`, the styles and behavior wouldn’t transfer correctly. `Slot` makes sure the `className` and other props (like `onClick`) are passed down properly to the child element.

Without `Slot`, you’d have to manually pass the props and styles, which is more complicated.

---

### ✨ TL;DR

- **By default** → Button renders a `<button>`.
- **With `asChild={true}`** → Button can be any element (like `<a>`), but still gets styles and behavior.
- **Radix `Slot` handles prop forwarding**, so you don’t have to manually pass props to child elements.