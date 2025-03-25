
Problem: Chrome shows old or empty json but Incognito shows fresh json

Reworded: This strangely shows table rows in Incognito but fails in regular chrome showing empty array. It's NOT protected page. Anon key used is allowed to select all

Chrome (NOT Incognito) visiting `http://localhost:3000/users`
![[Pasted image 20250315014204.png]]

Incognito visiting `http://localhost:3000/users
![[Pasted image 20250315004447.png]]

### **Check Local Storage and Cookies**

- Your regular Chrome session may have outdated or incorrect authentication/session data.
- Try clearing your browser cache, cookies, and storage for your domain:
  Open DevTools (`F12` or `Ctrl + Shift + I`) → **Application** Tab → **Storage** → **Clear site data**
- Restart the browser and test again.
- In addition, disable cache at Network tab:
![[Pasted image 20250315014231.png]]
