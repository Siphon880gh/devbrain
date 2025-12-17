## Add a Sortable Column in WordPress Admin (Plugin or Code)

WordPress supports **custom fields (post meta)** on posts and pages, but it does not display that data in the admin list tables by default. If you want to **view** and **sort** metadata in the **Posts** or **Pages** lists, you can use either a plugin or custom code.

This guide is flexible by design:
- **Non-filtering sort (default below):** keeps **all** posts/pages visible (even items with no meta value) using a **LEFT JOIN + custom ORDER BY**.
- **Filtering sort (optional):** uses **normal WordPress meta sorting**, which typically **filters out** items that don’t have that meta key when you click the column header.

This article covers:
- Plugins that add custom, sortable admin columns
- How columns differ between **Posts vs Pages**
- A minimal **custom code solution** for both
- A brief note on **editing the metadata**

---

## Posts vs Pages (Important Distinction)

In the WordPress admin:
- **Posts list:** `edit.php`
- **Pages list:** `edit.php?post_type=page`

These are **separate list tables**. Columns are configured **per post type**, meaning:
- Posts and Pages can have different columns
- Each Custom Post Type (CPT) can have its own setup
- Plugins and custom code both respect this separation

This is why good admin-column tools feel powerful: they don’t treat “content” as one big table.

---

## Best Plugins for Custom, Sortable Columns

### ✅ Admin Columns (Free + Pro)

**Best overall solution** if you want minimal code.

- Add custom columns per post type (Posts, Pages, CPTs)
- Display post meta by key
- Click-to-sort columns

**Free**
- Custom meta columns
- Sorting support
- Separate configs for Posts vs Pages

**Pro**
- Inline editing (Quick Edit / Bulk Edit)
- Filters
- Saved views
- ACF / Meta Box / WooCommerce integrations
- CSV export

---

### 🆓 Codepress Admin Columns (Free)

A lighter, free-only option.

- Add columns per post type
- Display and sort basic meta values
- No inline editing or advanced filtering

---

### ⚙️ Lightweight Admin Column Plugins (WPListTable-based)

- Add meta columns
- Sorting and filtering
- Less polished UI and fewer integrations

---

## Custom Code Approach (Posts **and** Pages)

Below is a minimal, production-safe example that:
- Adds a column to **Posts**
- Adds a column to **Pages**
- Displays a meta value
- Makes it sortable — **either** non-filtering (default) **or** filtering (optional)

---

### A Scalable Convention (Important)

Instead of hardcoding a meta key everywhere, we use **one configurable key** and infer sorting behavior from its name:
- `n_priority` → numeric sorting
- `s_priority` → string (alphabetical) sorting
- `priority` → defaults to string sorting

This keeps the code maintainable and avoids editing the same value in multiple places.

---

### Configuration (Change in One Place)

```php
const META_KEY     = 'n_priority'; // n_ = numeric, s_ = string, no prefix = string
const COLUMN_LABEL = 'Priority';
```

---

### 1. Add Columns

```php
// Posts
add_filter('manage_posts_columns', function ($columns) {
    $columns[META_KEY] = COLUMN_LABEL;
    return $columns;
});

// Pages
add_filter('manage_pages_columns', function ($columns) {
    $columns[META_KEY] = COLUMN_LABEL;
    return $columns;
});
```

---

### 2. Populate Column Values
- We are populating the values at the page or post list. By default the column gets added, but we need more code to have the values fill into the custom column:
```php
add_action('manage_posts_custom_column', function ($column, $post_id) {
    if ($column === META_KEY) {
        echo esc_html(get_post_meta($post_id, META_KEY, true));
    }
}, 10, 2);

add_action('manage_pages_custom_column', function ($column, $post_id) {
    if ($column === META_KEY) {
        echo esc_html(get_post_meta($post_id, META_KEY, true));
    }
}, 10, 2);
```

---

### 3. Make Columns Sortable

We use a **stable sort token** so we can choose how sorting behaves.

```php
add_filter('manage_edit-post_sortable_columns', function ($columns) {
    $columns[META_KEY] = 'meta_sort';
    return $columns;
});

add_filter('manage_edit-page_sortable_columns', function ($columns) {
    $columns[META_KEY] = 'meta_sort';
    return $columns;
});
```

---

## Option A: Non-Filtering Sort (Keeps All Rows)

This is the default approach below:
- Runs **only when clicking the column header**
- Uses a **LEFT JOIN** so items without the meta value still appear
- Sorts numerically or alphabetically based on the meta key prefix

![[Pasted image 20251217000054.png]]

### 4A. Apply Sorting Logic (Non-Filtering)

```php
add_action('pre_get_posts', function ($query) {
    if (!is_admin() || !$query->is_main_query()) return;
    if ($query->get('orderby') !== 'meta_sort') return;

    // Prevent WP default sorting because it exclude rows that don't have the custom value
    $query->set('meta_key', '');
    $query->set('meta_query', []);
});
```

