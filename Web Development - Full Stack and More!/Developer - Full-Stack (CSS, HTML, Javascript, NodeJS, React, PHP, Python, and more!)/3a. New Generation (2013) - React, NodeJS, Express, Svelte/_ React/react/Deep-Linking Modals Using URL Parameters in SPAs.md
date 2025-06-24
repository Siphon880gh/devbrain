Requirements: Everything in that article assumes you're using React Router DOM.

---

In modern SPAs, it's common to show content in a modal instead of navigating to a new page. But what happens when you want users to share that modal or reload the page and keep it open?

The answer: **link to a unique URL for each modal** and use URL parameters (`useParams`) to control the modal's state.

---

### 🧩 **Use Case**

You have a list of cards (e.g. people, places, products) rendered from an `entities` array. When a user clicks one, a modal opens with more information. You want:

- Users to be able to **share a link** to a specific modal
    
- A **page reload** to reopen the same modal
    
- Crawlers/prerenderers to **discover and index the modal route**
    

---

### ✅ **Solution: Use `<Link>` and URL-Based Routing**

Instead of using `onClick` to open the modal, use a proper route with a unique slug.

#### Example: Map Over Entities to Render Cards

```jsx
{entities.map((entity) => (
  <Link key={entity._id} to={`/entity/${evalIntoSlug(entity)}`}>
    <EntityCard entity={entity} />
  </Link>
))}
```

This ensures:

- SEO crawlers and prerenderers can discover the modal page
    
- The browser URL reflects which entity is selected
    
- Users can copy/share links to a specific modal
    

---

### 🧠 **Handle Modal State Based on the URL**

```jsx
const { entitySlug } = useParams();

useEffect(() => {
  if (!loading && entitySlug) {
    const entity = entities.find(e => evalIntoSlug(e) === entitySlug);
    if (entity) {
      setSelectedEntity(entity); // Open the modal
    } else {
      setSelectedEntity(null);
      navigate('/'); // Redirect if slug doesn't match any entity
    }
  } else {
    setSelectedEntity(null); // Modal closed when no slug present
  }
}, [entitySlug, loading, navigate, entities]);
```

---

### 💡 **Render the Modal If an Entity Is Selected**

```jsx
{selectedEntity && (
  // 👇 This modal appears when a valid entitySlug is in the URL
  <EntityModal eid={selectedEntity._id} />
)}
```

---

### 🧭 **Bonus: Close Modal by Navigating Back**

You can programmatically close the modal by navigating back or routing to the base path:

```jsx
const handleClose = () => navigate('/');
```

---

### 🧼 **Why This Pattern Works**

|Feature|Benefit|
|---|---|
|Real `<a href>` or `<Link>`|Crawlable, SEO-friendly|
|Unique URL per modal|Deep linking and sharability|
|URL-driven modal logic|Works on reloads and direct links|
|Declarative + predictable|Easy to debug and extend|
