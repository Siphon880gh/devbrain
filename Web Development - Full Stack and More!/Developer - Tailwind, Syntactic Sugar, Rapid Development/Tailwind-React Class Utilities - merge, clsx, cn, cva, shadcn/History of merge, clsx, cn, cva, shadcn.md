**History and Emergence of Tailwind Merge, cn, shadcn, and CVA**

For many of the demonstrations, the page looks like either
Or A (`readyToGenerate` true):
![[Pasted image 20250318040239.png]]
Or B (`readyToGenerate` false):
![[Pasted image 20250318040326.png]]

### **1. Tailwind Merge**

Tailwind Merge was designed to solve issues with conflicting Tailwind CSS classes. It is a utility that intelligently merges multiple class strings in JavaScript, automatically resolving and removing conflicting styles.

- It emerged from the Tailwind CSS ecosystem as an enhancement to handle situations where multiple class names, such as `bg-red` and `bg-blue`, might conflict in dynamic scenarios.
- A common use case is applying classes in response to conditional logic or user-defined props.
- For instance:
    ```
    import { twMerge } from 'tailwind-merge';
    twMerge('bg-red p-3', 'bg-blue'); // → 'p-3 bg-blue'
    ```
	- Here, `tailwind-merge` automatically drops `bg-red` in favor of `bg-blue`.

It is widely used in both **React** and **Next.js** projects to ensure that dynamically generated Tailwind classes don’t create unexpected styling conflicts.

In addition, the final HTML will have overridden classes NOT show up, so also helps avoid redundant file size.

You install with `npm install tailwind-merge`

**Why needed?**
Say you have:
```
<h1 className="text-4xl font-light font-bold">
```

You probably intended to be font-bold. While most web browsers will use the last class, you can't rely on that. Furthermore, you're bloating the HTML characters / webpage file size.

Better served with:
```
<h1 className={twMerge("text-4xl font-light", "font-bold")}>
```
- And that rendered in the view source as `<h1 class="text-4xl font-bold">Welcome...


**Practice code:**
```
import { twMerge } from 'tailwind-merge';

export default function Home() {
  return (
    <main className="flex flex-col justify-center items-end min-h-screen w-fit mx-auto gap-12">
      <h1 className={twMerge("text-4xl font-light", "font-bold")}>
        Welcome to the AI-powered image generator
      </h1>
      <button className="text-2xl underline text-black">
        Continue
      </button>
    </main>
  );
}
```

---


### 2. clsx Utility

- **clsx**: A tiny utility for conditionally constructing class name strings. It emerged as a faster replacement for the older `classnames` library and aids in conditionally rendering class names. You install with `npm install clsx`

Example:
```
clsx('foo', true && 'bar', <more conditional evaulations if needed>); // → 'foo bar'
```

Alternate syntax:
```
clsx('foo', { 
	'bar': true,
	<more conditional evaluations in this form of "key:value", if needed>
}); // → 'foo bar'
```

Mnemonic: Think clsx as class exchange. This could help you memorize it (when needing to write code or installing with npm)

**Why needed?**
It's messy to use conditionals:
```
<button className={"text-2xl underline " + (readyToGenerate?"text-gray-300":"text-black")}>Continue</button>
```
- It's problematic if you forget to add a space after the class `underline` because the class name could potentially include `underlinetext-gray-300`.
- It's also problematic sometimes if you don't have the parentheses at the ternary condition!

**It would be solved by clsx**

Solution A:
```
<button className={clsx("text-2xl underline ", readyToGenerate?"text-gray-300":"text-black")}>
```

Solution B:
```
import clsx from "clsx";
// ...

<button className={
	clsx("text-2xl underline ", 
	{
		"text-gray-300": !readyToGenerate,
		"text-black": readyToGenerate
	})
}>
```


**Practice code:**
```
import clsx from "clsx";

export default function Home() {
  const readyToGenerate = true;
  return (
    <main className="flex flex-col justify-center items-end min-h-screen w-fit mx-auto gap-12">
      <h1 className="text-4xl font-bold">
        Welcome to the AI-powered image generator
      </h1>
      <button className={clsx("text-2xl underline ", {
		"text-gray-300": !readyToGenerate,
		"text-black": readyToGenerate
	})
}>
        Continue
      </button>
    </main>
  );
}

```

---
### 3. cn Utility

The **"cn" utility** is commonly seen in libraries like shadcn. It is essentially a wrapper that combines the functionalities of the `clsx` and `tailwind-merge` packages:

- **clsx**: A tiny utility for conditionally constructing class name strings. It emerged as a faster replacement for the older `classnames` library and aids in conditionally rendering class names.
- **tailwind-merge**: Added to the utility to handle Tailwind CSS class conflicts while still enabling `clsx`’s conditional logic.

This utility appeared as part of modern **React/Next.js** UI component libraries, including **shadcn**, to streamline class name handling and style merging

If you want to use the same utility, you'd have to implement it.

Setup at `utils/cn.ts`:
```
import { clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}
```

Import and use:
```
import { cn } from "./utils/cn";

