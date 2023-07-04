<<
In React, the jsx may be: `<Nav currentPage={currentPage} />
How to make it look nicer?

\>>
Here are a few ways to make that JSX look nicer:

1. Extract it into a variable:

```jsx
const nav = <Nav currentPage={currentPage} />;

// then render it:
{nav}
```

2. Destructure currentPage for brevity: 

```jsx
<Nav {...{currentPage}} />
```

3. Use a default prop for currentPage instead of passing it each time:

```jsx
// in Nav component
Nav.defaultProps = {
  currentPage: 'home'
};

// then just:
<Nav />
```

4. Create a `pages` object and pass the key:

```jsx 
const pages = {
  home: 'Home',
  about: 'About'
};

<Nav page={pages.home} />
```

5. For a component that takes many props, spread them from an object:

```jsx
const navProps = {
  currentPage,
  pages,
  onPageChange,
  // etc
};

<Nav {...navProps} />
```

So in summary, extracting to a variable, destructuring props, using default props, passing keys or spreading from an object can help clean up jsx with many props.