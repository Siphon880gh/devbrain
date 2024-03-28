
Text: Setter method - Set state of object with partially new fields

Pass the entire object to the useState setter method with spread operator before the new field (key and value)


```

const StateObject = () => {

const [state, setState] = useState({ age: 19, siblingsNum: 4 })

const handleClick = val =>

setState({

...state,

[val]: state[val] + 1

})

const { age, siblingsNum } = state

  

return (

<div>

<p>Today I am {age} Years of Age</p>

<p>I have {siblingsNum} siblings</p>

  

<div>

<button onClick={handleClick.bind(null, 'age')}>Get older!</button>

<button onClick={handleClick.bind(null, 'siblingsNum')}>

More siblings!

</button>

</div>

</div>

)

}

```

  
