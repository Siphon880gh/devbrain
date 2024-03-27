This guide is for react-router-dom versions:
```
"dependencies": {
	"react": "^18.2.0",
	"react-router-dom": "^6.11.2"
```

Vite creates a main.jsx and App.jsx. You will have React router dom code in both files.

For CRA (Create React App), refer to [[React Router Dom v6 on CRA, React <18 or React 18]]

### React Router DOM

React Router DOM is a library for routing in React applications, allowing you to create single-page applications (SPAs) with navigation without the page refreshing as the user navigates. React Router keeps your UI in sync with the URL, making it feel more like a traditional multi-page website.

### Setting Up React Router DOM

In the provided snippets, React Router DOM is utilized to manage routing in a React application. The code demonstrates how to set up routes for different components and how to structure the application to handle navigation.

### Code Explanation

1. **Importing Necessary Modules**

   The first snippet starts by importing essential modules and styles:

   ```javascript
   import ReactDOM from 'react-dom/client';
   import { createBrowserRouter, RouterProvider } from 'react-router-dom';
   import 'bootstrap/dist/css/bootstrap.min.css';
   import App from './App.jsx';
   import SearchVideos from './pages/SearchVideos';
   import SavedVideos from './pages/SavedVideos';
   ```

   Here, `ReactDOM` is for rendering the application, `createBrowserRouter` and `RouterProvider` from `react-router-dom` are specific to routing, and Bootstrap is used for styling. `App`, `SearchVideos`, and `SavedVideos` are the components that will be involved in routing.

2. **Creating the Router**

   A router is created using `createBrowserRouter`, which defines the routes and their corresponding components:

   ```javascript
   const router = createBrowserRouter([
     {
       path: '/',
       element: <App />,
       errorElement: <h1 className="display-2">Wrong page!</h1>,
       children: [
         {
           index: true,
           element: <SearchVideos />
         }, {
           path: '/saved',
           element: <SavedVideos />
         }
       ]
     }
   ]);
   ```

   - The base route (`path: '/'`) renders the `App` component.
   - `errorElement` defines what is displayed when no matching route is found.
   - `children` contains nested routes: the default route (index) renders `SearchVideos`, and `/saved` renders `SavedVideos`.
   - **What Does `index: true` Mean?** When you set `index: true` for a route, you're indicating that this route should be the default child route for the parent. In your configuration, `<SearchVideos>` is the default route to be rendered when the user navigates to the parent path (`'/'`), which is the base path of your application. This component acts as the "index page" or the default "landing page" for the parent route.

3. **Rendering the Router**

   The router is rendered within the root element of the application:

   ```javascript
   ReactDOM.createRoot(document.getElementById('root')).render(
     <RouterProvider router={router} />
   );
   ```

   The `RouterProvider` component is used to pass the routing context down the component tree.

### The `App` Component

The `App` component uses the `Outlet` component from `react-router-dom` to render the current route's element:

```javascript
import './App.css';
import { Outlet } from 'react-router-dom';
import Navbar from './components/Navbar';

function App() {
  return (
    <>
      <Navbar />
      <Outlet />
    </>
  );
}

export default App;
```

- `Navbar` is a component that likely contains navigation links.
- `Outlet` serves as a placeholder for rendering the child routes' components, which, in this case, are `SearchVideos` or `SavedVideos` depending on the URL.

### Conclusion

This setup illustrates a basic yet powerful pattern for setting up routing in a React application using React Router DOM. The primary route renders the `App` component, which in turn renders child components based on the path. This structure facilitates the development of single-page applications with multiple views and a navigation bar.