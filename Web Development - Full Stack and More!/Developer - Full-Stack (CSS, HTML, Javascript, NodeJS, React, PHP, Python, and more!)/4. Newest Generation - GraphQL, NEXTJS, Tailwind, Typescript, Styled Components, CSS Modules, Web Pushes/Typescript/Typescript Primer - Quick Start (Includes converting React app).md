
If not a npm project yet (if no package.json)
```
npm init --y
```


Install and initiate tsc
```
npm install --save-dev typescript
npx tsc --init
```

Mnemonic: tsc stands for typescript compiler.

Install types for your environment. Without this, you’ll find soon enough that you get  errors with require, fs, etc. so:
```
npm install --save-dev @types/node
```

Let's edit the tsconfig.json:
Keep in mind .ts is for regular js files and .tsx is for jsx files (React components)
```
   {
     "compilerOptions": {
       "target": "es2020",
       "module": "commonjs",
       "strict": true,
       "esModuleInterop": true,
       "skipLibCheck": true,
       "forceConsistentCasingInFileNames": true,
       "outDir": "./dist"
     },
     "include": ["src/**/*.ts"],
     "exclude": ["node_modules"]
   }
```

You can edidt package.json like this:
```
    "start": "npx tsc; node index.js"
```


So now when you run `npm start` , it’ll recompile the .ts files into .js file, then run the entry .js fileType. Or it'll recompile the .tsx files into .jsx files

For a full guide, refer to [[Typescript Primer - Full Guide]]


----

If converting a create-react-app into typescript in the middle of your development. Key points:

- tsconfig.js should have .tsx in settings (Mnemonic: Think Typescript XML, because JSX is javascript XML)
- You can create an App.tsx and remember that will replace App.jsx when building. But if running HMR, it'll just run off you tsx files (webpack that's part of create-react-app is perfectly capable of running off tsx files and is more performant instead of rewriting a new file every time you save a change in a tsj file)
- Your package.json needs `npx tsc` to convert the tsx file into jsx files before building or running HMR off your files

```
"start": "npx tsc; react-scripts start",

"build": "npx tsc; react-scripts build",
```

Your tsconfig.json must have jsx flag:
```
{
  "compilerOptions": {
    "target": "es2020",
    "module": "commonjs",
    "strict": true,
    "esModuleInterop": true,
    "jsx": "react-jsx",  // Enable JSX support, use "react" for older TS versions
    "skipLibCheck": true,
    "forceConsistentCasingInFileNames": true,
    "outDir": "./dist"
  },
  "include": ["src/**/*.tsx", "src/App.tsx"],
  "exclude": ["node_modules"]
}
```