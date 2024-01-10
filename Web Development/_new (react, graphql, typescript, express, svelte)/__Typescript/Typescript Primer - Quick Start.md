
```
npmt init --y

npm install --save-dev @typescript
npx tsc --init
```

Now there’s a tsconfig.json file. Edit as you desire.

You’ll find soon enough that you get this error with require, fs, etc. so:
```
npm install --save-dev @types/node
```

You can edidt package.json like this:
```
    "start": "npx tsc; node index.js"
```


So now when you run `npm start` , it’ll recompile the .ts files into .js file, then run the entry .js fileType

For a full guide, refer to [[Typescript Primer - Full Guide]]