export default function Home() {
  const readyToGenerate = true;
  return (
    <main className="flex flex-col justify-center items-end min-h-screen w-fit mx-auto gap-12">
      <h1 className="text-4xl font-bold">
        Welcome to the AI-powered image generator
      </h1>
      <button className={cn("text-sm underline text-black", {
          "text-gray-300": !readyToGenerate,
          "text-black": readyToGenerate
        },
        "text-2xl"
        )}>
        Continue
      </button>
    </main>
  );
}
```

The button renders HTML as: `<button class="underline text-black text-2xl">Continue...`

---

### 4. Class Variance Authority (CVA)

**CVA** is a utility created to handle **class variance** in reusable and extensible React/Next.js components. It enables dynamic class building by encapsulating base classes, variants, and their conditional logic in a single, manageable structure.

Reworded: `class-variance-authority` (CVA) defines reusable and composable class variants for your element, eg. button.

- **Problem it solves**: Traditionally, developers struggled with managing Tailwind variants in large, reusable components. Combining base classes with variant logic and optional props often led to bloated code.
- **CVA's Solution**: CVA introduced a structured pattern:
    ```
    import { cva } from 'class-variance-authority';
    
    const buttonVariants = cva(
      'text-base font-semibold px-4 py-2',
      {
        variants: {
          color: {
            primary: 'text-white bg-blue-500',
            secondary: 'text-blue-500 bg-white',
          },
          size: {
            sm: 'text-sm',
            lg: 'text-lg',
          },
        },
        defaultVariants: {
          color: 'primary',
          size: 'sm',
        },
      }
    );
    
    buttonVariants({ color: 'secondary', size: 'lg' }); 
    // Result: 'text-base font-semibold px-4 py-2 text-blue-500 bg-white text-lg'
    ```
    

CVA complements **React** and **Next.js** frameworks by reducing boilerplate for styling dynamic components and is often seen in applications alongside `shadcn`, `tailwind-merge`, and `clsx`.

You install with `npm install class-variance-authority`.

**Practice Code**:
```
import { cva } from "class-variance-authority";
import { cn } from "./utils/cn";

const buttonVariants = cva(
  "text-2xl underline", // Base styles
  {
    variants: {
      type: {
        active: "text-black cursor-pointer",
        disabled: "text-gray-300 cursor-not-allowed",
      },
    },
    defaultVariants: {
      type: "active",
    },
  }
);

export default function Home() {
  const readyToGenerate = true;

  return (
    <main className="flex flex-col justify-center items-end min-h-screen w-fit mx-auto gap-12">
      <h1 className="text-4xl font-bold">
        Welcome to the AI-powered image generator
      </h1>
      <button className={cn(buttonVariants({ type: readyToGenerate ? "active" : "disabled" }))}>
        Continue
      </button>
    </main>
  );
}

```

---

### 5. shadcn

Shadcn is a highly customizable **React/Next.js** component system designed for reusability without becoming a dependency in projects. Unlike traditional component libraries like Material-UI, Shadcn aims to free components from the `node_modules` structure while offering Tailwind-styled UI components that are easily extendable.

- **Launch in January 2023**: It began as a repository of Tailwind-styled UI components. To use it, developers would have to manually copy and paste the code
- **Addition of CLI in June 2023**: The `shadcn` CLI was introduced, allowing developers to inject components into projects with simple commands:
    ```
    npx shadcn@latest add accordion
    ```

- **Vercel Acquisition in July 2023**: After being acquired by Vercel, Shadcn gained deeper integration with the Vercel ecosystem, making it a favorite in the React/Next.js communities. It became a cornerstone of tools like **V0**, a generative UI builder using Shadcn and Tailwind CSS [3](https://javascript.plainenglish.io/react-tailwind-reuseable-and-customizable-components-with-cva-clsx-and-tailwindmerge-combo-guide-c3756bdbbf16).
- ShadCN uses `oklch` in its design tokens for **better color theming** and **easier customization**. `oklch` is natively supported on modern web browsers, and you can read more about it at [[CSS OKLCH]]
- Shadcn is accessibility ready out of the box. Shadcn is built on top of Radix UI components which is the main guy that comes with built-in accessibility features, such as correct ARIA attributes and keyboard navigation.
- Shadcn has an icon library lucide by default. You can import Lucide icons out of the box with:
  - View icons library at https://lucide.dev/icons/
  - Below code generates:
    ![[Pasted image 20250318041336.png]]
```
import { Home, User } from "lucide-react";

