AKA: Getting Started

Their official website:
https://docusaurus.io/

Docusaurus is a free, open-source documentation framework developed by engineers at Meta. Built on ReactJS, it's ideal for support documentation and offers the flexibility to be fully self-hosted and self-managed.

You can freely write Markdown (`.md`) files using any folder structure, and Docusaurus will automatically generate a sidebar navigation based on that structure. It also includes built-in pagination—Previous and Next buttons are automatically added to each page.

For advanced use cases, Docusaurus supports MDX (Markdown + JSX), letting you embed React components directly within your docs. You can also choose to start your project with TypeScript if preferred.

Its lightweight architecture makes it easy to customize both the website layout and the documentation content. Write your docs using your favorite Markdown editor, or use the Markdown Preview extension in VS Code for live feedback.
#### Key Features:
- ReactJS-based framework
- Automatic sidebar generation from folder structure
- No coding required to write documentation
- Simple setup and build process
- Fully self-hosted and customizable
#### Additional Features:
- MDX support for mixing Markdown and JSX
- Optional TypeScript support
- Blog functionality (can be disabled)
- Localization and translation support
- Versioning for managing multiple doc versions
- Automatic pagination with Previous/Next navigation

---

Versioning:
![[Pasted image 20250521233403.png]]

Prev/Next Pagination:
![[Pasted image 20250521233415.png]]

Localization/Translation:
docusaurus.config.js:
```
export default {  
  i18n: {  
    defaultLocale: 'en',  
    locales: ['en', 'fr'],  
  },  
};
```
