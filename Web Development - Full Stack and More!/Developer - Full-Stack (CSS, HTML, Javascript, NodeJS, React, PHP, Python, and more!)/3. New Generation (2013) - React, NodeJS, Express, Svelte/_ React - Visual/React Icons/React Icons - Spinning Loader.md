
Install react-icons:
```
npm install react-icons
```

Make sure tailwind is properly installed (instructions differ depending on vite/cra/nextjs/etc)

---

Code:
```
import { FaSpinner } from "react-icons/fa";

export default function Spinner() {
  return (
    <div className="flex justify-center items-center h-screen">
      <FaSpinner className="animate-spin text-4xl text-blue-500" />
    </div>
  );
}
```

Screenshot:
![[Pasted image 20250316014857.png]]