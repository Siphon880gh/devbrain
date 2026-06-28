Use this when adding **Copy** buttons to a web app. A button that only calls `navigator.clipboard.writeText()` is incomplete — you must address **both** HTTPS and HTTP copy scenarios below, or the button will silently fail for many real users when they accidentally visit a HTTP version and your website doesn't redirect to HTTPS (sometimes that's intentional, like for Cloudflare's lower chance of failing setup - Flexible SSL).

---

## The two scenarios you must support

| Scenario                | Typical context                                                                      | What to use                             |
| ----------------------- | ------------------------------------------------------------------------------------ | --------------------------------------- |
| **1. Secure context**   | HTTPS, `http://localhost`, `http://127.0.0.1`                                        | `navigator.clipboard.writeText()`       |
| **2. Insecure context** | Plain HTTP on a hostname or IP (e.g. `http://192.168.1.5/...`), some `file://` pages | `document.execCommand('copy')` fallback |

**Best practice:** implement Scenario 1 first, then fall back to Scenario 2 when the Clipboard API is missing or rejects the write. Never assume every visitor is on HTTPS.

This is usually **not** an iOS or iPhone problem. The common “works on my machine, broken for someone else” case is **HTTP vs HTTPS**, not the device.

---

  

## Best practice 1: Trigger copy from a user gesture

  

Copy must run from a **click or tap** on the button — not from page load, a timer, or a background event.

  

- Attach copy logic to the button’s click handler.

- Use `type="button"` on buttons inside `<form>` so they do not submit the form.

  

---

  

## Best practice 2: Use the Clipboard API in secure contexts

  

In Scenario 1, prefer the modern API:

  

```javascript

navigator.clipboard.writeText('text to copy')

.then(() => { /* success */ })

.catch((err) => { /* failed — try fallback */ });

```

  

It works when:

  

- The page is served over **HTTPS**, or

- The page is on **`http://localhost`** / **`http://127.0.0.1`** (browser treats these as secure contexts)

- The user clicked the button

- The browser supports the Async Clipboard API

  

**Do not** call `writeText` blindly. On plain HTTP (Scenario 2), `navigator.clipboard` is often **`undefined`**. Calling `navigator.clipboard.writeText(...)` throws immediately — before `.catch()` runs — and the button appears to do nothing.

  

| Context | Clipboard API usually available? |

|--------|-----------------------------------|

| `https://example.com` | Yes → Scenario 1 |

| `http://localhost:8080` | Yes → Scenario 1 |

| `http://127.0.0.1:8080` | Yes → Scenario 1 |

| `http://192.168.x.x` (LAN IP) | **Often no** → Scenario 2 |

| `http://myserver.local` | **Often no** → Scenario 2 |

| `file://` (opened from disk) | **Often no** → Scenario 2 |

  

---

  

## Best practice 3: Provide an execCommand fallback for insecure contexts

  

For Scenario 2, use the older copy path when the Clipboard API is unavailable or rejects the write.

  

```javascript

function copyTextWithExecCommand(text) {

const textarea = document.createElement('textarea');

textarea.value = text;

textarea.setAttribute('readonly', '');

textarea.style.position = 'fixed';

textarea.style.left = '-9999px';

document.body.appendChild(textarea);

textarea.select();

let ok = false;

try {

ok = document.execCommand('copy');

} catch (err) {

console.error('execCommand copy failed:', err);

}

document.body.removeChild(textarea);

return ok;

}

```

  

Notes:

  

- Still requires a user gesture (button click).

- Works on many HTTP pages where `navigator.clipboard` does not.

- Returns `false` on failure — check the return value.

- Deprecated, but still the practical fallback for Scenario 2.

  

---

  

## Best practice 4: Wire both scenarios in one function

  

Never ship a copy button that only handles Scenario 1. Combine both paths:

  

```javascript

function copyTextToClipboard(text, feedbackBtn) {

const onSuccess = () => showCopyButtonFeedback(feedbackBtn);

const onFailure = (err) => {

console.error('Failed to copy:', err);

alert('Failed to copy to clipboard');

};

  

// Scenario 1: Clipboard API (secure context)

if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {

navigator.clipboard.writeText(text)

.then(onSuccess)

.catch(() => {

// Scenario 1 failed — try Scenario 2

if (copyTextWithExecCommand(text)) onSuccess();

else onFailure(new Error('Clipboard write rejected'));

});

return;

}

  

// Scenario 2: no Clipboard API (insecure context)

if (copyTextWithExecCommand(text)) onSuccess();

else onFailure(new Error('Clipboard API unavailable'));

}

```

  

