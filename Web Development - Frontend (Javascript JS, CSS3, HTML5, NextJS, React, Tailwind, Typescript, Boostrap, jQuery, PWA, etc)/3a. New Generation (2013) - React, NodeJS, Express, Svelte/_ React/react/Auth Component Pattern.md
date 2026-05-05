Status: Untested
Below is some variation of: https://ui.dev/react-router-protected-routes-authentication


src/App.js:
```

import  RequireAuth  from './Components/Auth/RequireAuth.js';

//...


        <Route element={<RequireAuth allowedRoles={[ROLES.User]} />}>
          <Route path="/home" element={<Home />} />
        </Route>

        <Route element={<RequireAuth allowedRoles={[ROLES.User]} />}>
          <Route path="/profile" element={<Profile />} />
        </Route>


```

src/Components/Auth/RequireAuth.js:
```
import { useLocation, Navigate, Outlet } from "react-router-dom";
import useAuth from "../../hooks/useAuth.js";

const RequireAuth = ({ allowedRoles }) => {
    const { auth } = useAuth();
    const location = useLocation();

    return (
        auth?.roles?.find(role => allowedRoles?.includes(role))
            ? <Outlet />
            : auth?.user
                ? <Navigate to="/unauthorized" state={{ from: location }} replace />
                : <Navigate to="/login" state={{ from: location }} replace />
    );
}

export default RequireAuth;
```


src/hooks/useAuth.js:
```
import { useContext, useDebugValue } from "react";
import AuthContext from "../context/AuthProvider.js";

const useAuth = () => {
    const { auth } = useContext(AuthContext);
    useDebugValue(auth, auth => auth?.user ? "Logged In" : "Logged Out")
    return useContext(AuthContext);
}

export default useAuth;
```

src/context/useAuth.js:

```
import { useContext, useDebugValue } from "react";
import AuthContext from "../context/AuthProvider.js";

const useAuth = () => {
    const { auth } = useContext(AuthContext);
    useDebugValue(auth, auth => auth?.user ? "Logged In" : "Logged Out")
    return useContext(AuthContext);
}

export default useAuth;
```