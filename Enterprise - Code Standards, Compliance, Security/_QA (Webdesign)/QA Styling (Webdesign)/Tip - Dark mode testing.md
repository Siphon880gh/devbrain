QA Item: Dark mode — verify text and elements are readable when the site is viewed in dark mode (Set dark mode at OS or browser level)

---

You can use this Chrome extension to toggle Light and Dark mode to test your design:

Dark Mode by Grephy
https://chromewebstore.google.com/detail/dark-mode/dmghijelimhndkbmpgbldicpogfkceaj?hl=en

Make sure to pin the Chrome Extension to make access to it easy.

Click chrome extension to toggle Dark/Light
![[Pasted image 20260309213724.png]]

Make sure to test your design in a clear session with no chrome extensions (Incognito without any chrome extension) while in Dark Mode. That would follow a more complete QA test per  [[_QA Styling Standards (Web design)]]. However, if you want to use the chrome extension to toggle dark light mode, you may want to configure that particular chrome extension to work in Incognito.

---

If you prefer NOT to install an additional chrome extension:
CMD+Space:
![[Pasted image 20260309213948.png]]

---

Your design fails at Dark Mode? 

You can use AI to do a quick fix. Here's a **prompt**:
```
Let's adjust the code. Make sure in dark mode that the text and other elements are readable. No black on black, dark gray ono black, etc.
```

If you prefer to manually code it:
- Implement dark vs light themes: [[1. CSS Fundamentals for Making Light Mode and Dark Mode Look Good]]
- Forcing only one theme: [[3. How to Simplify Dark Light Theme Management by Allowing Only One Mode]]