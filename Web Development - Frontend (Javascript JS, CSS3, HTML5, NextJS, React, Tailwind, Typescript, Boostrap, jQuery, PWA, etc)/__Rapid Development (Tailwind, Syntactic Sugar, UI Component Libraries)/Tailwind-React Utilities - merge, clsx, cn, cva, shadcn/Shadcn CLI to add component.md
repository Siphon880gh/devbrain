
You run:
```
npx shadcn@latest add accordion
```


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

## FAQ

### **Does It Replace Existing Buttons Automatically?**

No, the generated button component **does not overwrite or replace existing buttons** or their imports in your app. You'll need to manually import the Shadcn created component tsx file into whatever pages need it.