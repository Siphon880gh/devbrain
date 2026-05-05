
```
class ShoppingList extends React.Component {
  render() {
    return (
      <div className="shopping-list">
        <h1>Shopping List for {this.props.name}</h1>
        <ul>
          <li>Bread</li>
          <li>Jelly</li>
          <li>Peanut Butter</li>
        </ul>
      </div>
    );
  }
}
```


The component must be titlecased, with the first character capital:
Proof
Say we have a component in the same file
```
class HovReact extends Component {
	
	constructor(props) {

		super(props)
		}
		
		render() {
			return (
				<>
					HovReact rendered
				</>
			)
		}
}
```

And we nest that inside another component. It'd render at browser view source:
![](XyDc77I.png)

Otherwise, it's just another tag and doesn't render your contents in render() or return at browser view source:
![](JJXC3pi.png)
