In NextJS, how you access the search parameters (eg. `localhost:3000/signup/success?token=...&callback=...`) differs between a client component and a server component.

Client component:
```
import { useSearchParams } from "next/navigation";  
  
export default async function ResetPassword() {  
  let searchParams = {...Object.fromEntries(useSearchParams())};
```

Server component:
```
export default async function Signup(props: {  
  searchParams: Promise<any>;  
}) {  
  const searchParams = await props.searchParams;
```