
You have a wildcarded URL. When the URL changes but still matches the previous URL pattern because of the wildcarding, the React does not re-render

If you want it to re-render in that case, add a dependency to useLocation.

```
import {useLocation} from "react-router-dom";
let location = useLocation();
```

Now the location can be in a dependency array either in useEffect:
```
useEffect(()=>{
//...
}, location)
```

Or React Query's useQuery when you want to both refetch and rerender the fetched response:
```
const { data:workoutRx, status, error } = useQuery(["workoutQuery", location], fetchWorkout);
```
