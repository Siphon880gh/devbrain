
## Static websites

Static websites are sites that consist of fixed content that doesn't change based on user interactions or database queries. When someone visits a static website, they receive pre-built HTML, CSS, and JavaScript files that are the same for every visitor.

This classification "static websites" can apply to both React frontends (not all React projects) and custom HTML webpages.

- Custom HTML webpages: [[Concept, Categories - Custom HTML Webpage]]
- React Frontends (Depends)
	- React can be static, but isn’t always. It depends on how you deploy it and what the app does.
	- It's a static React frontend if all the React code is prebuilt into HTML/CSS/JS. No server is needed to generate content dynamically and no database is queried during runtime.

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

React apps can be dynamic if:
- React fetches data from a backend or API.
- Content might change depending on the user or time.
- Can include authentication, dashboards, etc.