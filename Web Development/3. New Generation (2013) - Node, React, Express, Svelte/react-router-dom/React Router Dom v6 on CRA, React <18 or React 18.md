This guide is for react-router-dom versions:
```
"dependencies": {
	"react-router-dom": "^6.11.2"
```

CRA creates an App.jsx, but no main.jsx. 

If creating React 18, it'll in addition create index.jsx. For React 17 or below, it'll only be App.jsx. Your react-router-dom code differs depending on the React version.

For Vite, refer to [[React Router Dom v6 on Vite, React 18]]

---
#### For React 18:

If you are using React 18, your `index.js` would look similar to the Vite setup:

```javascript
import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import { createBrowserRouter, RouterProvider } from 'react-router-dom';

import SearchVideos from './pages/SearchVideos';
import SavedVideos from './pages/SavedVideos';

const router = createBrowserRouter([
  {
    path: '/',
    element: <App />,
    children: [
      {
        index: true,
        element: <SearchVideos />,
      },
      {
        path: 'saved',
        element: <SavedVideos />,
      },
    ],
  },
]);

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <RouterProvider router={router} />
  </React.StrictMode>
);
```

#### For React 17 or Below:

If you're not using React 18 or the new root API, the setup will slightly differ:

```javascript
import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import { BrowserRouter as Router } from 'react-router-dom';

ReactDOM.render(
  <React.StrictMode>
    <Router>
      <App />
    </Router>
  </React.StrictMode>,
  document.getElementById('root')
);
```

And then, inside your `App.js`, you would set up your routes like so:

```javascript
import React from 'react';
import { Routes, Route } from 'react-router-dom';
import SearchVideos from './pages/SearchVideos';
import SavedVideos from './pages/SavedVideos';
import Navbar from './components/Navbar';

function App() {
  return (
    <>
      <Navbar />
      <Routes>
        <Route index element={<SearchVideos />} />
        <Route path="saved" element={<SavedVideos />} />
      </Routes>
    </>
  );
}

export default App;
```

This structure introduces a slight difference: `Routes` and `Route` components are used directly within `App.js` to define the routing logic, which is a common pattern in React Router v6 and Create React App setups. 

In both cases, whether for React 17 or 18, the core idea remains the same: define your routes and corresponding components, and ensure that the router is properly integrated at the root of your application.