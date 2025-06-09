When writing `if`/`else` branches or any logic tree:

> **Assume the next developer has not walked through every branch. Write it so that they *expect* the behavior without having to check.**

* ✅ They should **assume the same choices** you made.
* ✅ The logic should match **how they would naturally think** it works.
* ✅ Surprises cost time, cause bugs, and erode trust in the code.

---

### 🧠 In Practice:

* Keep the **"happy path" or most common case** in the `if`, not the `else`.
* Avoid complex inversions like `if (!x || !y)` when `if (x && y)` is easier to follow.
* Be consistent with **naming**, **ordering**, and **return patterns** across branches.

---
### 📜 Guidelines

#### Use Natural Logic Flow

```js
// GOOD
if (user.isLoggedIn) {
  showDashboard();
} else {
  redirectToLogin();
}
```

```js
// BAD (surprising inversion)
if (!user.isLoggedIn) {
  redirectToLogin();
} else {
  showDashboard();
}
```

#### Keep Common Paths on Top

Write the most likely or default case in the `if`, not the `else`.

```python
# Preferred
if is_valid:
    process_data()
else:
    log_error()
```

#### Avoid Cleverness That Hurts Clarity

```ts
// Clever but confusing
return x ? (y ? A : B) : C;

// Clearer
if (!x) return C;
return y ? A : B;
```

---

### 👍 Quick Rule of Thumb

If another competent developer **guessed** how this code works, would they guess right?

If not — rewrite it.