## 1. Introduction

React provides built-in state management tools like `useContext` and `useReducer`, which can be combined to create a scalable global state management solution without external libraries like Redux.

### **When to Use useContext & useReducer?**

- **useContext**: Helps avoid prop drilling by providing a way to pass data down the component tree.
- **useReducer**: Manages complex state logic using a reducer function, similar to Redux but built-in.
- **Combined**: Ideal for managing global state in small to medium-sized applications.

---

## 2. Setting Up useContext & useReducer

### **Step 1: Define State & Reducer (`CounterContext.js`)**

Create a `context` and `reducer` function for state management.

```jsx
// CounterContext.js
import { createContext, useReducer } from "react";

// Initial state
const initialState = { count: 0 };

// Reducer function
type ActionType = { type: "INCREMENT" } | { type: "DECREMENT" };
const reducer = (state, action) => {
  switch (action.type) {
    case "INCREMENT":
      return { count: state.count + 1 };
    case "DECREMENT":
      return { count: state.count - 1 };
    default:
      return state;
  }
};

// Create context
export const CounterContext = createContext();
```

### **Step 2: Create a Context Provider (`CounterProvider.js`)**

Wrap your application in a `Provider` to supply state and dispatch to components.

```jsx
// CounterProvider.js
import React, { useReducer } from "react";
import { CounterContext } from "./CounterContext";

export const CounterProvider = ({ children }) => {
  const [state, dispatch] = useReducer(reducer, initialState);

  return (
    <CounterContext.Provider value={{ state, dispatch }}>
      {children}
    </CounterContext.Provider>
  );
};
```

### **Step 3: Wrap App with Provider (`index.js`)**

Ensure your entire app or specific parts of it have access to the state.

```jsx
// index.js
import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import { CounterProvider } from "./CounterProvider";

ReactDOM.render(
  <CounterProvider>
    <App />
  </CounterProvider>,
  document.getElementById("root")
);
```

---

## 3. Using useContext & useReducer in Components

### **Step 4: Access State & Dispatch (`Counter.js`)**

Use `useContext` to consume the context inside components.

```jsx
// Counter.js
import React, { useContext } from "react";
import { CounterContext } from "./CounterContext";

const Counter = () => {
  const { state, dispatch } = useContext(CounterContext);

  return (
    <div>
      <h1>Count: {state.count}</h1>
      <button onClick={() => dispatch({ type: "INCREMENT" })}>+</button>
      <button onClick={() => dispatch({ type: "DECREMENT" })}>-</button>
    </div>
  );
};

export default Counter;
```

---

## 4. Best Practices

✅ **Encapsulate logic**: Keep reducers separate from components for maintainability.  
✅ **Use TypeScript**: Enforce strict action types for safety.  
✅ **Optimize with useMemo**: If passing complex data, memoize values inside `Provider`.  
✅ **Consider local vs. global state**: Only use `useContext` for truly global state.

---

## 5. Conclusion

By combining `useContext` and `useReducer`, you get a simple yet powerful way to manage state in React applications without external dependencies like Redux. It's a great fit for apps that need a lightweight global state solution while keeping logic structured and maintainable.

Happy coding! 🚀