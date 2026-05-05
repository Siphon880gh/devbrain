Wording: Semver aka semantic versioner

---

## 🔑 Range Operators in `package.json`

|   |   |   |
|---|---|---|
|Operator|Example|Meaning|
|**Exact**|`1.2.3`|Must use this exact version only.|
|**Wildcard**|`*` or `1.2.*`|Matches any version (`*`) or any patch (`1.2.*`).|
|**Tilde (~)**|`~1.2.3`|Allows patch updates: `>=1.2.3 <1.3.0`. (Stays within same minor version.)|
|**Caret (^)**|`^1.2.3`|Allows minor + patch updates: `>=1.2.3 <2.0.0`. (Stays within same major version.)|
|**Greater than**|`>1.2.3`|Any version newer than `1.2.3`.|
|**Less than**|`<1.2.3`|Any version older than `1.2.3`.|
|**Range (dash)**|`1.2.3 - 2.3.4`|Equivalent to `>=1.2.3 <=2.3.4`.|
|**Logical OR (‖)**|`1.2.3 ‖ 1.2.5`|Allows either version (union).|
|**Latest tag**|`"latest"`|Installs whatever version is tagged as `latest` in the npm registry.|
|**Pre-release**|`1.2.3-beta.2`|Targets a specific pre-release version.|

---

### ⚖️ Special Cases

- For `0.x.x` versions:
- `^0.2.3` → only allows patch updates: `>=0.2.3 <0.3.0` (minor bump is breaking in semver <1.0).
- `~0.2.3` → also only patch updates: `>=0.2.3 <0.3.0`.
- Without operator (`"express": "1.2.3"`): same as exact, locked to that version.

---

👉 Quick mental shortcut:

- **`~` = “fix bugs”** (safe patch bumps only).
- **`^` = “new features, no breaking changes”** (safe minor + patch bumps).
- **Exact (`=`)** = “don’t move, ever.”