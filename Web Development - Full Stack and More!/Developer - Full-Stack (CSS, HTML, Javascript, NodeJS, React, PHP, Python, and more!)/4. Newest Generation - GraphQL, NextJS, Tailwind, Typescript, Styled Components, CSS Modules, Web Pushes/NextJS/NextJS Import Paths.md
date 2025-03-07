Next.js serves static assets, like images, from the /public folder. Files inside /public can be referenced directly in your application using absolute paths:
```
import Logo from "/logo.png";
```

For relative imports within the project, you can reference files using either of these syntaxes:
```
import data from "./data/users.mock.json"; // Relative to the current file
import data from "data/users.mock.json";   // Relative to a configured module path
```

Next.js also supports importing modules from node_modules (or fetching them into the app at build time - Next.js has such built-in support for Google Fonts `next/font/google`). If using an import path with forward slashes, ensure it does not accidentally match a relative folder structure:
```
import { Inter } from 'next/font/google';
import SomePackage from 'some-package';
```

For absolute imports relative to the Next.js app root (where next.config.js or tsconfig.json is configured), use the @ alias:
```
import '@/app/ui/global.css';
```
