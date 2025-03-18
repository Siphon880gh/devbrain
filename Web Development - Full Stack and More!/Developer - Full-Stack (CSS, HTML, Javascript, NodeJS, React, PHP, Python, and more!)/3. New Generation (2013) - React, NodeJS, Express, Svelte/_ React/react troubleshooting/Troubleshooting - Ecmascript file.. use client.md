Error:
```
Ecmascript file had an error  
> 1 | import React, { useState } from 'react';  
    |                 ^^^^^^^^  
  2 | import { ChevronDown } from 'lucide-react';  
  3 | import { cn } from '@/lib/utils';  
  4 |  
  
You're importing a component that needs `useState`. This React hook only works in a client component. To fix, mark the file (or its parent) with the `"use client"` directive.
```

![[Pasted image 20250318051231.png]]

It could have complained for useEffect, etc, or any other React features that are only for client components (aka frontend components, so NOT server components).

**Solution:**
Add `"use client"` to the top of the file.

