In `react-router-dom`, the `useParams` hook allows you to access URL parameters directly from within a component. 

Here's a simple example of how you might use `useParams` to get a parameter from the URL:

```jsx
import React from "react";
import { BrowserRouter as Router, Route, Link, useParams } from "react-router-dom";

function ChildComponent() {
  // useParams() will return an object of key/value pairs for all URL parameters
  let { id } = useParams();

  return <h3>ID: {id}</h3>;
}

export default function ParamsExample() {
  return (
    <Router>
      <div>
        <h2>Accounts</h2>

        <ul>
          <li>
            <Link to="/account/1">Account 1</Link>
          </li>
          <li>
            <Link to="/account/2">Account 2</Link>
          </li>
        </ul>

        {/* Use a route with a parameterized URL */}
        <Route path="/account/:id" children={<ChildComponent />} />
      </div>
    </Router>
  );
}
```

In the above example, if you navigate to "/account/1", the `ChildComponent` component will render with `id` being "1". If you navigate to "/account/2", `id` will be "2", and so forth.

The `:id` in the route path `/account/:id` is a URL parameter, and you use `useParams()` to access the value of `id`.