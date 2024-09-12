
npm install:
```
npm install -D react-native-dotenv
```

babel.config.js (eg. original):
```
module.exports = function (api) {  
  api.cache(true);  
  return {  
    presets: ['babel-preset-expo'],  
    plugins: ['nativewind/babel']  
  };  
};
```

-->

Modified babel.config.js
```
module.exports = function (api) {  
  api.cache(true);  
  return {  
    presets: ['babel-preset-expo'],  
    plugins: [  
      'nativewind/babel','module:react-native-dotenv'  
    ]  
  };  
};
```

---

Test like this:

.env:
```
API_URL=https://wengindustries.com/test-api
```

server.js:
```
import { API_URL } from '@env';  
// ...
```