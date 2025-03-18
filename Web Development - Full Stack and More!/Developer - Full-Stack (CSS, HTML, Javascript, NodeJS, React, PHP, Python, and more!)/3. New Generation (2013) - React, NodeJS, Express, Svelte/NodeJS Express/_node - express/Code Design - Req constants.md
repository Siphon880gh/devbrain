You can have global variables available to all routes, but a nice code design is to have variables passed down to all req objects.

The key is to use a middleware that assigns properties to req and then calls next(). On all future routes, that property will be available to req without the client sending it.

```
const express = require("express");
const app = express();

app.use(express.urlencoded({extended:true}));
app.use(express.json());

app.use((req,res,next)=>{
	req.firstName = "John";
	next();
});

app.get("/:lastName", (req,res)=> {
	const lastName = req.params.lastName;
	res.json({
		fullName: req.firstName + " " + lastName
	});
});

app.listen(3001, ()=>{
	console.log("Listening to port");
});


```