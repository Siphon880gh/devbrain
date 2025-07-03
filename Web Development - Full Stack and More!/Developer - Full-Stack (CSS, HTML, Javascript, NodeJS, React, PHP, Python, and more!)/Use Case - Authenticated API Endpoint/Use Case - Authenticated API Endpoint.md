Applies to any backend: Express, PHP, etc
Applies to any requester (may be frontend): JS frontend, Express connecting to an external API, API testers, n8n (Automation service connecting to your API endpoint), cURL testing the api endpoint from your terminal

Lets say the frontend needs to make a POST or PATCH or PUT request to update a document on a backend API (Usually updating a document on a Mongo database, usually an admin API endpoint). That frontend could be an admin panel where you update your SaaS users' add-on features.

We will demonstrate this on API testers and other frontends.

This one is just an Authorization header with plain password:
![[Pasted image 20250702183219.png]]

^ Notice that there is a qualifier "Basic" (aka authorization header) before the password inside the header value. This is standard practice of API design because the Authorization could be basic, Bearer token, or any of the other various possible types of Authorization, and you want to be clear on that and also in case you may support multiple types of Authorization:

Of course, if you code the server, you can do whatever you want. Here's an non-standard practice of not qualifying the header value with the type of authorization (here in n8n frontend):
![[Pasted image 20250702183039.png]]


And here's another type of Authorization - Bearer Token:
![[Pasted image 20250702183420.png]]

---

If it were on Postman (as frontend API tester):
![[Pasted image 20250702184206.png]]

Notice there's an Authorization tab that makes it easier for you:
![[Pasted image 20250702184234.png]]

The authorization tab automatically adds the Authorization header along with the qualifier (aka authorization header) in the header value. Take a look at the two screenshots of the tabs Headers and Authorization, of how the term "Bearer" was automatically added for you in the Header value. For this to work, in Postman you edit the Authorization in the Authorization tab and instead of typing in the Authentication Scheme, you select the Authentication. Then you may edit the Headers but never edit the Authorization Header directly. This would be the easiest way in Postman to deal with Authenticated API endpoints:
![[Pasted image 20250702184553.png]]