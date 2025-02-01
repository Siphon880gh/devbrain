This is localhost:3001/sandbox for a vite-react 18 full stack app. The backend has graphql with auth middleware that gives you a json web token upon successful login or signup

Creating an user will give you a token because that's how on the frontend you sign up.

![](P73TmeX.png)
^ Opps admittingly the Documentation panel wasn't on the createUser query. This brings up the point that the Documentation panel can be separate from the Operation panel.

>A note on the mutation syntax:
Notice that `mutation CreateUser($userInput: UserInput)` line could have been `mutation ($userInput: UserInput` without that operation name. The mutation "function name" that's matched to backend's typeDefs.js is actually at the second line `createUser(userInput: $userInput`. However it's recommended you keep the full operation name because the common practice is to copy queries/mutations that work from the sandbox into the frontend and keeping the operation name will allow you to inspect network requests (at Inspect -> Network tab) more easily because all requests send to /graphql endpoint and it's the operation name that appears (otherwise it's a generic name that appears)


  At the Documentation panel, clicking at the query/mutation will add into the Operation panel. Similarly, clicking add icon for an argument or field will add them respectively into the arguments part of the Operation code or the return fields of the Operation code.

Operation:
```
mutation CreateUser($userInput: UserInput!) {  
  createUser(userInput: $userInput) {  
      token,  
      user {  
        user_name  
      }  
  }  
}
```

Variables:
```
{  
  "userInput": {  
    "email": "gogo@gmail.com",  
    "password": "gogo",  
    "phone": "123-123-1234",  
    "user_name": "gogo"  
  }  
}
```


See that the response returned a token. You can be "logged in" because you just signed up. And you can view member only resources. Just make sure to send it as Headers, not Variables:
![](0DXjlE4.png)

![](ZTYbf9n.png)


You switch to Headers tab
Your key entry is: Authorization
The value entry is: Bearer token

Place your token in place of "user-1"

---

The left strip toolbar:
![](SFov0Pf.png)

First icon that looks like a mindmap lists all the schemas of your graphql backend typedefs.js.  Lets call the window that loads from this icon the Schema window.

Second icon is "Play" or "Run" icon that has the Documentation panel and Operation panel. Lets call this the Run Query window

While in that Schema window, you can click "Play" or "Run" on a query or mutation to open the  Run Query window with the information transferred into the Documentation panel.