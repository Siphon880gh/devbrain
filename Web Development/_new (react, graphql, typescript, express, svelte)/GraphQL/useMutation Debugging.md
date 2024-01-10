
```
useEffect(()=>{
	if(!loading)
		console.log({loading,error,data});
}, [loading, data])
```