Order matters:

  

1. **Try Scenario 1** — preferred on HTTPS.

2. **Fall back to Scenario 2** when `navigator.clipboard` is missing (HTTP) or when `writeText` rejects.

3. **Report failure** if both scenarios fail.

  

Reference implementation in this project: `js/custom-emotions.js` (`copyTextToClipboard`, `copyTextWithExecCommand`).

  

---

  

## Best practice 5: Give clear success and failure feedback

  

After copy:

  

- **Success** — change the button label (e.g. “✓ Copied!” for ~2 seconds), or show a toast.

- **Failure** — show a message if both Scenario 1 and Scenario 2 fail.

  

Copy the **actual string** the user expects (visible text or canonical export), not a stale variable.

  

---

  

## Best practice 6: Test both scenarios before shipping

  

- [ ] Copy runs from a **click/tap**, not automatically

- [ ] **Scenario 1** works on HTTPS or localhost

- [ ] **Scenario 2** works on plain HTTP (e.g. LAN IP) — simulate by undefining `navigator.clipboard` in DevTools if needed

- [ ] Success feedback appears on both paths

- [ ] Failure feedback appears when both paths fail

- [ ] Text pasted matches what the user expected

  

---

  

## Debugging “copy button does nothing”

  

1. **Check the URL** — plain HTTP on a non-localhost host? You need Scenario 2.

2. **Console** — look for `Cannot read properties of undefined (reading 'writeText')` (Scenario 1 called without a guard).

3. **User gesture** — copy must follow a click, not run alone in `setTimeout`.

4. **Empty text** — copying nothing can look like failure after paste.

5. **HTTPS test** — if copy works on HTTPS but not HTTP, both scenarios are not wired up.

  

---

  

## Deployment note

  

The code fix is **always implement both scenarios**. The deployment fix for production is **serve over HTTPS** so Scenario 1 is available — but keep Scenario 2 anyway for LAN testing, internal HTTP hosts, and browsers that reject the write.

  

---

  

## Related

  

- Export modal copy buttons: `index.php` (markup), `js/custom-emotions.js` (implementation)

