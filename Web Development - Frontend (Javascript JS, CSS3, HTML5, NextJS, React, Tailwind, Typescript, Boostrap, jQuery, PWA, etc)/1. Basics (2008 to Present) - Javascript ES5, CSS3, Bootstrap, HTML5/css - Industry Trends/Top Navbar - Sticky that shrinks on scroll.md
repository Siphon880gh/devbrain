To implement a **sticky top navbar that shrinks in height on scroll**, here’s a guide for **vanilla JS**, **jQuery**, and **React**:

---

## ✅ Behavior:

* Navbar is `position: sticky` or `fixed` at the top.
* When user scrolls past a threshold (e.g., 100px), it shrinks in height and optionally changes style (e.g., background, padding).

---

## 🔧 CSS (shared base)

```css
.navbar {
  position: sticky; /* or fixed if you want it to always stick */
  top: 0;
  width: 100%;
  transition: all 0.3s ease;
  padding: 20px 40px;
  background: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  z-index: 1000;
}

.navbar.shrink {
  padding: 10px 30px;
  background: #f9f9f9;
}
```

---

## ✅ 1. **Vanilla JS**

```html
<script>
  window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
      navbar.classList.add('shrink');
    } else {
      navbar.classList.remove('shrink');
    }
  });
</script>
```

---

## ✅ 2. **jQuery**

```html
<script>
  $(window).on('scroll', function () {
    if ($(window).scrollTop() > 100) {
      $('.navbar').addClass('shrink');
    } else {
      $('.navbar').removeClass('shrink');
    }
  });
</script>
```

---

## ✅ 3. **React (Functional Component)**

```jsx
import { useEffect, useState } from 'react';

function Navbar() {
  const [isShrunk, setIsShrunk] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsShrunk(window.scrollY > 100);
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <div className={`navbar ${isShrunk ? 'shrink' : ''}`}>
      {/* Navbar content here */}
    </div>
  );
}
```

---

Let me know if you’d like a version with **Tailwind CSS**, animated logo resizing, or if the navbar should *slide away* then *reappear* on scroll-up.