export default function ExampleComponent() {
  return (
    <div>
      <Home className="w-6 h-6" />
      <User className="w-6 h-6" />
    </div>
  );
}  
```

Shadcn positions itself as not just a library but also a **development tool**. It is often paired with utilities like `tailwind-merge`, `clsx`, and `CVA` to maximize flexibility.

When you add a shadcn component via cli:
```
✔ You need to create a components.json file to add components. Proceed? … yes
? Which color would you like to use as the base color? › - Use arrow-keys. Return to submit.
❯   Neutral
    Gray
    Zinc
    Stone
    Slate
```

Creates:
```
├── <root>
    ├── src
    │   ├── app
    │   │   ├── favicon.ico
    │   │   ├── globals.css
    │   │   ├── layout.tsx
    │   │   ├── page.tsx
    │   │   └── utils
    │   │       └── cn.ts
    │   ├── components
    │   │   └── ui
    │   │       └── accordion.tsx
    │   └── lib
    │       └── utils.ts
    ├── components.json
```

Know that `src/lib/utils.ts` implemented the utility function `cn` that combined `clsx` and `twMerge` which we discussed in a previous section.

Know that `components.ts` is important for shadcn to work. It includes where the tailwind css file is at, where the components folders are at, what's the theme, and what icon library.

Now at `page.tsx`, import in Accordian to see how you can pass configurations to get different variants of accordian component:
- If you use the "multiple" variant. Otherwise, only one section can be open at a time.
- Code at `page.tsx`:
```
"use client"
import { Accordion } from '@/components/Accordion';

export default function Home() {
  const accordionItems = [
    {
      title: 'What is an accordion?',
      content: 'An accordion is a vertically stacked set of interactive headings that each reveal a section of content.'
    },
    {
      title: 'How does it work?',
      content: 'Click the header to reveal or hide the associated content.'
    },
    {
      title: 'Can multiple sections be open?',
      content: 'Yes, if you use the "multiple" variant. Otherwise, only one section can be open at a time.'
    }
  ];

  return (
    <div className="p-4 space-y-8">
      <div>
        <h2 className="text-xl font-bold mb-4">Single Accordion (Default)</h2>
        <Accordion items={accordionItems} />
      </div>

      <div>
        <h2 className="text-xl font-bold mb-4">Multiple Accordion</h2>
        <Accordion items={accordionItems} variant="multiple" />
      </div>
    </div>
  );
}
```
- When visiting `localhost:3000/`, you can see how the two Accordians you implemented are two variants - one single and the other multiple. And the single variant can only expand one section at a time, whereas the multiple variant can keep multiple sections opened simultaneously:
  ![[Pasted image 20250318044757.png]]

How Shadcn did it was by using cva utility which allowed you to configure variants of a component, whose styles and behavior is changed by classes. As a brief review, recall that cva syntax looks like:
```
  import { cva } from 'class-variance-authority';
    
    const buttonVariants = cva(
      'text-base font-semibold px-4 py-2',
      {
        variants: {
          color: {
            primary: 'text-white bg-blue-500',
            secondary: 'text-blue-500 bg-white',
          },
          size: {
            sm: 'text-sm',
            lg: 'text-lg',
          },
        },
        defaultVariants: {
          color: 'primary',
          size: 'sm',
        },
      }
    );
    
    buttonVariants({ color: 'secondary', size: 'lg' }); 
    // Result: 'text-base font-semibold px-4 py-2 text-blue-500 bg-white text-lg'
```

In addition, Shadcn built out the cva and component code from Radix UI library which have ARIA ready components (therefore is accessible and helps with SEO). Proof:
1. Look at a simple Shadcn component like Button:
   https://ui.shadcn.com/docs/components/button
2. Installation using CLI tells you to use the shadcn CLI:
   ![[Pasted image 20250318045024.png]]
3. But if you had chosen Installation using Manual:
   ![[Pasted image 20250318045141.png]]

Here's some important points of the code:
- Radix ui is behind the component you would have installed using the Shadcn CLI.
- Radix ui's Slot is used. For information on how Slot works, refer to [[Shadcn component under the hood Radix UI using Slot]]
- cn which is an implementation that combined clsx and tailwind merge in a syntatic sugar utility function cn.
- cva is used to setup variants of the button that you can init to a specific variant by passing props to match the variant and therefore renders the component with different classes. If a variant option is not passed or any variant option is passed at all, the defaultVariants are used.
- Code with focused parts:
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


---

### **Summary**

- **Tailwind Merge**: Resolves Tailwind CSS class conflicts in both React and Next.js projects.
- **cn Utility**: Combines `clsx`'s conditional class rendering with Tailwind-merge’s conflict resolution, ensuring clean and dynamic class names.
- **CVA**: Enhances the handling of class variants for complex reusable components, simplifying styling logic in React and Next.js.
- **shadcn**: A customizable component system that prioritizes reusability and Tailwind integration, popular in React/Next.js design workflows.

Each of these tools plays a pivotal role in modern UI development for **React** and **Next.js**, emphasizing customizability and streamlined class handling. Together, they form a powerful ecosystem for building scalable front-end systems.