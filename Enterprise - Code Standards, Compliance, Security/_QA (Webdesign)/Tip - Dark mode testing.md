QA Item: Dark mode — verify text and elements are readable when the site is viewed in dark mode (Set dark mode at OS or browser level)

---

You can use this Chrome extension to toggle Light and Dark mode to test your design:

Dark Mode by Grephy
https://chromewebstore.google.com/detail/dark-mode/dmghijelimhndkbmpgbldicpogfkceaj?hl=en

Make sure to pin the Chrome Extension to make access to it easy.

Click chrome extension to toggle Dark/Light
![[Pasted image 20260309213724.png]]

Make sure to test your design in a clear session (Incognito without any chrome extension) while in Dark Mode. That will be a more complete QA test PER [[_QA Standards - Web design]].

---

If you prefer NOT to install an additional chrome extension:
CMD+Space:
![[Pasted image 20260309213948.png]]

---

Your design fails at Dark Mode? You can use AI to do a quick fix. Here's a **prompt**:
```
Let's adjust the code. Make sure in dark mode that the text and other elements are readable. No black on black, dark gray ono black, etc.
```