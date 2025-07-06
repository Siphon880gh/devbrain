
Error reads:
```
⨯ Error: Expected to use Webpack bindings (react-server-dom-webpack/server.edge) for React but the current process is referencing 'createClientModuleProxy' from the Turbopack bindings (react-server-dom-turbopack/server.edge). This is likely a bug in our integration of the Next.js server runtime.  
    at [project]/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/client/components/error-boundary.js (client proxy) <module evaluation> (.next/server/chunks/ssr/a7abb_next_dist_284c2f._.js:12669:9)  
    at instantiateModule (.next/server/chunks/ssr/[turbopack]_runtime.js:590:23)  
    at getOrInstantiateModuleFromParent (.next/server/chunks/ssr/[turbopack]_runtime.js:645:12)  
    at esmImport (.next/server/chunks/ssr/[turbopack]_runtime.js:132:20)  
    at [project]/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/client/components/error-boundary.js [app-rsc] (ecmascript) (.next/server/chunks/ssr/a7abb_next_dist_284c2f._.js:12684:315)  
    at instantiateModule (.next/server/chunks/ssr/[turbopack]_runtime.js:590:23)  
    at getOrInstantiateModuleFromParent (.next/server/chunks/ssr/[turbopack]_runtime.js:645:12)  
    at esmImport (.next/server/chunks/ssr/[turbopack]_runtime.js:132:20)  
    at [project]/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/esm/build/templates/app-page.js?page=/products/[id]/page { MODULE_0 => "[project]/app/layout.tsx [app-rsc] (ecmascript, Next.js server component)", MODULE_1 => "[project]/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/client/components/not-found-error.js [app-rsc] (ecmascript, Next.js server component)", MODULE_2 => "[project]/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/client/components/forbidden-error.js [app-rsc] (ecmascript, Next.js server component)", MODULE_3 => "[project]/node_modules/.pnpm/next@15.1.6_react-dom@19.0.0_react@19.0.0__react@19.0.0/node_modules/next/dist/client/components/unauthorized-error.js [app-rsc] (ecmascript, Next.js server component)", MODULE_4 => "[project]/app/products/[id]/page.tsx [app-rsc] (ecmascript, Next.js server component)" } [app-rsc] (ecmascript) <module evaluation> (.next/server/chunks/ssr/_9ae78e._.js:165:304)
```

Remove previous build with command:
```
rm -rf .next
```

Then build and start again:
```
npx next build
npx next start
```