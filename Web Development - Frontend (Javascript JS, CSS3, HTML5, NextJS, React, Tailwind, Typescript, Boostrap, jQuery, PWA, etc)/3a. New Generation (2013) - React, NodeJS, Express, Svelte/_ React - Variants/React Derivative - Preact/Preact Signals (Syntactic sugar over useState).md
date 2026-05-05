Easier to use than useState.
https://youtu.be/SO8lBVWF2Y8?t=375


Why easier?
No need to wrap the "hook" inside a component. It'll just render and rerender as the value changes (as long as you use .value)

```
import {signal} from "@preact/signals-react"

const randNum = signal("Kyle")

setInterval(()=>{

	randNum.value = Math.random()
})
export function TestComponent() {
	return (
		<>
			<h1>Random Number</h1>
			<p>{randNum.value}
		</>
	
	)
}
```

---

Prereact with signals which is more intuitive than clunky useState variable and setter. It has effect() which serves like a compute from knockout js, not having to pass variables to be monitored in second argument in that Prereact knows if you use the variable inside the first argument function.