- [MDN: Clipboard API](https://developer.mozilla.org/en-US/docs/Web/API/Clipboard_API)

- [MDN: Secure contexts](https://developer.mozilla.org/en-US/docs/Web/Security/Secure_Contexts)# Best Practices: Copy to Clipboard Buttons

Use this when adding **Copy** buttons to a web app. A button that only calls `navigator.clipboard.writeText()` is incomplete — you must address **both** HTTPS and HTTP copy scenarios below, or the button will silently fail for many real users when they accidentally visit a HTTP version and your website doesn't redirect to HTTPS (sometimes that's intentional, like for Cloudflare's lower chance of failing setup - Flexible SSL).

---

## The two scenarios you must support

| Scenario | Typical context | What to use |
|----------|-----------------|-------------|
| **1. Secure context** | HTTPS, `http://localhost`, `http://127.0.0.1` | `navigator.clipboard.writeText()` |
| **2. Insecure context** | Plain HTTP on a hostname or IP (e.g. `http://192.168.1.5/...`), some `file://` pages | `document.execCommand('copy')` fallback |

**Best practice:** implement Scenario 1 first, then fall back to Scenario 2 when the Clipboard API is missing or rejects the write. Never assume every visitor is on HTTPS.

This is usually **not** an iOS or iPhone problem. The common “works on my machine, broken for someone else” case is **HTTP vs HTTPS**, not the device.

---

## Best practice 1: Trigger copy from a user gesture

Copy must run from a **click or tap** on the button — not from page load, a timer, or a background event.

- Attach copy logic to the button’s click handler.
- Use `type="button"` on buttons inside `<form>` so they do not submit the form.

---

## Best practice 2: Use the Clipboard API in secure contexts

In Scenario 1, prefer the modern API:

```javascript
navigator.clipboard.writeText('text to copy')
  .then(() => { /* success */ })
  .catch((err) => { /* failed — try fallback */ });
```

It works when:

- The page is served over **HTTPS**, or
- The page is on **`http://localhost`** / **`http://127.0.0.1`** (browser treats these as secure contexts)
- The user clicked the button
- The browser supports the Async Clipboard API

**Do not** call `writeText` blindly. On plain HTTP (Scenario 2), `navigator.clipboard` is often **`undefined`**. Calling `navigator.clipboard.writeText(...)` throws immediately — before `.catch()` runs — and the button appears to do nothing.

| Context | Clipboard API usually available? |
|--------|-----------------------------------|
| `https://example.com` | Yes → Scenario 1 |
| `http://localhost:8080` | Yes → Scenario 1 |
| `http://127.0.0.1:8080` | Yes → Scenario 1 |
| `http://192.168.x.x` (LAN IP) | **Often no** → Scenario 2 |
| `http://myserver.local` | **Often no** → Scenario 2 |
| `file://` (opened from disk) | **Often no** → Scenario 2 |

---

## Best practice 3: Provide an execCommand fallback for insecure contexts

For Scenario 2, use the older copy path when the Clipboard API is unavailable or rejects the write.

```javascript
function copyTextWithExecCommand(text) {
  const textarea = document.createElement('textarea');
  textarea.value = text;
  textarea.setAttribute('readonly', '');
  textarea.style.position = 'fixed';
  textarea.style.left = '-9999px';
  document.body.appendChild(textarea);
  textarea.select();
  let ok = false;
  try {
    ok = document.execCommand('copy');
  } catch (err) {
    console.error('execCommand copy failed:', err);
  }
  document.body.removeChild(textarea);
  return ok;
}
```

Notes:

- Still requires a user gesture (button click).
- Works on many HTTP pages where `navigator.clipboard` does not.
- Returns `false` on failure — check the return value.
- Deprecated, but still the practical fallback for Scenario 2.

---

## Best practice 4: Wire both scenarios in one function

Never ship a copy button that only handles Scenario 1. Combine both paths:

```javascript
function copyTextToClipboard(text, feedbackBtn) {
  const onSuccess = () => showCopyButtonFeedback(feedbackBtn);
  const onFailure = (err) => {
    console.error('Failed to copy:', err);
    alert('Failed to copy to clipboard');
  };

  // Scenario 1: Clipboard API (secure context)
  if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
    navigator.clipboard.writeText(text)
      .then(onSuccess)
      .catch(() => {
        // Scenario 1 failed — try Scenario 2
        if (copyTextWithExecCommand(text)) onSuccess();
        else onFailure(new Error('Clipboard write rejected'));
      });
    return;
  }

  // Scenario 2: no Clipboard API (insecure context)
  if (copyTextWithExecCommand(text)) onSuccess();
  else onFailure(new Error('Clipboard API unavailable'));
}
```

Order matters:

1. **Try Scenario 1** — preferred on HTTPS.
2. **Fall back to Scenario 2** when `navigator.clipboard` is missing (HTTP) or when `writeText` rejects.
3. **Report failure** if both scenarios fail.

Reference implementation in this project: `js/custom-emotions.js` (`copyTextToClipboard`, `copyTextWithExecCommand`).

---

## Best practice 5: Give clear success and failure feedback

After copy:

- **Success** — change the button label (e.g. “✓ Copied!” for ~2 seconds), or show a toast.
- **Failure** — show a message if both Scenario 1 and Scenario 2 fail.

Copy the **actual string** the user expects (visible text or canonical export), not a stale variable.

---

## Best practice 6: Test both scenarios before shipping

- [ ] Copy runs from a **click/tap**, not automatically
- [ ] **Scenario 1** works on HTTPS or localhost
- [ ] **Scenario 2** works on plain HTTP (e.g. LAN IP) — simulate by undefining `navigator.clipboard` in DevTools if needed
- [ ] Success feedback appears on both paths
- [ ] Failure feedback appears when both paths fail
- [ ] Text pasted matches what the user expected

---

## Debugging “copy button does nothing”

1. **Check the URL** — plain HTTP on a non-localhost host? You need Scenario 2.
2. **Console** — look for `Cannot read properties of undefined (reading 'writeText')` (Scenario 1 called without a guard).
3. **User gesture** — copy must follow a click, not run alone in `setTimeout`.
4. **Empty text** — copying nothing can look like failure after paste.
5. **HTTPS test** — if copy works on HTTPS but not HTTP, both scenarios are not wired up.

---

## Deployment note

The code fix is **always implement both scenarios**. The deployment fix for production is **serve over HTTPS** so Scenario 1 is available — but keep Scenario 2 anyway for LAN testing, internal HTTP hosts, and browsers that reject the write.

---

## Related

- Export modal copy buttons: `index.php` (markup), `js/custom-emotions.js` (implementation)
- [MDN: Clipboard API](https://developer.mozilla.org/en-US/docs/Web/API/Clipboard_API)
- [MDN: Secure contexts](https://developer.mozilla.org/en-US/docs/Web/Security/Secure_Contexts)
