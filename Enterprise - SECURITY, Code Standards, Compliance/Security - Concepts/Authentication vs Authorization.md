**Authentication vs Authorization – Quick Comparison**

| Feature           | Authentication                      | Authorization                             |
| ----------------- | ----------------------------------- | ----------------------------------------- |
| **What it is**    | Verifying _who_ someone is          | Verifying _what_ they’re allowed to do    |
| **Example**       | Logging in with email & password    | Accessing admin dashboard or private data |
| **Comes first**   | ✅ Yes – must authenticate first     | 🚫 No – only after authentication         |
| **Data involved** | Username, password, biometric, etc. | Roles, permissions, access control rules  |
| **Handled by**    | Login systems (OAuth, SSO, etc.)    | Access control systems (RBAC, ACL, etc.)  |

**Quick way to remember**:
- **Authentication** asks: _"Who are you?"_
- **Authorization** asks: _"What can you do?"_