```php
add_filter('posts_join', function ($join, $query) {
    if ($query->get('orderby') !== 'meta_sort') return $join;

    global $wpdb;
    return $join . $wpdb->prepare(
        " LEFT JOIN {$wpdb->postmeta} m
          ON ({$wpdb->posts}.ID = m.post_id AND m.meta_key = %s) ",
        META_KEY
    );
}, 10, 2);
```

```php
add_filter('posts_orderby', function ($orderby, $query) {
    if ($query->get('orderby') !== 'meta_sort') return $orderby;

    global $wpdb;
    $order = strtoupper($query->get('order')) === 'ASC' ? 'ASC' : 'DESC';

    if (str_starts_with(META_KEY, 'n_')) {
        return " (m.meta_value IS NULL) ASC,
                 CAST(m.meta_value AS UNSIGNED) {$order},
                 {$wpdb->posts}.ID {$order} ";
    }

    // Default: string / alphabetical
    return " (m.meta_value IS NULL) ASC,
             m.meta_value {$order},
             {$wpdb->posts}.ID {$order} ";
}, 10, 2);
```

---

## Option B: Filtering Sort (Uses Normal WordPress Meta Sorting)

If you want clicking the sortable column header to **filter out items that don’t have the meta key**, in addition to sorting that column, use WordPress’ normal meta sorting. This is the normal behavior.

![[Pasted image 20251217000216.png]]

To do that:
- **Remove the non-filtering hooks**: `posts_join` and `posts_orderby`
- Use only `pre_get_posts` to instruct WordPress how to sort the meta values

### 4B. Apply Sorting Logic (Filtering)
- We are removing:
  ``
    // Prevent WP default sorting because it exclude rows that don't have the custom value
    $query->set('meta_key', '');
    $query->set('meta_query', []);
```php
add_action('pre_get_posts', function ($query) {
    if (!is_admin() || !$query->is_main_query()) return;
    if ($query->get('orderby') !== 'meta_sort') return;

    // ✅ Tell WP what this column means
    $query->set('meta_key', META_KEY); // <-- your actual meta key

    // Numeric vs string sorting based on prefix
    if (str_starts_with(META_KEY, 'n_')) {
        $query->set('orderby', 'meta_value_num'); // numeric sort
        // $query->set('meta_type', 'NUMERIC');   // optional
    } else {
        $query->set('orderby', 'meta_value');     // alphabetical sort
        // $query->set('meta_type', 'CHAR');      // optional
    }

    // Respect click direction (defaults to ASC if empty)
    $query->set('order', $query->get('order') ?: 'ASC');
});
```

^ Note we dont have `// Prevent WP default sorting because it exclude rows that don't have the custom value...` code block like the other option

---

## Editing the Metadata (Separate Concern)

The admin column is **read-only**. Editing the metadata happens on the **post/page edit screen** and is a separate concern.

Below is the **minimal custom meta box** for editing the same value.

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

add_action('save_post', function ($post_id) {
    $nonce = $_POST['nonce_' . META_KEY] ?? null;
    if (!$nonce || !wp_verify_nonce($nonce, 'save_' . META_KEY)) return;

    if (isset($_POST[META_KEY])) {
        update_post_meta($post_id, META_KEY, sanitize_text_field($_POST[META_KEY]));
    }
});
```

For more in-depth options in the custom metabox, refer to

---

## Quick Edit + Bulk Edit (Edit the Value Right From the List Table)

Aka inline editing

If you want to change the meta value **without opening the post/page editor**, you can add:

- **Quick Edit**: edit one row inline
- **Bulk Edit**: set the same value across multiple selected rows

This works great for “priority”, “rank”, “weight”, “order”, “label”, etc.

Refer to [[Quick Edit]]

---
## Summary

- Posts, Pages, and CPTs are **separate admin tables** (columns + sorting must be registered per post type)
    
- Plugins are fastest for most use cases (and often include inline editing, aka Quick Edit / Bulk Edit)
    
- Custom code gives full control (columns, sorting rules, and edit UX)
    
- You can choose sorting behavior:
    
    - **Non-filtering:** `LEFT JOIN` + custom `ORDER BY` (keeps all rows, even missing meta)
        
    - **Filtering:** WordPress meta sorting via `pre_get_posts` (typically hides rows missing the meta key)
        
- A simple `n_` / `s_` prefix convention keeps the code scalable (numeric vs alphabetical sorting without duplicating logic)
    
- Editing is a separate concern from sorting, but you have options:
    
    - **Edit screen:** meta box (`add_meta_boxes` + `save_post`)
        
    - **Quick Edit + Bulk Edit:** add inline fields