WordPress post meta becomes much more usable for editors when it’s surfaced as a sidebar field on the edit screen. A meta box handles the **UI**, and a `save_post` handler persists the value to the database.

![[Pasted image 20251216234305.png]]

This guide shows a safe base implementation and common field types beyond a free-form text input.

---
## Core pattern

All field types follow the same structure:
- **Render:** load the current meta value and output the form control
- **Secure:** include a nonce in the meta box and verify it on save
- **Save:** sanitize/validate `$_POST` and `update_post_meta()`

---

## Base implementation (text input)

Define the meta key + label:

```php
define('META_KEY', 'priority');
define('COLUMN_LABEL', 'Priority');
```

Render the meta box:

```php
add_action('add_meta_boxes', function () {
    add_meta_box(
        'meta_box_' . META_KEY,
        COLUMN_LABEL,
        function ($post) {
            $value = get_post_meta($post->ID, META_KEY, true);
            wp_nonce_field('save_' . META_KEY, 'nonce_' . META_KEY);
            ?>
            <input
                type="text"
                name="<?php echo esc_attr(META_KEY); ?>"
                value="<?php echo esc_attr($value); ?>"
                style="width:100%;"
            />
            <?php
        },
        ['post', 'page'],
        'side'
    );
});
```

Save safely:

```php
add_action('save_post', function ($post_id) {
    $nonce = $_POST['nonce_' . META_KEY] ?? null;
    if (!$nonce || !wp_verify_nonce($nonce, 'save_' . META_KEY)) return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (!isset($_POST[META_KEY])) return;

    $value = sanitize_text_field(wp_unslash($_POST[META_KEY]));

    if ($value === '') {
        delete_post_meta($post_id, META_KEY);
    } else {
        update_post_meta($post_id, META_KEY, $value);
    }
});
```

---

## Other types of inputs

Don't want just text input?

Here are other render blocks for numeric input with min and max, dropdown, radio buttons, checkboxes, checklists

A **render** block is the HTML (and a little PHP) that goes **inside the meta box callback** — the `function ($post) { ... }` you pass as the 4th argument to the wordpress hook `add_meta_box()`

---

### Number input (min/max)

A numeric field renders as `type="number"` and saves as an **integer** (or deletes meta when empty). Min/max should be enforced in **both** places:

- **UI:** `min`, `max`, `step`
    
- **Server:** clamp/validate before saving
    

**Render**

```php
$value = get_post_meta($post->ID, META_KEY, true);

$min  = 1;
$max  = 100;
$step = 1;

// Show empty if nothing saved yet (avoid displaying 0 accidentally)
$display = ($value === '' ? '' : (int) $value);
?>
<input
  type="number"
  name="<?php echo esc_attr(META_KEY); ?>"
  value="<?php echo esc_attr($display); ?>"
  min="<?php echo esc_attr($min); ?>"
  max="<?php echo esc_attr($max); ?>"
  step="<?php echo esc_attr($step); ?>"
  style="width:100%;"
/>
<?php
```

**Save**

```php
$min = 1;
$max = 100;

$raw = $_POST[META_KEY] ?? null;

// Empty string means “clear it”
if ($raw === null || $raw === '') {
    delete_post_meta($post_id, META_KEY);
    return;
}

$raw = wp_unslash($raw);

// Validate numeric
if (!is_numeric($raw)) {
    return; // ignore invalid input
}

$value = (int) $raw;

// Clamp to min/max
if ($value < $min) $value = $min;
if ($value > $max) $value = $max;

update_post_meta($post_id, META_KEY, $value);
```

If the field should allow decimals, switch to `(float)` and adjust `step` (e.g. `0.1`) plus use a decimal-safe sanitizer/validator.

---

### Dropdown (select)

**Render**

```php
$options = [
  ''        => '— Select —',
  'low'     => 'Low',
  'medium'  => 'Medium',
  'high'    => 'High',
];

$value = get_post_meta($post->ID, META_KEY, true);
?>
<select name="<?php echo esc_attr(META_KEY); ?>" style="width:100%;">
  <?php foreach ($options as $key => $label): ?>
    <option value="<?php echo esc_attr($key); ?>" <?php selected($value, $key); ?>>
      <?php echo esc_html($label); ?>
    </option>
  <?php endforeach; ?>
</select>
<?php
```

**Save (validate allowed values)**

```php
$allowed = array_keys($options);

$raw = wp_unslash($_POST[META_KEY] ?? '');
$value = in_array($raw, $allowed, true) ? $raw : '';

if ($value === '') delete_post_meta($post_id, META_KEY);
else update_post_meta($post_id, META_KEY, $value);
```

---

### Radio buttons (single choice)

**Render**

