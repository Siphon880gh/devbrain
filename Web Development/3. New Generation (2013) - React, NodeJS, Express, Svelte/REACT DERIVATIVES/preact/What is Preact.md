
preact

Same API as React
Fast 3kB alternative to React with the same modern API
No build tools necessary. Just script src directly

--

No build tools route
Preact is packaged to be used directly in the browser, and doesn't require any build or tools:

```
<script type="module">
  import { h, Component, render } from 'https://esm.sh/preact';

  // Create your app
  const app = h('h1', null, 'Hello World!');

  render(app, document.body);
</script>

```