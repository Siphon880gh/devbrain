"Scroll Spy" or "Scrollspy" in web development highlights navigation items based on the user's scroll position, showing which section of the content is currently in view.

There’s no single official name universally adopted across all design systems for this UI pattern, but the term most commonly accepted and widely used in both documentation and libraries is ScrollSpy  
  
The term "scrollspy" is widely used in popular frameworks like Bootstrap and is a well-understood term in the web development community. It accurately describes the functionality where the navigation (in this case, the table of contents) "spies" on the scroll position to update the active state of its items.  
  
Example use:
- Highlights current section in TOC as user scrolls  
- Uses Intersection Observer for efficient scroll tracking  
- Adds smooth transitions for active state changes


![[Pasted image 20250526074258.png]]

---

Here’s a complete minimal example of a ScrollSpy webpage with a **sticky Table of Contents (TOC)** that highlights the current heading as you scroll:

### ✅ Features:

- Sticky sidebar with TOC
- Tracks `<h1>`, `<h2>`, and `<h3>` using Intersection Observer
- Highlights the active section
- Smooth scrolling to sections

---

### 📄 HTML + CSS + JS (Vanilla)

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ScrollSpy Demo</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      display: flex;
    }
    nav {
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
      width: 250px;
      padding: 1rem;
      background: #f8f8f8;
      border-right: 1px solid #ddd;
    }
    nav ul {
      list-style: none;
      padding: 0;
    }
    nav a {
      text-decoration: none;
      color: #444;
      display: block;
      padding: 4px 0;
    }
    nav a.active {
      font-weight: bold;
      color: #007acc;
    }
    main {
      padding: 2rem;
      flex: 1;
    }
    section {
      margin-bottom: 100vh;
    }
  </style>
</head>
<body>

  <nav>
    <h3>Table of Contents</h3>
    <ul id="toc">
      <li><a href="#section1">Section 1</a></li>
      <li><a href="#section1-1">Section 1.1</a></li>
      <li><a href="#section2">Section 2</a></li>
      <li><a href="#section2-1">Section 2.1</a></li>
      <li><a href="#section2-2">Section 2.2</a></li>
    </ul>
  </nav>

  <main>
    <section id="section1"><h1>Section 1</h1><p>Content goes here...</p></section>
    <section id="section1-1"><h2>Section 1.1</h2><p>More content...</p></section>
    <section id="section2"><h1>Section 2</h1><p>Content goes here...</p></section>
    <section id="section2-1"><h2>Section 2.1</h2><p>More content...</p></section>
    <section id="section2-2"><h3>Section 2.2</h3><p>Even more content...</p></section>
  </main>

  <script>
    const tocLinks = document.querySelectorAll('#toc a');
    const sections = [...document.querySelectorAll('section')];

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          tocLinks.forEach(link => link.classList.remove('active'));
          const activeLink = document.querySelector(`#toc a[href="#${entry.target.id}"]`);
          if (activeLink) activeLink.classList.add('active');
        }
      });
    }, {
      rootMargin: '0px 0px -80% 0px',
      threshold: 0.1
    });

    sections.forEach(section => observer.observe(section));
  </script>

</body>
</html>
```

---

### 🧪 How to Use:

- Save as `scrollspy.html`
- Open in a browser
- Scroll down and watch the **TOC items highlight** based on the visible section

Scrolling 1 of 2:
![[Pasted image 20250526074402.png]]

Scrolling 2 of 2:
![[Pasted image 20250526074445.png]]