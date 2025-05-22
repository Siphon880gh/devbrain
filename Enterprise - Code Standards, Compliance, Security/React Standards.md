A collection of key guidelines to keep your React codebase **clean**, **scalable**, and **developer-friendly**.

---

### 1. **Component Structure & Co-location**

Each component should live in its own folder and contain:
- JSX/TSX (markup + logic)
- Scoped styles (`.module.css`, Tailwind, or styled-components)
- Optional helpers, tests, and assets
    

📁 **Example Folder**
```
/components
  /EmailReport
    EmailReport.jsx
    EmailReport.module.css
    utils.js
    test.spec.js
```

💡 **Why it matters:** Co-locating files makes components self-contained and easier to maintain and reuse.

---

### 2. **Styling with CSS Modules**

Use `Component.module.css` to scope styles to that specific component and avoid global conflicts.

📄 **EmailReport.module.css**

```css
.container {
  background-color: #f9fafb;
  padding: 1rem;
  border-radius: 0.5rem;
}

.title {
  font-size: 1.25rem;
  color: var(--color-primary);
}
```

📄 **EmailReport.jsx**

```jsx
import styles from './EmailReport.module.css';

export default function EmailReport() {
  return (
    <div className={styles.container}>
      <h2 className={styles.title}>Email Deliverability</h2>
    </div>
  );
}
```

---

### 3. **State Management & Context**

Use `useState` or `useReducer` for local state. For global or shared state, use React’s Context API with a dedicated Provider component.

📄 **/context/AuthProvider.jsx**

```jsx
import { createContext, useState } from 'react';

export const AuthContext = createContext();

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null);

  return (
    <AuthContext.Provider value={{ user, setUser }}>
      {children}
    </AuthContext.Provider>
  );
}
```

📄 **/hooks/useAuth.js**

```js
import { useContext } from 'react';
import { AuthContext } from '../context/AuthProvider';

export function useAuth() {
  return useContext(AuthContext);
}
```

📄 **App.jsx**

```jsx
import { AuthProvider } from './context/AuthProvider';

function App() {
  return (
    <AuthProvider>
      <MainRoutes />
    </AuthProvider>
  );
}
```

---

### 4. **Global Config & Constants**

Centralize app-wide values in `/config`, and environment-specific values in `.env` files.

📄 **/config/routes.js**

```js
export const ROUTES = {
  home: '/',
  dashboard: '/dashboard',
};
```

📄 **.env**

```
REACT_APP_API_BASE_URL=https://api.example.com
```

---

### 5. **Hooks**

Encapsulate reusable behavior in the `/hooks` directory using custom hooks.

📄 **/hooks/useWindowWidth.js**

```js
import { useState, useEffect } from 'react';

export function useWindowWidth() {
  const [width, setWidth] = useState(window.innerWidth);

  useEffect(() => {
    const handleResize = () => setWidth(window.innerWidth);
    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  return width;
}
```

---

### 6. **API & Data Fetching**

Encapsulate all fetch logic in `/services` or `/api`.

📄 **/services/emailService.js**

```js
import axios from 'axios';

export const getEmailReport = () =>
  axios.get(`${process.env.REACT_APP_API_BASE_URL}/email/report`);
```

> Optional: use **React Query** or **SWR** to manage caching, loading states, and retries.

---

### 7. **Routing**

Use **React Router v6+**. Define routes in a central location and use layout components for structure.

📄 **/router/routes.js**

```js
import HomePage from '../pages/HomePage';
import Dashboard from '../pages/Dashboard';

export const routes = [
  { path: '/', element: <HomePage /> },
  { path: '/dashboard', element: <Dashboard /> },
];
```

📄 **/layouts/MainLayout.jsx**

```jsx
export default function MainLayout({ children }) {
  return (
    <div className="layout">
      <Header />
      <main>{children}</main>
    </div>
  );
}
```

---

### 8. **Error Handling**

Use `ErrorBoundary` components to prevent your app from crashing unexpectedly, especially around unstable or async-heavy areas.

📄 **/components/ErrorBoundary.jsx**

```jsx
import { Component } from 'react';

export class ErrorBoundary extends Component {
  state = { hasError: false };

  static getDerivedStateFromError() {
    return { hasError: true };
  }

  render() {
    if (this.state.hasError) {
      return <h2>Something went wrong.</h2>;
    }
    return this.props.children;
  }
}
```

📄 **Usage**

```jsx
<ErrorBoundary>
  <EmailReport />
</ErrorBoundary>
```

### 9. **Design Tokens**

Centralize your design system values like colors, spacing, and typography using **CSS variables**. This keeps your design consistent and easy to update globally.

📄 **/styles/tokens.css**

```css
:root {
  --color-primary: #1d4ed8;
  --color-secondary: #64748b;
  --font-size-base: 16px;
  --spacing-sm: 0.5rem;
  --spacing-md: 1rem;
  --border-radius: 0.5rem;
}
```

🔗 **Usage in CSS Modules**

```css
/* EmailReport.module.css */
.container {
  background-color: var(--color-primary);
  padding: var(--spacing-md);
  border-radius: var(--border-radius);
}
```

> ✅ Pro tip: If using Tailwind CSS, you can also map these tokens in `tailwind.config.js` under `theme.extend`.

---

### 10. **Performance Best Practices**

Keep components snappy and responsive:

- Use `React.memo()` to avoid unnecessary re-renders for pure components
    
- Use `useCallback()` and `useMemo()` to memoize expensive computations and functions
    
- Lazy-load rarely used components with `React.lazy()` + `Suspense`
    
- For large lists, use virtualization libraries like `react-window` or `react-virtualized`
    

📄 **Lazy Load Example**

```jsx
import React, { Suspense, lazy } from 'react';

const LazyComponent = lazy(() => import('./HeavyComponent'));

function Dashboard() {
  return (
    <Suspense fallback={<div>Loading...</div>}>
      <LazyComponent />
    </Suspense>
  );
}
```

---

### 📁 Recommended Folder Structure

Keep your project organized by feature or type, based on your team's scale and preferences.

```
/src
  /components        # UI components
  /hooks             # Custom reusable hooks
  /context           # Global context providers
  /pages             # Route-level components
  /layouts           # Shared layout wrappers
  /services          # API and business logic
  /config            # App-wide constants and settings
  /styles            # Global styles, tokens, and themes
  /assets            # Static files (images, fonts)
  App.jsx
  main.jsx
```
