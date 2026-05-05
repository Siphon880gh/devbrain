
Props can be defined as type or interface

---

Syntax using types:
```
export default function Child(props: {name: string}) {
    return (
        <div className="bg-gray-100 p-8 rounded-lg -mt-10 text-center">
            <h1 className="text-2xl font-bold mb-4">Child</h1>
            <p>Name: {props.name}</p>
        </div>
    )
}
```


Syntax using destructuring and types:
```
export default function Child({name}: {name: string}) {
    return (
        <div className="bg-gray-100 p-8 rounded-lg -mt-10 text-center">
            <h1 className="text-2xl font-bold mb-4">Child</h1>
            <p>Name: {name}</p>
        </div>
    )
}
```

Syntax using angled brackets and types:
```
const Child: React.FC<{name: string}> = ({ name }) => {
    return (
        <div className="bg-gray-100 p-8 rounded-lg -mt-10 text-center">
            <h1 className="text-2xl font-bold mb-4">Child</h1>
            <p>Name: {name}</p>
        </div>
    );
};

export default Child;

```

---

Syntax using interface:
```
interface ChildProps {
    name: string
}

export default function Child(props: ChildProps) {
    return (
        <div className="bg-gray-100 p-8 rounded-lg -mt-10 text-center">
            <h1 className="text-2xl font-bold mb-4">Child</h1>
            <p>Name: {props.name}</p>
        </div>
    )
}

```

Syntax using destructuring and interface:
```
interface ChildProps {
    name: string
}

export default function Child({name}: ChildProps) {
    return (
        <div className="bg-gray-100 p-8 rounded-lg -mt-10 text-center">
            <h1 className="text-2xl font-bold mb-4">Child</h1>
            <p>Name: {name}</p>
        </div>
    )
}
```


Syntax using angled brackets and interface:
```
interface ChildProps {
    name: string;
}

const Child: React.FC<ChildProps> = ({ name }) => {
    return (
        <div className="bg-gray-100 p-8 rounded-lg -mt-10 text-center">
            <h1 className="text-2xl font-bold mb-4">Child</h1>
            <p>Name: {name}</p>
        </div>
    );
};

export default Child;
```
