
Available in # TypeScript 4.9 released in 11/15/22

Syntax:
```
interface Color {
	r: number,
	g: number,
	b: number
}

export default function Home() {
  const blue = {
    r: 0,
    g: 0,
    b: 255
} satisfies Color
```

^ Also works:
```
interface Color {
	r: number;
	g: number;
	b: number;
}

// ...
```

---

A more involved example:
```
type Color =
	| string
	| { r: number, g: number, b:number }

const blue = {
	r: 0,
	g: 0,
	b: 255
} satisfies Color

const blue2 = "blue" satisfies Color
```

^ Also works:
```
type Color =
	| string
	| { r: number; g: number; b:number }
	
// ...
```