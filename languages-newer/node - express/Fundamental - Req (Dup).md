When setting up the route, the req can get you the client's FormData, URL path data, or query data: 
```
app.get("/api/:subpath?key1=value&key2=value", (req, res) => {
	let data1 = req.body;
	let data2 = req.params.subpath;
	let data3 = req.query.key;
	let data4 = req.query.key2;

	res.json({success:true});

});
```