Here’s how to implement a **navbar that slides away when scrolling down** and **reappears on scroll up**, with shrinking effect included.

---

## ✅ Behavior Summary

- Navbar is fixed at top.
    
- On scroll down: it slides up (hidden).
    
- On scroll up: it slides down (visible).
    
- It also **shrinks** when you've scrolled past a threshold.
    

---

## 🔧 CSS (Shared)

```css
.navbar {
  position: fixed;
  top: 0;
  width: 100%;
  transition: all 0.3s ease;
  padding: 20px 40px;
  background: white;
  z-index: 1000;
  transform: translateY(0);
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.navbar.shrink {
  padding: 10px 30px;
  background: #f9f9f9;
}

.navbar.hide {
  transform: translateY(-100%);
}
```

---

## ✅ 1. **Vanilla JS**

```html
<script>
  let lastScroll = 0;

  window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    const currentScroll = window.pageYOffset;

    // Shrink on scroll past 100px
    if (currentScroll > 100) {
      navbar.classList.add('shrink');
    } else {
      navbar.classList.remove('shrink');
    }

    // Slide up/down based on scroll direction
    if (currentScroll > lastScroll && currentScroll > 100) {
      // scrolling down
      navbar.classList.add('hide');
    } else {
      // scrolling up
      navbar.classList.remove('hide');
    }

    lastScroll = currentScroll;
  });
</script>
```

---

## ✅ 2. **React (Functional Component)**

```jsx
import { useEffect, useState } from 'react';

function Navbar() {
  const [isShrunk, setIsShrunk] = useState(false);
  const [isHidden, setIsHidden] = useState(false);
  const [lastScrollY, setLastScrollY] = useState(0);

  useEffect(() => {
    const handleScroll = () => {
      const currentScroll = window.scrollY;

      // Shrink logic
      setIsShrunk(currentScroll > 100);

      // Hide/show logic
      if (currentScroll > lastScrollY && currentScroll > 100) {
        setIsHidden(true); // scrolling down
      } else {
        setIsHidden(false); // scrolling up
      }

      setLastScrollY(currentScroll);
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, [lastScrollY]);

  return (
    <div className={`navbar ${isShrunk ? 'shrink' : ''} ${isHidden ? 'hide' : ''}`}>
      {/* Navbar content */}
    </div>
  );
}

export default Navbar;
```

---

**Debounce delay** for smoother UX?

Adding a **debounce delay** ensures that the navbar doesn't flicker or react too quickly to minor scroll movements. Here's the updated **React version with debounce and direction-aware visibility**:


## ✅ Updated JavaScript with Debounce

```
<script>
  let lastScroll = window.pageYOffset;
  let debounceTimeout = null;

  window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    const currentScroll = window.pageYOffset;

    // Shrink class toggle
    if (currentScroll > 100) {
      navbar.classList.add('shrink');
    } else {
      navbar.classList.remove('shrink');
    }

    // Debounced visibility logic
    if (debounceTimeout) {
      clearTimeout(debounceTimeout);
    }

    debounceTimeout = setTimeout(() => {
      if (currentScroll > lastScroll && currentScroll > 100) {
        // Scrolling down
        navbar.classList.add('hide');
      } else {
        // Scrolling up
        navbar.classList.remove('hide');
      }

      lastScroll = currentScroll;
    }, 100); // 100ms debounce
  });
</script>

```


## ✅ Updated React Navbar with Debounce

```jsx
import { useEffect, useState } from 'react';

function Navbar() {
  const [isShrunk, setIsShrunk] = useState(false);
  const [isHidden, setIsHidden] = useState(false);
  const [lastScrollY, setLastScrollY] = useState(0);
  const [scrollTimeout, setScrollTimeout] = useState(null);

  useEffect(() => {
    const handleScroll = () => {
      const currentScroll = window.scrollY;

      // Shrink when past threshold
      setIsShrunk(currentScroll > 100);

      // Debounce: only run visibility toggle after delay
      if (scrollTimeout) {
        clearTimeout(scrollTimeout);
      }

      const timeout = setTimeout(() => {
        // Direction-based hide/show
        if (currentScroll > lastScrollY && currentScroll > 100) {
          setIsHidden(true); // scrolling down
        } else {
          setIsHidden(false); // scrolling up
        }
        setLastScrollY(currentScroll);
      }, 100); // 100ms debounce delay

      setScrollTimeout(timeout);
    };

    window.addEventListener('scroll', handleScroll);
    return () => {
      window.removeEventListener('scroll', handleScroll);
      if (scrollTimeout) clearTimeout(scrollTimeout);
    };
  }, [lastScrollY, scrollTimeout]);

  return (
    <div className={`navbar ${isShrunk ? 'shrink' : ''} ${isHidden ? 'hide' : ''}`}>
      {/* Navbar content */}
    </div>
  );
}

export default Navbar;
```

---

## 🧠 How it works:

- `scrollY` is sampled continuously, but the **hide/show logic** only triggers **after a 100ms delay**
    
- This prevents it from reacting to jittery or micro scrolls.
    
- You can **tweak the delay** (e.g., `100`, `200`) based on how aggressive you want the navbar response to be.
    
## 🧠 Tip:

You can increase the debounce (e.g. `200ms`) if you want it to feel smoother or delay longer before showing/hiding the navbar.

You can also add **fade effects**, **slide-in from side**, or **mobile toggle behavior**..