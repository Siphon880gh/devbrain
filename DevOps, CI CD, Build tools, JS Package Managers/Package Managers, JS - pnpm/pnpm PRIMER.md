Aka: Get Started


A npm alternative is pnpm (Performant npm) to init, install, and manage the packages.

Just like npm, it uses package.json  and the package.json contents don’t need to be adjusted for pnpm to work.

NextJS documents officially recommend pnpm over npm. It uses less space, is faster, and has better version conciliation.

To init a project to have a package.json:
```
pnpm init
```

If there already is a package.json in a code repo, choose either npm or pnpm (Performant npm) to install and manage:
```
pnpm install
```

---

To reset to a new redownload of package modules:
1. delete package-lock.json 
2. delete pnpm-lock.yaml 
3. Then install packages

---


Commands are pretty similar with some differences.

Some command differences include:
`pnpm cache delete` instead of `npm cache clean`