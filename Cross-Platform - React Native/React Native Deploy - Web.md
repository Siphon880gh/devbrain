
Refer to:
https://docs.expo.dev/distribution/publishing-websites/

Build web by running from the app root:
```
npx expo export -p web
```

Optional: Serve locally to test how it will look online:
```
npx serve dist --single
```


By default will create a dist/ folder at the app's root 

---

### Public Path?

By default the bundle and index.html refers to asset files relative to the domain "/...js"

You have to set the public path at two places.

#### App.json

You can set the public path at: `app.json`

    "experiments": {
      "baseUrl": "/mixo"
    }

Bad instructions online:
- There are unofficial online instructions about adding settings to `app.json` or `app.config.json`. What worked for me was app.json. 
- There are also unofficial online instructions and outdated ChatGPT instructions to use `expo.web.publicPath`, however Expo has quietly removed that in favor for `expo.experiments.baseUrl`.


#### Webpack

Your webpack.config.js before it returns the config, you add the publicPath like so:
```
  // Ensure that publicPath is set to /mixo/
  config.output = {
    ...config.output,
    publicPath: '/mixo/',  // Force publicPath to be /mixo/
  };
```

If you don't have a webpack.config.js, you can create the file at the app root, and here is the rest of the webpack.config.js:
```
// webpack.config.js
const createExpoWebpackConfigAsync = require("@expo/webpack-config");

module.exports = async function (env, argv) {
  const config = await createExpoWebpackConfigAsync(
    {
      ...env,
      babel: {
        dangerouslyAddModulePathsToTranspile: ["nativewind"],
      },
    },
    argv,
  );

  // Ensure that publicPath is set to /mixo/
  config.output = {
    ...config.output,
    publicPath: '/mixo/',  // Force publicPath to be /mixo/
  };

  config.module.rules.push({
    test: /\.css$/i,
    use: ["postcss-loader"],
  });

  return config;
};
```