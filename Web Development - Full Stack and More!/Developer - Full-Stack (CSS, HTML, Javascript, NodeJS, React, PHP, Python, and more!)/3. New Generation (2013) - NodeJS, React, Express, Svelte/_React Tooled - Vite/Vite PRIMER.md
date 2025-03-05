
Aka: Get Started
https://vite.dev/guide/

npm scripts:
- `vite` is a command that starts a dev server in the current directory
- `vite build` to build for production preview
- `vite preview` is a _command_ that locally previews the production build

Either run `vite`, OR run `vite build` followed by `vite preview`
![[Pasted image 20250305051149.png]]

Test that the interactivity works. Click count status button to see it increment:
![[Pasted image 20250305051157.png]]

Src folder is:
```
src
├── App.css
├── App.jsx
├── assets
│   └── react.svg
├── index.css
└── main.jsx
```

---

Looking at App.jsx:

Various logo assets imported:
```
import reactLogo from './assets/react.svg'  
import viteLogo from '/vite.svg'
```

CSS imported at
```
import './App.css'
```


Count button works via initial value of 0 at the variable `count`.
```
const [count, setCount] = useState(0)
```

onClick handling is incrementing `count`:
```
<button onClick={() => setCount((count) => count + 1)}>
```

And because the `{count}` is a **reactive, interpolated JSX expression** derived from React useState, it ensures that whenever `count` changes, the UI updates accordingly at:
```
count is {count}
```

So user sees this:
![[Pasted image 20250305052201.png]]

And after the user clicks the text, it becomes:
![[Pasted image 20250305052210.png]]