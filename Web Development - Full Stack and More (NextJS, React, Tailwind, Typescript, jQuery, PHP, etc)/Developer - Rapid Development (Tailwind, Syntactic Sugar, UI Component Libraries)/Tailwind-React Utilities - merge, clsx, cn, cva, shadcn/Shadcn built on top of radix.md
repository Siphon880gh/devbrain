**Shadcn is built on top of Radix.**

Radix — short for “root” — provides foundational UI components that serve as the building blocks for more complex interfaces. The name itself reflects its role: root-level primitives intended to be composed into accessible, modern UI elements.

While Radix is well-known for its strong accessibility features, that’s just one part of its value. It also offers:
- **Semantically meaningful components** like `Dialog`, `Tooltip`, and `Popover` that mirror common UI patterns.
- A styling-first approach: you bring your own styles, typically using Tailwind CSS.
- Support for **arbitrary Tailwind values**, such as custom widths (`w-[300px]`) or CSS variables (`bg-[var(--surface)]`), keeping visual styles in class names and structural meaning in the HTML elements themselves.

This design philosophy separates behavior and accessibility (handled by Radix) from styling (handled by you), promoting clean, semantic, and flexible UI development.