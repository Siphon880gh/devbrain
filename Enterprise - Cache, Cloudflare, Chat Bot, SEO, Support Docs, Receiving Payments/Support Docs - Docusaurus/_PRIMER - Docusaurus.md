AKA: Getting Started

**Docusaurus is a free-to-use software** built by engineers at Meta. Docusaurus is a customizable open-source tool built on ReactJS. It can be self-hosted and self-managed. It supports MDX – Markdown language standards and JSX – Javascript XML to write HTML in ReactJS

Their official website:
https://docusaurus.io/

---

Example offline docs using Docusaurus - Botpress V12 documentations:
https://github.com/botpress/documentation-v12

To set this up:
```
nvm use 14
yarn install
yarn build
yarn start
```

See package.json has:
```
{
  "name": "docs-v-2",
  "version": "0.0.0",
  "private": true,
  "scripts": {
    "docusaurus": "docusaurus",
    "start": "docusaurus start",
    "build": "docusaurus build",
    "swizzle": "docusaurus swizzle",
    "deploy": "docusaurus deploy",
    "clear": "docusaurus clear",
    "serve": "docusaurus serve",
    "write-translations": "docusaurus write-translations",
    "write-heading-ids": "docusaurus write-heading-ids"
  },
  "dependencies": {
    "@docusaurus/plugin-google-gtag": "^2.0.0-beta.15",
    "@docusaurus/preset-classic": "^2.0.0-beta.15",
    "@docusaurus/theme-classic": "^2.0.0-beta.15",
    "@docusaurus/theme-live-codeblock": "^2.0.0-beta.15",
    "@docusaurus/theme-search-algolia": "^2.0.0-beta.15",
    "@mdx-js/react": "^1.6.21",
    "@svgr/webpack": "^5.5.0",
    "clsx": "^1.1.1",
    "docusaurus-gtm-plugin": "^0.0.2",
    "file-loader": "^6.2.0",
    "front-matter": "^4.0.2",
    "prism-react-renderer": "^1.2.1",
    "react": "^17.0.1",
    "react-dom": "^17.0.1",
    "react-player": "^2.10.0",
    "remark-admonitions": "^1.2.1",
    "url-loader": "^4.1.1"
  },
  "browserslist": {
    "production": [
      ">0.5%",
      "not dead",
      "not op_mini all"
    ],
    "development": [
      "last 1 chrome version",
      "last 1 firefox version",
      "last 1 safari version"
    ]
  },
  "devDependencies": {
    "@docusaurus/module-type-aliases": "^2.0.0-beta.16",
    "@tsconfig/docusaurus": "^1.0.4",
    "typescript": "^4.6.2"
  }
}

```

---

Taking it online

**URL**

If you're not using a subdomain like support.domain.com/, then you want to setup BASE_URL because `/` will work. For example, if you want to setup the url to be domain.com/docs, then set BASE_URL to `/docs/`. But of course if you setup the subdomain as the url, then you'll have to make sure your DNS is good (CNAME subdomain pointed to domain) and that https is good (Adding the new subdomain to your TSL/SSL certificate), but of course you don't want the subdomain to point anywhere else other than the actual root of your website when re-generating the TSL/SSL/https because it has to accurately produce an ACME challenge that can be reached at http:// (and it creates the ACME file relative to your true root).

**Setup baseUrl?**
```
 vi docusaurus.config.js
```

See 
```
  baseUrl: process.env.BASE_URL || "/",
```


**Build**
```
yarn build
```

**Deploy**

You can just copy the contents of the local `build/` folder as a new folder on your server. You can rename it to `docs/` if you're going with domain.com/docs. Make sure domain.com/docs open to that folder's index.html.

All should be good. If you get this message then you messed up:
```
Your Docusaurus site did not load properly.

A very common reason is a wrong site https://docusaurus.io/docs/docusaurus.config.js/#baseurl

Current configured baseUrl = / (default value)

We suggest trying baseUrl = /docs
```

If you don't get that message, you're good to go