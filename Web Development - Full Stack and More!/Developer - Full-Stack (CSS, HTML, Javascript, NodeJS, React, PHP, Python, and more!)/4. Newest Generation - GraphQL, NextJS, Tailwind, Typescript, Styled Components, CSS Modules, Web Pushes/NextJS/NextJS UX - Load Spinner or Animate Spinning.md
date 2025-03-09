

The tailwind class .animate-spin should spin like this (graphic not included with using the class alone):

![[Pasted image 20250309044102.png]]

![[Pasted image 20250309044115.png]]

Code:
```
<svg className="mr-3 -ml-1 size-5 animate-spin text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle><path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
```

You may need to install tailwind’s animation as a plugin:
```
npm install tailwindcss-animate
```

Then at the tailwind config:
```
  plugins: [require("tailwindcss-animate")],
```

And if it’s not doing that, firstly make sure the class animate-spin is not being purged from the css file by making sure tailwind.config.js `content`  path includes your file:
```
  content: [  
    "./pages/**/*.{js,ts,jsx,tsx}",  
    "./components/**/*.{js,ts,jsx,tsx}",  
    "./app/**/*.{js,ts,jsx,tsx}",  
  ],
```

And you can also whitelist the filename:
```
  safelist: [  
    'animate-spin'  
  ],
```

And if that doesn’t work, some css may be stripped away. Extend by adding:
```
  theme: {  
      animation: {  
        spin: "spin 1s linear infinite",  
      },  
      keyframes: {  
        spin: {  
          "0%": { transform: "rotate(0deg)" },  
          "100%": { transform: "rotate(360deg)" },  
        },  
      },  
  },
```

So your tailwind config could look like:
```
import type { Config } from 'tailwindcss';  
  
const config: Config = {   
  safelist: [  
    'animate-spin'  
  ],  
  content: [  
    './pages/**/*.{js,ts,jsx,tsx,mdx}',  
    './components/**/*.{js,ts,jsx,tsx,mdx}',  
    './app/**/*.{js,ts,jsx,tsx,mdx}',  
  ],  
  theme: {  
    extend: {  
    },  
    keyframes: {  
      spin: {  
        "0%": { transform: "rotate(0deg)" },  
        "100%": { transform: "rotate(360deg)" },  
      }  
    },  
  },  
  plugins: [require("tailwindcss-animate")],  
} satisfies Config

export default config;
```