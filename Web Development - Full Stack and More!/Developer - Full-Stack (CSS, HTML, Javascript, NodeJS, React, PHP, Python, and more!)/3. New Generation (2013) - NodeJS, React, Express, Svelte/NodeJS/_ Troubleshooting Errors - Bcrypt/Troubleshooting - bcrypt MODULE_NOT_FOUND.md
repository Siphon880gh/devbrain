Error is for "bcrypt": "^5.1.1"

Problem: 
When either you locally build or when Vercel builds it during deployment:
```
npx next build
```

You get Bcrypt error module not found:
```
   Collecting page data  ..[Error: Cannot find module '/Users/wengffung/dev/web/nextjs/nextjs-dashboard/node_modules/.pnpm/bcrypt@5.1.1/node_modules/bcrypt/lib/binding/napi-v3/bcrypt_lib.node'  
Require stack:  
- /Users/wengffung/dev/web/nextjs/nextjs-dashboard/node_modules/.pnpm/bcrypt@5.1.1/node_modules/bcrypt/bcrypt.js  
- /Users/wengffung/dev/web/nextjs/nextjs-dashboard/.next/server/app/seed/route.js  
- /Users/wengffung/dev/web/nextjs/nextjs-dashboard/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/server/require.js  
- /Users/wengffung/dev/web/nextjs/nextjs-dashboard/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/server/load-components.js  
- /Users/wengffung/dev/web/nextjs/nextjs-dashboard/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/build/utils.js  
- /Users/wengffung/dev/web/nextjs/nextjs-dashboard/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/build/worker.js  
- /Users/wengffung/dev/web/nextjs/nextjs-dashboard/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/compiled/jest-worker/processChild.js] {  
  code: 'MODULE_NOT_FOUND',  
  requireStack: [Array]  
}  
  
> Build error occurred  
[Error: Failed to collect page data for /seed] { type: 'Error' }
```

You have two solutions. You follow one of them

Solution one (requires editing package.json):

1. Add postinstall script into package.json (goes under "scripts":)
```
"postinstall": "cd node_modules/bcrypt && npx node-pre-gyp install --fallback-to-build"  
```

3. Postinstall automatically runs after you npm install or after Vercel runs npm install. Since you already installed bcrypt, let's manually trigger postinstall now: npm run postinstall
4. FYI Explanation: Someone commented it’s a Mac problem of Bcrypt for some reason not compiling so we have to manually compile it after npm install (so hence the postinstall script). Another person commented that the real way to fix it is `sudo npm i --unsafe-perm`  (Allows scripts within npm packages to run with root privileges... perms is permissions), then after that install bcrypt.

---

Solution two (requires swapping out Bcrypt and editing the app code and editing package.json):

1. At package.json: "bcrypt": "^5.1.1", → "bcryptjs": "^3.0.2",
2. Delete node_modules folder
3. Install packages again
4. Adjust code where Bcrypt imported and Bcrypt used. We now use bcryptjs:
app/seed/route.ts:
```
import postgres from 'postgres';  
..  
const hashedPassword = await bcryptjs.hash(_user_.password, 10);
```

5. Add postinstall script into package.json (goes under "scripts"):
```
"postinstall": "npm rebuild bcrypt --build-from-source"
```

6. Postinstall automatically runs after you npm install or after Vercel runs npm install. Since you already installed bcrypt, let's manually trigger postinstall now: npm run postinstall
7. FYI Explanation: Bcrypt js is implemented in javascript instead of C++. The methods are all the same. You still have to compile it after installing the package so hence the postinstall script.

---

If error still persists at Vercel deploy:

- Did you commit the fix and push up to Github (because you've linked Vercel to that GitHub repo)
- If error still persists: Create the database in the next step of the tutorial, then once you have database on vercel, try to Vercel deploy again