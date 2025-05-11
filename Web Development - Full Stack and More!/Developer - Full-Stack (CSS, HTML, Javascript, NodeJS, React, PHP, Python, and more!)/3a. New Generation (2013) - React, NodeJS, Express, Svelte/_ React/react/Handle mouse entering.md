
Functional Component
```
function MyComponent() {

  function handleMouseEnter() {
    // Handle mouse enter
  }

  return (
    <div onMouseEnter={handleMouseEnter}>
      {/* Component JSX */}
    </div>
  );
}
```


Class Component
```
class MyComponent extends React.Component {
  handleMouseEnter = () => {
    // Handle mouse enter
  }

  render() {
    return (
      <div onMouseEnter={this.handleMouseEnter}>
        {/* Component JSX */}  
      </div>
    );
  }
}

```