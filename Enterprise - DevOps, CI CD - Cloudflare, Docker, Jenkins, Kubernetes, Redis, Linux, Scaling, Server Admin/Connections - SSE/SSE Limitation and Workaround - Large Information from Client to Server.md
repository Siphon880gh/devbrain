SSE when the browser initiates a connection to the server, which gives the server permission to send data to the client on the server's own basis until it closes - it has limitations

When initiating a connection to the server and you want to send information from the client to the server, you're limited to url query because post body is not allowed.

Say you have a video making app and user added too many scenes and too many options, and the primary way your SSE tells the backend to make the video is to send that information directly from the UI to the SSE url. This is not a good design. User may cause the URL to be too long, causing this vague error:

`ERR_HTTP2_PROTOCOL_ERROR` which is a vague error ranging from anything to the web server running out of space to the SSE header being too long

---

The solution is to make a POST request with the client/user's information and then save it as a JOB (maybe inside a job collection in Mongo) and return the JOB_ID as the response to the POST request.

Then when creating the SSE connection, the URL can have the Job ID. Then the backend will look up the Job ID for the client/user's information which are the options to how to make the video.