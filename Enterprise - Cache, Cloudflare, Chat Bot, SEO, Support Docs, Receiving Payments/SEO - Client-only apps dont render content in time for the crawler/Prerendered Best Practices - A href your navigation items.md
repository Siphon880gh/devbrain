To ensure search engines can crawl and index your pages correctly when prerendering, **always use proper anchor tags (`<a href="..."`) or framework-native `<Link>` components** for navigation.

Avoid relying solely on `onClick` handlers to trigger route changes — especially for elements like buttons or cards — as these **won’t be followed by crawlers** or picked up by prerendering tools.

#### ✅ Do:

```jsx
<a href={`/entity/${slug}`}>View Entity</a>
```

Or with React Router:

```jsx
<Link to={`/entity/${slug}`}>View Entity</Link>
```

#### ❌ Avoid:

```jsx
<button onClick={() => navigate(`/entity/${slug}`)}>View Entity</button>
```

Or clickable cards:

```jsx
<div onClick={() => navigate(`/entity/${slug}`)}>Card</div>
```

---

### **Why This Matters**

SEO crawlers and prerendering tools rely on real, crawlable links. When navigation is handled only via JavaScript (`onClick` or `navigate()`), the linked page may not be discovered or prerendered at all — especially in SPAs that rely heavily on client-side rendering.

---

### **Handling Modal State via URL (Client-Side Routing)**

In some apps, clicking an entity opens a modal (not a full page load), and the modal is determined based on the URL slug. To support this:

#### Example:

```jsx
const { entitySlug } = useParams();

useEffect(() => {
  if (!loading && entitySlug) {
    const entity = entities.find(e => evalIntoSlug(e) === entitySlug);
    if (entity) {
      setSelectedEntity(entity); // This sets the modal content
    } else {
      setSelectedEntity(null);
      navigate('/'); // Fallback if slug doesn't match
    }
  } else {
    setSelectedEntity(null);
  }
}, [entitySlug, loading, navigate, entities]);

// Later in the component render:
{selectedEntity && (
  // 👇 This modal appears when an entity is selected
  <EntityModal eid={selectedEntity._id} />
)}
```

This approach lets you deep-link to modals using URL slugs, which is useful for sharing links and supporting reloads — **but only if those links are discoverable through real `<a href>` tags.**
