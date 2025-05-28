
You can use Tailwind’s @apply directive to create reusable CSS classes by grouping multiple utility classes together inside your CSS file. This is useful for keeping your HTML cleaner and reducing repetition.

### Example:

#### 1. Create a Custom Class Using `@apply`

Inside your CSS file (e.g., `styles.css`):
```
@tailwind base;  
@tailwind components;  
@tailwind utilities;  
  
.btn-custom-blue {  
    @apply bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 mx-auto w-fit cursor-pointer transition-all duration-300;  
}
```

####  2. Use It in Your HTML:
```
<button class="btn-custom-blue">Click Me</button>
```

It will render as:
![[Pasted image 20250309045240.png]]

Notes:
- The `@apply` directive works **only in a CSS file** (not directly in an HTML file).
- Tailwind’s `@apply` is meant for extracting reusable styles but won’t work with dynamic variants like `hover:`, `md:`, etc., unless you define them explicitly.
- As an extra precaution to make sure the styling works, `@apply` should be inside the `@layer components` section (More on the next section)

---

### Prevent Purging etc

If your tailwind is part of a tool that purges css (such as PurgeCSS, PostCSS, or Tailwind's built-in JIT mode), **some custom styles might be removed** if they aren't explicitly present in your HTML or JavaScript files.

By defining your custom classes inside `@layer components`, Tailwind treats them as part of its core system and keeps them in the final CSS output even if they aren't explicitly found in your templates. 

Why is it called layer components? Tailwind's Layered Styling System organizes styles into different layers to control the CSS cascade and optimize maintainability and it goes in the order of base -> components -> utilities.

Let's add the `@layer components`:

```
@tailwind base;  
@tailwind components;  
@tailwind utilities;  

@layer components {
	.btn-custom-blue {  
	    @apply bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 mx-auto w-fit cursor-pointer transition-all duration-300;  
	}
}
```

---

### Recommended organization

If you have multiple custom reuseable classes to apply Tailwind classes, you can group them like so:

```
@tailwind base;
@tailwind components;
@tailwind utilities;

/* 🔵 Button Styles */
@layer components {
  .btn {
    @apply font-bold py-2 px-4 rounded;
  }
  .btn-primary {
    @apply btn bg-blue-500 text-white hover:bg-blue-600;
  }
  .btn-secondary {
    @apply btn bg-gray-500 text-white hover:bg-gray-600;
  }
}

/* 🟢 Card Styles */
@layer components {
  .card {
    @apply bg-white shadow-md rounded-lg p-6;
  }
  .card-title {
    @apply text-xl font-bold text-gray-800;
  }
  .card-body {
    @apply text-gray-600;
  }
}

/* 🔴 Form Styles */
@layer components {
  .input-field {
    @apply border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400;
  }
  .form-label {
    @apply text-gray-700 font-semibold;
  }
}

```


---

### Official name for these classes?

Annoyingly, tailwind does not have an official name for these reuseable classes. They just call it using "@apply" directive. And having it inside `@layer components` was just adding the reuseable class to one of the core layers of Tailwind.
https://tailwindcss.com/docs/functions-and-directives#apply-directive

