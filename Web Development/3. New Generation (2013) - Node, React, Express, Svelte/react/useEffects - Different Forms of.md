useEffect(cb) runs the callback as an effect of render or re-render


useEffect(cb, [...]) runs the callback as an effect of any variable changes in the array. React is monitoring the variables in the array.

  
useEffect(cb, []) runs the callback once because while technically as an effect, it should rerun whenever a variable inside the array changes, that is an empty array, and it must run once if the array is empty.

----

Other more advanced uses of useEffect

[[Await async in useEffect by using IIFE]]

[[Performance - Cleanup when unmounting using useEffect]]

---

Practical example


  

If you want specific code to run when a variable changes versus other particular code when another variable changes:

```
const {useState} =require("react");

function MyComponent() {
	const [stateData1, updateStateData1] = useState([]);
	const [stateData2, updateStateData2] = useState([]);
	
	useEffect(() =>{
	}, [stateData1]);
	
	
	useEffect(() =>{
	}, [stateData1]);

	return <OtherComponent/>;
}
```


If you want the same code to run when either variable changes:

```
const {useState} =require("react");

function MyComponent() {
	const [stateData1, updateStateData1] = useState([]);
	const [stateData2, updateStateData2] = useState([]);
	
	useEffect(() =>{
	}, [stateData1, stateData2]);


	return <OtherComponent/>;
}
```


For user changing that value
```
<input
  type="text"
  onChange={(event) => updateStateData1(event.target.value)}
  value={stateData1}
/>
```