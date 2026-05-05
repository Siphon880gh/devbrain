View their icons at
[https://heroicons.com/](https://heroicons.com/)

Example (Magnifying glass):
![[Pasted image 20250316004719.png]]

Install:
```
npm install @heroicons/react@2.2.0
```

Page.tsx:
```
'use client';  
  
import { MagnifyingGlassIcon } from '@heroicons/react/24/outline';  
  
export default function Search({ placeholder }: { placeholder: string }) {  
  return (  
    <div className="flex flex-col justify-center items-center w-64 mx-auto mt-32">  
      <h1 className="text-2xl font-bold mb-4 w-fit">Search Content:</h1>  
      <div className="relative flex flex-1 flex-shrink-0">  
        <label htmlFor="search" className="sr-only">  
          Search  
        </label>  
        <input  
          className="peer block w-full rounded-md border border-gray-200 py-[9px] pl-10 text-sm outline-2 placeholder:text-gray-500"  
          placeholder={placeholder}  
        />  
        <MagnifyingGlassIcon className="absolute left-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-gray-500 peer-focus:text-gray-900" />  
      </div>  
    </div>  
  );  
}
```