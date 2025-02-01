
## Component Structure

[Section titled Component Structure](https://docs.astro.build/en/core-concepts/astro-components/#component-structure)

An Astro component is made up of two main parts: the **Component Script** and the **Component Template**. Each part performs a different job, but together they provide a framework that is both easy to use and expressive enough to handle whatever you might want to build.

src/components/EmptyComponent.astro

```
---
// Component Script (JavaScript)
---
<!-- Component Template (HTML + JS Expressions) -->
```

Example:
```
---
import GreetingHeadline from './GreetingHeadline.astro';
const name = "Astro"
---
<h1>Greeting Card</h1>
<GreetingHeadline greeting="Hi" name={name} />
<p>I hope you have a wonderful day!</p>
```

---

Default values:
```
---
const { greeting = "Hello", name = "Astronaut" } = Astro.props;
---
<h2>{greeting}, {name}!</h2>
```

---

## Test out here:
[https://stackblitz.com/edit/github-ona6k9?file=README.md](https://stackblitz.com/edit/github-ona6k9?file=README.md)