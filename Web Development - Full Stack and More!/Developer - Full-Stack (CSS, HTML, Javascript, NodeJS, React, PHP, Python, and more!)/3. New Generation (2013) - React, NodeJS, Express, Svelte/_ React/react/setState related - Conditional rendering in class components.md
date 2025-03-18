
Conditional rendering in class components
```
class Clock extends React.Component {

    constructor(props) {

    super(props);

    this.state = {date: new Date()};
    }


    render() {

    return (

        <div>

        <h1>Hello, world!</h1>

        <h2>It is {this.state.date.toLocaleTimeString()}.</h2>

        </div>

    );

    }

}
```

Mixing state with conditionals:
```
                    <a href="#slide-a" className={this.state.page==="Tech"?"bg-danger":""}>Tech</a>
```
