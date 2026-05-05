
You may have to install multiple dependencies and they have to be all compatible with each other. The version numbers matter. Here's how to investigate what version numbers are correct.

## Version Conflicts - Example
  
While you must install graphql and @apollo/client on the client side, and graphql and @apollo/server on the server side - you have to make sure their versions are compatible. You can look at the package.json of existing full stack graphql repos for which versions to install with npm. Or you may have the versions written on paper. But if you don’t have this resource, your other option is to install the latest of every package by not specifying the version when running npm install  
  
However, if you need to have a specific version of @apollo/client or a specific version of @apollo/server, you should look up the version number on their npm repo page, then get the rough date. Go to the other @apollo npm page and find an equivalent version based on the date. If there are multiple candidates based on the date, do not go for version 0.0.0 or beta’s or alphas.  
  
Then you need to know the graphql version. Click Runkit at @apollo/client for the graphql version to install on your client side - click the package.json at Runkit. Click Runkit at @apollo/server for the graphql version to install on your server side - click the package.json at Runkit.  
  
[https://www.npmjs.com/package/@apollo/client](https://www.npmjs.com/package/@apollo/client)  
[https://www.npmjs.com/package/@apollo/server/](https://www.npmjs.com/package/@apollo/server/)  
  
You’d have found those links at npmjs.com searching for “@apollo/client” or “@apollo/server”