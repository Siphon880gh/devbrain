
```
Type error: Binding element 'name' implicitly has an 'any' type.  
> 1 | export default function Child({name}) {
```

_The cause is incorrect typescript syntax. You haven’t added typescript to validate the parameter, thus implicitly it assumes you meant `any` which is not acceptable (if you want `any` , you have to explicitly add it)._

---

```
Type error: Binding element 'string' implicitly has an 'any' type.  
> 1 | export default function Child({name:string}) {
```

_The cause is incorrect typescript syntax. You’re actually renaming the parameter from `name`  to `string`  and haven’t added typescript to validate the parameter, thus implicitly it assumes you meant `any` which is not acceptable (if you want `any` , you have to explicitly add it)._

---

```
Type error: Property 'name' does not exist on type '{}'.  
const Child: React.FC = ({ name}) => {
```

_The cause is you haven’t added typescript to validate the name parameter_

---

```
Type error: Type '{ a: number; b: number; c: number; d: number; }' is not assignable to type 'IntrinsicAttributes & { a: number; b: number; c: number; }'.

Property 'd' does not exist on type 'IntrinsicAttributes & { a: number; b: number; c: number; }'.
```

_The cause is page.tsx passing a prop `d`  that hasn’t been defined as a parameter at child component child.tsx:_

page.tsx:
```
import Child from "./child";  
  
export default function Home() {  
  return (  
    <main >  
      <Child   
        a={100}  
        b={100}  
        c={100}  
        d={100}  
      />  
    </main>  
  );  
}
```

child.tsx:
```
"use client"  
export default function CardWrapper({  
    a,  
    b,  
    c  
  }: {  
    a: number;  
    b: number;  
    c: number  
  }) {  
    return (  
        <div>  
            <u>Passed Props:</u>  
            <p>a: {a}</p>  
            <p>b: {b}</p>  
            <p>c: {c}</p>  
        </div>  
    );  
  }
```