
## Static websites

Static websites are sites that consist of fixed content that doesn't change based on user interactions or database queries. When someone visits a static website, they receive pre-built HTML, CSS, and JavaScript files that are the same for every visitor.

You will often find `<script>` and `<link>` tags for js and css.

Key characteristics of static websites include:

- Files are pre-rendered and served as-is from the server
- No server-side processing is needed when a user requests a page
- Content doesn't change unless the developer manually updates and redeploys the files
- They're typically faster and more secure than dynamic websites

## Dynamic websites

Dynamic websites are sites whose content or appearance changes in response to various factors, which can happen in multiple ways:

1. Client-side rendering (CSR): JavaScript running in the browser manipulates the DOM after the initial page load, often in response to user interactions (clicks, form submissions, etc.) or data fetches (API calls returning new information) or state variables changes (internal application state updates).
2. Server-side rendering (SSR): The server generates HTML on-demand for each request, potentially showing different content to different users based on their context, database queries, or other variables.
3. A combination of both approaches: Initial content may be server-rendered, with subsequent interactions handled on the client.


