Titled: Set port number for the hot reload previewing in web browser

**How**

By default CRA assigns 3000 or a higher number, but you may pre-assign a port at .env  with PORT=3002 , for example. The .env file must be at the same level where the package.json for cra is at and the variable must be PORT.

This seems like a very generic convention using PORT as the variable but unfortunately CRA has chosen it. 


**Do you really need to?**

Usually you don’t need to assign a custom port number because you really only need one react app on developmental hot reload preview in the web browser because you are changing code and seeing the changes reflected immediately in the web browser.

When you assign ports it’s usually for having multiple apps on the same server on the internet which is not the case for CRA port. You would deliver the built build/ files in that case.