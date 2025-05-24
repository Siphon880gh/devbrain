MDX Support is optional. You can stick to normal MD files if you want.

---

**MDX is primarily used for the docs**, not the core website components.

**Breakdown:**
- **Docs pages:**  
    Docusaurus supports writing documentation in **MDX**, which means you can write normal Markdown but also embed **React components** directly within your docs. This is useful for adding interactive elements, custom UI, or dynamic content in your documentation.
    
    ✅ Example use cases:
    - Embedding a `<Tabs>` component in a tutorial
    - Inserting an alert box with a custom `<Note>` component
    - Adding charts or code sandboxes
    
- **Website components (layout, theme, navbar, etc.):**  
    These are built in **JSX/TSX** using standard React code, not MDX. You manage them through the `src` directory (`src/pages`, `src/components`, etc.).
