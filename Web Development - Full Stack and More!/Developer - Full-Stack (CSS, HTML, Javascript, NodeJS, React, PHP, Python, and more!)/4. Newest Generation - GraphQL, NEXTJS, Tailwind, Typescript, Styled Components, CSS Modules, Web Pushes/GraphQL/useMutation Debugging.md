Have an useEffect that runs on loading or data changes that are from an useMutation:
```
useEffect(()=>{
	if(!loading)
		console.log({loading,error,data});
	console.log(data);
	debugger;
}, [loading, data])
```