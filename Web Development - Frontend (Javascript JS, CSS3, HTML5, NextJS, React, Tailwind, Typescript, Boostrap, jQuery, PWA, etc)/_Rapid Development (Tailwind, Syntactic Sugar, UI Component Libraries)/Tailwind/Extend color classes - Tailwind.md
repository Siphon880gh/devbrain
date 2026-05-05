Let's say you want to add color classes to tailwind 
```
        chambray: {  
          '50': '#f0f7fe',  
          '100': '#deecfb',  
          '200': '#c5dff8',  
          '300': '#9dccf3',  
          '400': '#6eaeec',  
          '500': '#4c90e5',  
          '600': '#3775d9',  
          '700': '#2e60c7',  
          '800': '#2b4fa2',  
          '900': '#284581',  
          '950': '#1d2b4e',  
        },
```
- So you can follow the same convention for text or background etc:
	- Background: `<div class="bg-chambray-500 text-white p-4">...`
	- Text: `<p class="text-chambray-500">...`
	- Border: `<div class="border-4 border-chambray-700 p-4">...`

---


To add this custom color (`chambray`) to your Tailwind CSS configuration, you need to extend the theme in your **`tailwind.config.js`** file.

### Steps:

1. Open **`tailwind.config.js`** in your project.
2. Modify the `extend` section inside the `theme` object.
3. Add your color definitions under `colors`.

### Example:

```js
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"], // Adjust paths as needed
  theme: {
    extend: {
      colors: {
        chambray: {
          '50': '#f0f7fe',
          '100': '#deecfb',
          '200': '#c5dff8',
          '300': '#9dccf3',
          '400': '#6eaeec',
          '500': '#4c90e5',
          '600': '#3775d9',
          '700': '#2e60c7',
          '800': '#2b4fa2',
          '900': '#284581',
          '950': '#1d2b4e',
        },
      },
    },
  },
  plugins: [],
};
```

### Usage in Tailwind Classes:

Once added, you can use it in your HTML or JSX files like this:

```html
<div class="bg-chambray-500 text-white p-4">
  This div has a chambray background!
</div>
```

```html
<button class="bg-chambray-700 hover:bg-chambray-600 text-white px-4 py-2 rounded">
  Click Me
</button>
```

This will allow you to use `chambray-50` to `chambray-950` just like any other Tailwind color.