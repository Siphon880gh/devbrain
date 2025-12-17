By default, custom admin columns are **read-only**. If you want to change a custom field **without opening the post or page editor**, WordPress provides two built-in tools:

- **Quick Edit** — edit one item inline
- **Bulk Edit** — apply the same change to many items at once

They’re also known as **inline editing** (because you edit directly inside the Posts/Pages list table, without opening the full editor).

Both operate on the list table screen (`edit.php`).

This section shows how to wire **Bulk Edit** to the **same custom meta key** you already save on the Edit Post/Page screen.

![[Pasted image 20251217010717.png]]

As a quick refresh, in order to Bulk Edit, you need to first select your pages/posts you are bulk editing, then select from the Bulk Edit dropdown -> Edit, then click Apply. For detailed screenshots how, refer to [[Wordpress - Bulk Edit (Fundamental)]]

---

## Important: Meta Key Must Match

Everything below assumes:

- You already save a custom field using `update_post_meta()`
    
- You use **the same meta key everywhere**
    

Example:

```php
update_post_meta($post_id, 'priority', $value);
```

Then Bulk Edit must also use:

```php
$meta_key = 'priority';
```

If the meta key doesn’t match exactly, Bulk Edit will render but **nothing will save**.

If you’re using the “global constant + prefix type” convention (e.g., `META_KEY` and `n_` vs `s_`), then just swap:

```php
$meta_key     = META_KEY;
$column_label = COLUMN_LABEL;
```

…and keep the same meta key across your meta box, your column, sorting, and bulk edit.

---

## Minimal Working Example (Bulk Edit)

❗️If you want Quick Edit, refer to [[Quick Edit]]

Bulk Edit has one big gotcha:

**A blank input is ambiguous.**  

In Bulk Edit, blank could mean either:
- “don’t change anything”
- “set to blank / delete the meta”

So the example below uses a tiny “Action” dropdown to make intent explicit:
- **No change**
- **Set value**
- **Remove meta**

![[Pasted image 20251217011311.png]]

### The code

```php
add_action('init', function () {
    $meta_key     = 'priority';
    $column_label = 'Priority';

    /**
     * 1) Render field in Bulk Edit
     */
    add_action('bulk_edit_custom_box', function ($column_name, $post_type) use ($meta_key, $column_label) {
        if ($column_name !== $meta_key) return;
        if (!in_array($post_type, ['post', 'page'], true)) return;

        // Bulk edit uses the core _wpnonce (bulk-posts / bulk-pages), but adding your own is fine too.
        wp_nonce_field('save_bulkedit_' . $meta_key, 'nonce_bulkedit_' . $meta_key);
        ?>
        <fieldset class="inline-edit-col-left">
          <div class="inline-edit-col">
            <label class="alignleft">
              <span class="title"><?php echo esc_html($column_label); ?> Action</span>
              <select name="<?php echo esc_attr($meta_key); ?>__action">
                <option value="">— No change —</option>
                <option value="set">Set value</option>
                <option value="remove">Remove meta</option>
              </select>
            </label>

            <label class="alignleft" style="margin-left:12px;">
              <span class="title"><?php echo esc_html($column_label); ?> Value</span>
              <span class="input-text-wrap">
                <input type="text" name="<?php echo esc_attr($meta_key); ?>__value" value="" />
              </span>
            </label>

            <p class="description" style="clear:both;">
              Choose <strong>Set value</strong> to apply the value to all selected items, or <strong>Remove meta</strong> to delete it.
            </p>
          </div>
        </fieldset>
        <?php
    }, 10, 2);

    /**
     * 2) (Optional) Small UI polish: disable Value unless Action = "set"
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

          function sync(){
            var action = $('select[name=\"' + metaKey + '__action\"]').val();
            var \$val = $('input[name=\"' + metaKey + '__value\"]');
            \$val.prop('disabled', action !== 'set');
            if (action !== 'set') \$val.val('');
          }

          $(document).on('change', 'select[name=\"' + metaKey + '__action\"]', sync);

          // When bulk edit opens, sync once
          $(document).on('click', '#doaction, #doaction2', function(){
            setTimeout(sync, 0);
          });

          sync();
        });
        ");
    });

    /**
     * 3) Save Bulk Edit changes (runs once per post updated)
     *
     * Key points:
     * - Bulk Edit submits via core bulk action and triggers save_post for each post.
     * - Use $_REQUEST (commonly more reliable here than $_POST).
     * - Verify core bulk nonce: 'bulk-posts' OR 'bulk-pages'.
     */
    add_action('save_post', function ($post_id) use ($meta_key) {
        if (!is_admin()) return;

        $post_type = get_post_type($post_id);
        if (!in_array($post_type, ['post', 'page'], true)) return;

        // 1) Only proceed if this looks like Bulk Edit submission for our field
        $action_key = $meta_key . '__action';
        $value_key  = $meta_key . '__value';

        if (!isset($_REQUEST[$action_key])) return;

        // 2) Core bulk nonce check (posts vs pages)
        $core_nonce = $_REQUEST['_wpnonce'] ?? '';
        $is_posts_nonce = wp_verify_nonce($core_nonce, 'bulk-posts');
        $is_pages_nonce = wp_verify_nonce($core_nonce, 'bulk-pages');

        if (!$is_posts_nonce && !$is_pages_nonce) return;

        // 3) Your own nonce (optional extra gate)
        $nonce = $_REQUEST['nonce_bulkedit_' . $meta_key] ?? null;
        if (!$nonce || !wp_verify_nonce($nonce, 'save_bulkedit_' . $meta_key)) return;

        // 4) Permissions
        if (!current_user_can('edit_post', $post_id)) return;

        $action = (string) $_REQUEST[$action_key];

        // No change means do nothing
        if ($action === '') return;

        // Remove means delete
        if ($action === 'remove') {
            delete_post_meta($post_id, $meta_key);
            return;
        }

        // Set means update (blank => delete to match your Quick Edit behavior)
        if ($action === 'set') {
            $raw = trim((string) ($_REQUEST[$value_key] ?? ''));

            if ($raw === '') {
                delete_post_meta($post_id, $meta_key);
                return;
            }

            // Save (sanitize as text; swap to intval()/floatval() for numeric)
            update_post_meta($post_id, $meta_key, sanitize_text_field($raw));
        }
    });
});
```

