**Note (effective May 2025):** Heroku will skip your `"build"` script if you define a `"postbuild"` hook. To run both, chain them together. For example, in your **package.json**:

```json
{
  // ...
  "scripts": {
    "build": "vite build", // your regular build
    "heroku-postbuild": "npm run build && mkdir ./.cache"
  }
}
```

For more details, see Heroku’s Node.js build process docs: [https://devcenter.heroku.com/articles/nodejs-support#customizing-the-build-process](https://devcenter.heroku.com/articles/nodejs-support#customizing-the-build-process).