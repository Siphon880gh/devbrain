useEffect(cb) runs the callback as an effect of render or re-render


useEffect(cb, [...]) runs the callback as an effect of any variable changes in the array. React is monitoring the variables in the array.

  
useEffect(cb, []) runs the callback once because while technically as an effect, it should rerun whenever a variable inside the array changes, that is an empty array, and it must run once if the array is empty.

----

Other more advanced uses of useEffect

[[Await async in useEffect by using IIFE]]

[[Performance - Cleanup when unmounting using useEffect]]