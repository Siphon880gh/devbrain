Lets say a n8n node needs to make a POST or PATCH or PUT request to update a document on a backend API (Usually updating a document on a Mongo database, usually an admin API endpoint)

You have a HTTP Request node.

Depending on the server's documentation, your authentication method will differ. This one is just an Authorization header with plain password:
![[Pasted image 20250702183134.png]]


Notice that there is a qualifier "Basic" (aka authorization header) before the password inside the header value. This is standard practice of API design because the Authorization could be basic, Bearer token, or any of the other various possible types of Authorization, and you want to be clear on that and also in case you may support multiple types of Authorization:
![[Pasted image 20250702183219.png]]

Of course, if you code the server, you can do whatever you want. Here's an non-standard practice of not qualifying the header value with the type of authorization:
![[Pasted image 20250702183039.png]]


And here's another type of Authorization - Bearer Token:
![[Pasted image 20250702183420.png]]

