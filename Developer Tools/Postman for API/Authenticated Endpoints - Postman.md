
Lets say the frontend needs to make a POST or PATCH or PUT request to update a document on a backend API (Usually updating a document on a Mongo database, usually an admin API endpoint). That frontend could be an admin panel where you update your SaaS users' add-on features.

We will make a request to Postman to test the admin panel's request to create a new user with specific add-on features.

Here on Postman:
![[Pasted image 20250702184206.png]]

Notice there's an Authorization tab that makes it easier for you:
![[Pasted image 20250702184234.png]]

The authorization tab automatically adds the Authorization header along with the qualifier (aka authorization header) in the header value. Take a look at the two screenshots of the tabs Headers and Authorization, of how the term "Bearer" was automatically added for you in the Header value. For this to work, in Postman you edit the Authorization in the Authorization tab and instead of typing in the Authentication Scheme, you select the Authentication. Then you may edit the Headers but never edit the Authorization Header directly. This would be the easiest way in Postman to deal with Authenticated API endpoints:
![[Pasted image 20250702184553.png]]