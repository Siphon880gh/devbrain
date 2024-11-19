
In a Create React App (CRA) project automatically brings in .env variables without the need to manually import dotenv. However, only variables prefixed with REACT_APP_ are included in the React app's build process. This would apply to both developmental hot reload preview port as well as the build/ production ready version. 

Example:
```
import React from 'react';  
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';  
  
function App() {  
  const basepath = process.env.REACT_APP_EXPRESS_ROUTER_BASEPATH || '/';  
  
  return (  
    <Router basename={basepath}>  
      <Switch>  
        <Route exact path="/" component={HomePage} />  
        <Route path="/about" component={AboutPage} />  
        {/* Other routes */}  
      </Switch>  
    </Router>  
  );  
}  
  
export default App;
```

.env:
```
REACT_APP_EXPRESS_ROUTER_BASEPATH=/app/book-search
```