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