```php
$choices = [
  'draft' => 'Draft-ish',
  'ready' => 'Ready',
  'live'  => 'Live',
];

$value = get_post_meta($post->ID, META_KEY, true);

foreach ($choices as $key => $label) : ?>
  <label style="display:block; margin:6px 0;">
    <input
      type="radio"
      name="<?php echo esc_attr(META_KEY); ?>"
      value="<?php echo esc_attr($key); ?>"
      <?php checked($value, $key); ?>
    />
    <?php echo esc_html($label); ?>
  </label>
<?php endforeach; ?>
```

**Save (validate allowed values)**

```php
$allowed = array_keys($choices);

$raw = wp_unslash($_POST[META_KEY] ?? '');
$value = in_array($raw, $allowed, true) ? $raw : '';

if ($value === '') delete_post_meta($post_id, META_KEY);
else update_post_meta($post_id, META_KEY, $value);
```

---

### Checkbox (boolean)

Checkboxes require one special rule: when unchecked, the field is not present in `$_POST`.

**Render**

```php
$value = get_post_meta($post->ID, META_KEY, true); // store '1' or ''
?>
<label>
  <input
    type="checkbox"
    name="<?php echo esc_attr(META_KEY); ?>"
    value="1"
    <?php checked($value, '1'); ?>
  />
  Featured
</label>
<?php
```

**Save**

```php
$is_checked = isset($_POST[META_KEY]) ? '1' : '';

if ($is_checked === '') delete_post_meta($post_id, META_KEY);
else update_post_meta($post_id, META_KEY, '1');
```

---

### Checklist (multiple checkboxes → array)

Multi-select uses `[]` in the input name and stores an array in post meta.

**Render**

```php
$choices = [
  'seo'   => 'SEO',
  'ads'   => 'Ads',
  'email' => 'Email',
];

$saved = get_post_meta($post->ID, META_KEY, true);
$saved = is_array($saved) ? $saved : [];

foreach ($choices as $key => $label) : ?>
  <label style="display:block; margin:6px 0;">
    <input
      type="checkbox"
      name="<?php echo esc_attr(META_KEY); ?>[]"
      value="<?php echo esc_attr($key); ?>"
      <?php checked(in_array($key, $saved, true)); ?>
    />
    <?php echo esc_html($label); ?>
  </label>
<?php endforeach; ?>
```

**Save (sanitize array + whitelist)**

```php
$allowed = array_keys($choices);

$raw = $_POST[META_KEY] ?? [];
$raw = is_array($raw) ? array_map('wp_unslash', $raw) : [];

$value = array_values(array_intersect($raw, $allowed));

if (empty($value)) delete_post_meta($post_id, META_KEY);
else update_post_meta($post_id, META_KEY, $value);
```

---

### Slider (range) + live value display (min/max)

A slider uses `type="range"` for the control, plus a small value readout. The slider enforces **min/max** in the UI, and the save handler clamps the value server-side.

**Render**

```php
$value = get_post_meta($post->ID, META_KEY, true);

$min  = 1;
$max  = 100;
$step = 1;

// Default to min if nothing saved yet
$current = ($value === '' ? $min : (int) $value);
$current = max($min, min($max, $current));
?>
<div style="display:flex; gap:10px; align-items:center;">
  <input
    type="range"
    name="<?php echo esc_attr(META_KEY); ?>"
    value="<?php echo esc_attr($current); ?>"
    min="<?php echo esc_attr($min); ?>"
    max="<?php echo esc_attr($max); ?>"
    step="<?php echo esc_attr($step); ?>"
    style="flex:1;"
    oninput="this.nextElementSibling.value=this.value"
  />
  <output style="min-width:3ch; text-align:right;"><?php echo esc_html($current); ?></output>
</div>
<p class="description">Range: <?php echo esc_html($min); ?>–<?php echo esc_html($max); ?></p>
<?php
```

**Save**

```php
$min = 1;
$max = 100;

$raw = $_POST[META_KEY] ?? null;

// Empty means clear
if ($raw === null || $raw === '') {
    delete_post_meta($post_id, META_KEY);
    return;
}

$raw = wp_unslash($raw);

if (!is_numeric($raw)) {
    return; // ignore invalid input
}

$value = (int) $raw;

// Clamp
if ($value < $min) $value = $min;
if ($value > $max) $value = $max;

update_post_meta($post_id, META_KEY, $value);
```

---


## Noteworthy implementations

- `wp_unslash()` is needed because WordPress slashes `$_POST`.
- Dropdowns/radios should always validate against an allow-list.
- Unchecked checkboxes require handling the “missing from `$_POST`” case.
- Arrays can be stored in post meta directly (WordPress serializes automatically).