---

## Explanation

### 1) Render the Bulk Edit Field (`bulk_edit_custom_box`)

Bulk Edit UI is injected with:

```php
add_action('bulk_edit_custom_box', function ($column_name, $post_type) { ... }, 10, 2);
```

- Fires when WP renders the Bulk Edit panel.
    
- You only render when:
    
    - the current column matches your column key (`priority`)
        
    - the post type is `post` or `page`
        

Unlike Quick Edit, Bulk Edit does **not** provide a post ID or a “current value” to prefill (it’s many posts at once). ([WordPress Developer Resources](https://developer.wordpress.org/reference/hooks/bulk_edit_custom_box/?utm_source=chatgpt.com "bulk_edit_custom_box – Hook | Developer.WordPress.org"))

### 2) Why we use an “Action” dropdown

Bulk Edit needs a way to express intent:

- **No change** → don’t touch existing meta
    
- **Set value** → overwrite meta for all selected items
    
- **Remove meta** → delete meta for all selected items
    

Without that dropdown, an empty text field can’t tell “no change” vs “delete”.

### 3) Saving: `save_post` + bulk nonce

Bulk Edit ultimately triggers `save_post` once per post being updated, so we save there (same pattern WordPress docs point you toward). ([WordPress Developer Resources](https://developer.wordpress.org/reference/hooks/bulk_edit_custom_box/?utm_source=chatgpt.com "bulk_edit_custom_box – Hook | Developer.WordPress.org"))

Key details:
- Bulk edit commonly needs `$_REQUEST` (not just `$_POST`). ([Misha Rudrastyh](https://rudrastyh.com/wordpress/bulk-edit.html "Add Custom Fields to Bulk Edit in WordPress"))
- Core bulk edit uses different nonce actions:
    - Posts: `bulk-posts`
    - Pages: `bulk-pages` ([Misha Rudrastyh](https://rudrastyh.com/wordpress/bulk-edit.html "Add Custom Fields to Bulk Edit in WordPress"))
- We verify either, so the same code works for Posts and Pages.
