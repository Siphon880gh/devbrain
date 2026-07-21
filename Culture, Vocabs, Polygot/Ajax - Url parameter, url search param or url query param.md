
## Deep Dive

Url parameters vs url query parameters

| Aspect           | URL Parameters                             | URL Query Parameters                   |
|------------------|--------------------------------------------|----------------------------------------|
| Location         | Part of the URL path                       | After the ? in the URL                 |
| Format           | /resource/<parameter>                      | ?key1=value1&key2=value2               |
| Purpose          | Used for hierarchical resources            | Used for filtering, sort, search, etc. |
| Mandatory?       | Typically mandatory to identify a resource | Generally optional                     |
| Structure        | Hierarchical and positional                | Flat key-value structure               |
| Order Sensitive? | Yes                                        | Yes                                    |


For example in Node JS it's quite clear in the syntax it's a url parameter
```
⁠const express = require('express');  
const app = express();  
  
// Define a route with a URL parameter (e.g., :id)  
app.get('/users/:id', (req, res) => {  
  const userId = req.params.id; // Access the URL parameter  
  res.send(`User ID is: ${userId}`);  
});  
  
// Start the server  
app.listen(3000, () => {  
  console.log('Server running on http://localhost:3000');  
});
```

In js it's URLSearchParams which is url query parameter however due to historic reasons, it's not URLQueryParams:
- The term "search params" originates from how the query string was often used in early web implementations—to perform searches or filter data on a web page. This historical naming stuck, even though query parameters have broader use today
```
// Example URL: http://example.com?page=2&sort=desc  
  
// Get query parameters from the current URL  
const urlParams = new URLSearchParams(window.location.search);  
  
// Get a specific query parameter  
const page = urlParams.get('page'); // "2"  
const sort = urlParams.get('sort'); // "desc"  
  
console.log(page, sort); // Output: 2 desc
```

API documentations might refer to parameters - they usually meant url query parameters, NOT url parameters

Eg. Here you see “parameters” section, have parameters in the form of &key=value in the api request endpoint
[https://crawlbase.com/docs/crawling-api/parameters/#token](https://crawlbase.com/docs/crawling-api/parameters/#token)

---

## Summary (Deep Dive)

So parameters are synonymous to url query parameters and url search parameters, especially when reading API documentation (You're using their documentation. It's easier for them to just call it parameters)

But url parameters are url parameter, especially when discussing designing api endpoints with team members. Eg.
GET songs/:songName


----

## Dependent parameters

In most API documentation, when one parameter triggers the requirement or allowance for additional parameters, those additional parameters are often referred to as dependent parameters  

Absolute requirement will mean they are: **dependent mandatory parameters**

Allowing for but not mandatory will mean they are: **dependent optional parameters**
