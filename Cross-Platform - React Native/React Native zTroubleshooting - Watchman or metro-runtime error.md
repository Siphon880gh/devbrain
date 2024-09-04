
If your app keeps talking about watchman (and you’ve installed it for your system) and then talk about metro-runtime. 

Create the React Native app then run these lines:
```
rm -rf node_modules  
npm install  
npx expo install @expo/metro-runtime  
  
npm start
```

If this error happens with all example boilerplates you generate from Expo which is annoying (`npx create-expo APP --example EXAMPLE`) because it would have greatly benefited you in starting projects quickly with boilerplates: You could create a script in your ~/.bash_profile or equivalent that you remember to run inside the newly generated boilerplate. Or you could create a script that runs the `create-expo` command, with your boilerplate name as an argument, then run the rest of the script to run the above fix.

