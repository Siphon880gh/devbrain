
By default, custom admin columns are **read-only**. If you want to change a custom field **without opening the post or page editor**, WordPress provides two built-in tools:

- **Quick Edit** — edit one item inline
- **Bulk Edit** — apply the same value to many items at once

They are also known as inline editing (because you're editing on the fly at the Pages or Posts list without going into editing the entire page or post)

Both operate directly in the **Posts / Pages list table** (`edit.php`).

This section shows how to wire Quick Edit + Bulk Edit to the **same custom meta key** you already save on the Edit Post/Page screen.

![[Pasted image 20251217010058.png]]

---

## Important: Meta Key Must Match

Everything in this section assumes:

- You already save a custom field using `update_post_meta()`
    
- You use **the same meta key everywhere**
    

For example, if your Edit Post/Page code saves (The custom variable here is `priority`):

```php
update_post_meta($post_id, 'priority', $value);
```

Then **Quick Edit and Bulk Edit must also use**:

```php
$meta_key = 'priority';
```

If the meta key does not match exactly, Quick Edit will render but **nothing will save**.

If you’re adding **Quick Edit / Bulk Edit** on top of your sidebar meta box setup (see: [[Add a sidebar meta box for post meta (text, numeric input, dropdowns, radios, checkboxes, checklist, slider)]]), you’ll probably be using a meta key that’s prefixed with `n_` or `s_` and centralized as a single `META_KEY` constant. That convention makes a big codebase (as such is when you're adding a sortable column that's based off a custom meta box value) easier to maintain, and it also forces the correct sort behavior: `n_` keys sort **numerically** (so `10` comes after `2`), while `s_` keys sort **alphabetically**. **Follow modification instructions for having used global constant and prefix type conventions**

---

## Minimal Working Example (Quick Edit)

❗️If you want Bulk Edit, refer to [[Bulk Edit (WP Dev)]]

This example:

- Renders a field in Quick Edit when user clicks "Quick Edit"
- Prefills it with the current value
- Saves the value on update

If following modification instructions for having used global constant and prefix type conventions, change first few lines to:
```
    $meta_key     = META_KEY;
    $column_label = COLUMN_LABEL;
```

The code:
```php
add_action('init', function () {
    $meta_key     = 'priority';
    $column_label = 'Priority';

    /**
     * 1) Render field in Quick Edit
     */
    add_action('quick_edit_custom_box', function ($column_name, $post_type) use ($meta_key, $column_label) {
        if ($column_name !== $meta_key) return;
        if (!in_array($post_type, ['post', 'page'], true)) return;

        wp_nonce_field('save_quickedit_' . $meta_key, 'nonce_quickedit_' . $meta_key);
        ?>
        <fieldset class="inline-edit-col-left">
          <div class="inline-edit-col">
            <label>
              <span class="title"><?php echo esc_html($column_label); ?></span>
              <span class="input-text-wrap">
                <input type="text" name="<?php echo esc_attr($meta_key); ?>" value="" />
              </span>
            </label>
            <p class="description">Leave blank to remove the meta value.</p>
          </div>
        </fieldset>
        <?php
    }, 10, 2);

    /**
     * 2) Prefill field when clicking Quick Edit (JS)
     *    Requires your column cell to have class: td.column-priority
     */
    add_action('admin_enqueue_scripts', function ($hook) use ($meta_key) {
        if ($hook !== 'edit.php') return;

        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        if (!$screen || !in_array($screen->post_type, ['post', 'page'], true)) return;

        wp_enqueue_script('jquery');

        $meta_key_js = wp_json_encode($meta_key);

        wp_add_inline_script('jquery', "
        jQuery(function($){
          var metaKey = {$meta_key_js};

          $(document).on('click', '.editinline', function(){
            var \$row = $(this).closest('tr');
            var postId = \$row.attr('id').replace('post-', '');
            var current = $.trim(\$row.find('td.column-' + metaKey).text());

            var \$editRow = $('#edit-' + postId);
            \$editRow.find('input[name=\"' + metaKey + '\"]').val(current);
          });
        });
        ");
    });

    /**
     * 3) Save value on Quick Edit update
     */
    add_action('save_post', function ($post_id) use ($meta_key) {
        // Only in admin
        if (!is_admin()) return;

        // Only for post/page
        $post_type = get_post_type($post_id);
        if (!in_array($post_type, ['post', 'page'], true)) return;

        // Only when our Quick Edit nonce is present/valid
        $nonce = $_POST['nonce_quickedit_' . $meta_key] ?? null;
        if (!$nonce || !wp_verify_nonce($nonce, 'save_quickedit_' . $meta_key)) return;

        // Permissions
        if (!current_user_can('edit_post', $post_id)) return;

        // If field wasn't submitted, don't touch meta
        if (!array_key_exists($meta_key, $_POST)) return;

        $raw = trim((string) $_POST[$meta_key]);

        // Blank = delete meta
        if ($raw === '') {
            delete_post_meta($post_id, $meta_key);
            return;
        }

        // Save (sanitize as text; swap to intval() if you want numeric)
        update_post_meta($post_id, $meta_key, sanitize_text_field($raw));
    });
});
```


---
## Explanation

Here we break down the code piece by piece

### Outer Wrapper: `add_action('init', ...)`

```php
add_action('init', function () {
    $meta_key     = 'priority';
    $column_label = 'Priority';
    ...
});
```

- Runs once WordPress is initialized.
    
- Defines **one meta key** (`priority`) and a **human label** (`Priority`) in one place.
    
- Everything inside uses those variables so you don’t repeat strings everywhere.
    

---

### 1) Render the Quick Edit Field

```php
add_action('quick_edit_custom_box', function ($column_name, $post_type) use ($meta_key, $column_label) {
    if ($column_name !== $meta_key) return;
    if (!in_array($post_type, ['post', 'page'], true)) return;
```

- `quick_edit_custom_box` fires when WordPress builds the Quick Edit form.
    
- `$column_name` is the **column key** WordPress is currently rendering Quick Edit UI for.
    
- You **only** want to inject your field when that column is your meta column (`priority`).
    
- You restrict it to **posts and pages**.
    

```php
wp_nonce_field('save_quickedit_' . $meta_key, 'nonce_quickedit_' . $meta_key);
```

- Adds a nonce hidden input to protect against CSRF.
    
- Later, `save_post` checks this nonce to ensure the request is legit.
    

```php
<input type="text" name="<?php echo esc_attr($meta_key); ?>" value="" />
```

- Adds the actual field.
    
- The **name attribute matters most**: it must match the meta key (`priority`), because that’s what gets posted back in `$_POST`.
    

**Important:** This field renders **blank** initially. Quick Edit doesn’t automatically populate custom fields.

---

### 2) Prefill the Field on “Quick Edit” Click (JavaScript)

```php
add_action('admin_enqueue_scripts', function ($hook) use ($meta_key) {
    if ($hook !== 'edit.php') return;
```

- Only loads this JS on the list table screens (`edit.php`), not everywhere in wp-admin.
    

```php
$screen = function_exists('get_current_screen') ? get_current_screen() : null;
if (!$screen || !in_array($screen->post_type, ['post', 'page'], true)) return;
```

- Extra guard so it only runs on Posts/Pages list screens.
    

```php
wp_enqueue_script('jquery');
```

- Ensures jQuery exists (Quick Edit relies on it anyway).
    

```php
$meta_key_js = wp_json_encode($meta_key);
```

- Safely passes the PHP variable into JS as a proper JSON string.
    

#### The actual logic:

```js
$(document).on('click', '.editinline', function(){
  var $row = $(this).closest('tr');
  var postId = $row.attr('id').replace('post-', '');
  var current = $.trim($row.find('td.column-' + metaKey).text());

  var $editRow = $('#edit-' + postId);
  $editRow.find('input[name="' + metaKey + '"]').val(current);
});
```

When you click “Quick Edit”:

- Finds the row you clicked.
    
- Extracts the post ID from `tr#post-123`.
    
- Reads the visible value from your admin column cell:
    
    - `td.column-priority`
        
- Finds the inline Quick Edit row:
    
    - `#edit-123`
        
- Sets your input value so it shows the current meta value instead of empty.
    

---

### 3) Save the Value on Update (`save_post`)

```php
add_action('save_post', function ($post_id) use ($meta_key) {
    if (!is_admin()) return;
```

- Runs when a post saves.
    
- First guard: only run in admin context.
    

```php
$post_type = get_post_type($post_id);
if (!in_array($post_type, ['post', 'page'], true)) return;
```

- Only handle Posts/Pages.
    

```php
$nonce = $_POST['nonce_quickedit_' . $meta_key] ?? null;
if (!$nonce || !wp_verify_nonce($nonce, 'save_quickedit_' . $meta_key)) return;
```

- This is the key “only run for Quick Edit saves” check.
    
- If the nonce isn’t present/valid, it bails so you don’t accidentally affect normal edits or autosaves.
    

```php
if (!current_user_can('edit_post', $post_id)) return;
```

- Permissions check.
    

```php
if (!array_key_exists($meta_key, $_POST)) return;
```

- If the field wasn’t submitted, don’t touch existing meta.
    

```php
$raw = trim((string) $_POST[$meta_key]);
```

- Normalize the input.
    

#### Delete vs Save

```php
if ($raw === '') {
    delete_post_meta($post_id, $meta_key);
    return;
}
update_post_meta($post_id, $meta_key, sanitize_text_field($raw));
```

- Empty string → delete the meta key entirely.
    
- Otherwise → sanitize and update.
    

---

### Why this pattern works well

- **Stable configuration:** `$meta_key` is defined once.
    
- **Secure:** nonce + capability checks.
    
- **Predictable UI:** always shows the current value in Quick Edit.
    
- **Doesn’t interfere with other saves:** the nonce gate prevents accidental updates outside Quick Edit.