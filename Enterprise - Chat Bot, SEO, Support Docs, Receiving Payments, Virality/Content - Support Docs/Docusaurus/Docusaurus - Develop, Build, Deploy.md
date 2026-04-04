## Init Docusaurus  Project

```
npx create-docusaurus@latest app classic
```

Creates a new Docusaurus project using the starter pack boilerplate called "classic". The new project is in a folder `app/` from where you ran the command

Note: npx takes care of any necessary installation of docusaurus. So this stage is called Init a Docusaurus Project

FYI - If curious, you can see package.json has the standard start and build scripts:
```
{
...
  "scripts": {
    "docusaurus": "docusaurus",
    "start": "docusaurus start",
    "build": "docusaurus build",
...
```

## Develop

You can turn on hotreload developing:
```
npm run start
```

---
## Build

Create a build/ folder that can be self-hosted:
```
npm run build
```

---
## Deploy Online

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
npm run build
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