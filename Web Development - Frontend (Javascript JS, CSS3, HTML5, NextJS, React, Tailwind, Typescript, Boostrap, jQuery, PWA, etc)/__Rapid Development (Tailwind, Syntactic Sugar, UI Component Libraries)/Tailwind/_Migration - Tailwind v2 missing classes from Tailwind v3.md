Tailwind CSS v3 introduced both a new defaults-based engine (the JIT engine by default) and a large set of additional classes, variants, and configuration options that do not exist in v2. Below is a broad overview of what you’d miss by staying on Tailwind v2. (Note that some of these features can be added partially through plugins, but in general these are first-class features that ship out-of-the-box with Tailwind v3.)

---

## 1. Expanded Color Palette

**New named color palettes** were introduced in v3 (some as renames, others entirely new), such as:

- `sky`
- `cyan`
- `teal`
- `emerald`
- `lime`
- `stone`
- `neutral`
- `zinc`

For example, you can now use classes like `bg-sky-500` or `text-lime-700`. In v2, these palettes do not exist out of the box and would require custom configuration if you wanted them.

---

## 2. JIT Engine and Arbitrary Value Support

Tailwind v3 defaults to a Just-In-Time (JIT) engine, which unlocks **arbitrary value** and **arbitrary property** support. For example:

- **Arbitrary values**: `mt-[17px]`, `bg-[#1da1f2]`, `p-[3.75rem]`.
- **Arbitrary properties**: `[clip-path:polygon(0_0,_0_100%,_100%_100%)]`.

In v2, you don’t have arbitrary values/properties built in. You either need to predefine all values in the config or rely on third-party solutions.

---

## 3. New Utility Classes

With each major release, Tailwind adds new classes for modern CSS features. Here are some you’d only find in v3 (or that are significantly expanded in v3):

1. **Filter & Backdrop Utilities**
    
    - `filter`, `backdrop-filter`
    - `blur`, `brightness`, `contrast`, `grayscale`, `invert`, `sepia`, `hue-rotate`, `drop-shadow`, etc.
    - `backdrop-blur`, `backdrop-brightness`, `backdrop-contrast`, etc.
2. **Scroll Snap Utilities**
    
    - `snap-start`, `snap-center`, `snap-end`
    - `snap-x`, `snap-y`, `snap-both`
    - `snap-mandatory`, `snap-proximity`
3. **Aspect Ratio** (moved into core in v3)
    
    - `aspect-auto`, `aspect-square`, `aspect-video`
4. **Line Clamp** (moved into core in v3)
    
    - `line-clamp-1`, `line-clamp-2`, …, `line-clamp-none`
5. **Column Layout**
    
    - `columns-2`, `columns-3`, `columns-auto`, etc.
6. **Extended Spacing Scale**
    
    - v3 introduced additional spacing steps, e.g. `p-72`, `p-80`, `p-96`, etc., beyond v2’s default scale.
7. **Extended Ring Utilities**
    
    - `ring-offset-0`, `ring-offset-1`, etc.
    - `ring-offset-color`
    - `ring-inset`
8. **Extended Typography & Form Utilities**
    
    - e.g., more detailed outline classes, more native form styles (in the official `@tailwindcss/forms` plugin with better defaults by v3).

---

## 4. More Variants

Along with new classes, Tailwind v3 introduced or expanded support for **new variant prefixes**, such as:

- `group-focus-within:`
- `peer-checked:`, `peer-invalid:` (if you use the `peer` variant)
- `focus-visible:` (for better accessibility)
- `motion-safe:` and `motion-reduce:`

While some of these variants also exist in v2 or can be enabled via config, v3 made them more robust out of the box.

---

## 5. Performance & Configuration Differences

Since v3 uses the JIT engine by default:

- **Performance**: Tailwind v3 scans your files in real time and generates only the classes you actually use, often resulting in smaller CSS builds.
- **Configuration**: Some config keys changed or were renamed; v3’s default configuration is different, especially around colors and how plugins are integrated.

---

## 6. Official Plugin Enhancements

Tailwind’s ecosystem of official plugins (like `forms`, `typography`, `aspect-ratio`, `line-clamp`, etc.) matured alongside v3. Even though you can use them in v2, certain features and defaults are tailored to v3. For instance, the `@tailwindcss/typography` plugin has expanded color and style options that pair with the new palettes.

---

# Summary

If you stay on Tailwind CSS v2.x.x, you’ll miss out on:

1. **New color palettes** (e.g., `sky`, `lime`, `stone`) and extended color sets.
2. **JIT engine** features, especially **arbitrary value** and **arbitrary property** support.
3. **New utility classes** for filters, backdrops, scroll snapping, aspect-ratio, line clamp, columns, extended spacing, ring offset, etc.
4. **Enhanced variants** (e.g., peer-based states, focus-visible, motion-safe).
5. **Improved performance** due to the new JIT compilation approach.
6. **Better out-of-the-box plugin support** for forms, typography, and more.

You can often replicate some of these features by manually adding plugins or modifying your tailwind.config.js in Tailwind v2. However, **the easiest path to gain them all** is to migrate to Tailwind CSS v3 (or newer).