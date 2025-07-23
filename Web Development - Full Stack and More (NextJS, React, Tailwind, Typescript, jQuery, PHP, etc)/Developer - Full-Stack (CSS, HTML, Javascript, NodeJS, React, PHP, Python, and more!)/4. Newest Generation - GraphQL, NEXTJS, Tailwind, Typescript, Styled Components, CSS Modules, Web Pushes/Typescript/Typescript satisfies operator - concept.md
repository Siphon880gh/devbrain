### **Compare & Contrast Example:**
**Function Expecting Specific Colors**

```typescript
type AllowedColors = "ff0000" | "00ff00" | "0000ff";

function setThemeColor(color: AllowedColors) {
  console.log(`Setting theme color to #${color}`);
}

// Without `satisfies`, TypeScript may widen the type:
const colors1 = {
  primary: "ff0000",
  secondary: "00ff00",
}; // TypeScript infers { primary: string; secondary: string }

setThemeColor(colors1.primary); // ❌ Type error: string is not assignable to AllowedColors

// Using `satisfies` to preserve literal types:
const colors2 = {
  primary: "ff0000",
  secondary: "00ff00",
} satisfies Record<string, AllowedColors>;

setThemeColor(colors2.primary); // ✅ Works! TypeScript knows it's an AllowedColor
setThemeColor(colors2.secondary); // ✅ Works!

setThemeColor("123456"); // ❌ Type error: "123456" is not in AllowedColors
```

---

Alternate syntax (Notice you don't have to use Record type):
```typescript
type AllowedColors = "ff0000" | "00ff00" | "0000ff";

function setThemeColor(color: AllowedColors) {
  console.log(`Setting theme color to #${color}`);
}

// Without `satisfies`, TypeScript may widen the type:
const colors1 = {
  primary: "ff0000",
  secondary: "00ff00",
}; // TypeScript infers { primary: string; secondary: string }

setThemeColor(colors1.primary); // ❌ Type error: string is not assignable to AllowedColors

// Using `satisfies` to preserve literal types:
const colors2 = {
  primary: "ff0000",
  secondary: "00ff00",
} satisfies { primary: AllowedColors; secondary: AllowedColors };

setThemeColor(colors2.primary); // ✅ Works! TypeScript knows it's an AllowedColor
setThemeColor(colors2.secondary); // ✅ Works!

setThemeColor("123456"); // ❌ Type error: "123456" is not in AllowedColors
```


---


### **Why is `satisfies` Useful Here?**

- **Prevents accidental invalid colors** (`"123456"` wouldn't be allowed).
- **Keeps `"ff0000"` as `"ff0000"`, not just `string`**.
- **Ensures function arguments are from a predefined set**.
- **Provides better autocomplete and IntelliSense support**.

This technique is particularly useful in **theming systems**, **CSS frameworks**, or **config objects** where you need to enforce specific values while keeping inference.
