In GitHub (and Git in general), there isn’t a single enforced convention for naming feature branches, but there are widely accepted best practices that teams follow to keep things organized and predictable.

### Common Conventions

1. **Prefix by purpose/type**
   Use a prefix that indicates the branch’s purpose:

   * `feature/` → for new features
   * `fix/` or `bugfix/` → for bug fixes
   * `hotfix/` → for urgent production fixes
   * `chore/` → for cleanup or tooling tasks
   * `docs/` → for documentation updates
   * `test/` → for experiments or testing

   Example:

   ```
   feature/login-authentication
   fix/navbar-overlap
   hotfix/payment-crash
   docs/api-endpoints
   ```

2. **Use kebab-case or snake\_case**
   Stick to lowercase and separate words with `-` (preferred) or `_`. Avoid spaces and uppercase since they’re harder to type and can cause inconsistencies.

3. **Include ticket/issue number (if using a tracker)**
   If you’re using Jira, GitHub Issues, or another tracker, include the ID for traceability:

   ```
   feature/123-add-search-bar
   bugfix/456-fix-typo-in-footer
   ```

4. **Keep it descriptive but concise**
   Enough detail to know what’s inside, but not overly long. A few words summarizing the work is ideal.

---

### Example Naming Patterns

* **Simple features:**
  `feature/user-profile`
  `feature/export-to-csv`

* **With issue numbers:**
  `feature/101-user-authentication`
  `fix/202-login-redirect`

* **Hotfixes for production:**
  `hotfix/critical-db-timeout`

---

👉 The key is consistency across the repo/team. Some teams even add their initials or squad names if multiple groups contribute, like:
`feature/teamA-reporting-module`
