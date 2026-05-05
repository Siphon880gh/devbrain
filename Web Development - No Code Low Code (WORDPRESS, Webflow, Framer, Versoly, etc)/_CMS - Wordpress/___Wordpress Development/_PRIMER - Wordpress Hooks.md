
WordPress hooks are the foundation of WordPress development. They allow you to modify WordPress behavior without editing core files. This guide explains how hooks work, the difference between actions and filters, and provides practical examples you can use in your own WordPress projects.

## Where to Add This Code

All the code examples in this guide need to be placed in a PHP file that WordPress loads. Here's where to add them:
### For Child Themes

**Add all code to your child theme's `functions.php` file.**

Location: `wp-content/themes/your-child-theme-name/functions.php`

```php

<?php

// Your child theme's functions.php

// Add your hooks here

add_action( 'wp_enqueue_scripts', function() {

wp_enqueue_style( 'my-style', get_stylesheet_uri() );

});

```

**Why `functions.php`?** This file is automatically loaded by WordPress when your theme is active, making it the perfect place for customizations.

### For Plugins

**Add code to any PHP file in your plugin folder.**

Location: `wp-content/plugins/your-plugin-name/your-file.php`

You can create a new file or add to an existing one. Common plugin files include:

- `your-plugin.php` (main plugin file)

- `includes/functions.php`

- `includes/hooks.php`

```php

<?php

// Your plugin file

// Add your hooks here

add_action( 'wp_enqueue_scripts', function() {

wp_enqueue_style( 'my-style', plugin_dir_url( __FILE__ ) . 'style.css' );

});

```

**Important:** Make sure your plugin file has the proper plugin header if it's the main file, or is included/required by your main plugin file.

### For Custom Functionality Plugins

If you're not using a child theme, you can create a "must-use" plugin or a simple functionality plugin:

1. Create a new file: `wp-content/plugins/my-custom-code.php`

2. Add the plugin header:

```php

<?php

/**

* Plugin Name: My Custom Code

* Description: Custom hooks and functionality

* Version: 1.0

*/

```

3. Add your hooks below the header

**Note:** Never add custom code directly to your parent theme's `functions.php` - it will be lost when the theme updates!

## Table of Contents

- [Understanding WordPress Hooks](#understanding-wordpress-hooks)

- [Admin vs Frontend: Where Your Code Runs](#admin-vs-frontend-where-your-code-runs)

- [WordPress Actions](#wordpress-actions)

- [WordPress Filters](#wordpress-filters)

- [WordPress Functions & Methods](#wordpress-functions--methods)

- [How Hooks Work Together](#how-hooks-work-together)

- [Key Concepts for Beginners](#key-concepts-for-beginners)

- [Common Patterns](#common-patterns)

---

## Understanding WordPress Hooks

WordPress uses a **hook system** that lets you "hook into" WordPress at specific points to modify behavior without editing core files. Think of hooks as designated spots where you can insert your own code.

### Two Types of Hooks

1. **Actions** - Do something at a specific time

- Example: Load a stylesheet when WordPress is ready to load scripts

- Use: `add_action( 'hook_name', 'your_function' )`

2. **Filters** - Modify data before it's used

- Example: Change how a script tag is rendered in HTML

- Use: `add_filter( 'hook_name', 'your_function' )`

### Hook Priority

Hooks can have a **priority** number (default is 10). Lower numbers run first, higher numbers run later.

```php

add_action( 'wp_enqueue_scripts', 'my_function', 120 ); // Runs at priority 120 (late)

add_action( 'wp_enqueue_scripts', 'my_function', 9999 ); // Runs at priority 9999 (very late)

```

### The Key Difference

**Actions** perform tasks and don't return values. **Filters** modify data and must return the modified value.

```php

// Action - does something, no return needed

add_action( 'wp_enqueue_scripts', function() {

wp_enqueue_style( 'my-style', 'style.css' );

});

// Filter - modifies data, must return value

add_filter( 'the_title', function( $title ) {

return 'Prefix: ' . $title;

});

```

---

## Admin vs Frontend: Where Your Code Runs

WordPress has two distinct areas: the **admin dashboard** (backend) and the **public website** (frontend). Understanding where your code runs is crucial because:

- **Frontend hooks** affect your website visitors

- **Admin hooks** affect the WordPress dashboard

- Some hooks work in both areas

- Performance optimizations usually only apply to the frontend

### Detecting Admin vs Frontend

Use `is_admin()` to check if you're in the WordPress admin area:

```php

if ( is_admin() ) {

// Code runs only in admin dashboard

} else {

// Code runs only on frontend (your website)

}

```

**Returns:**

- `true` - Current page is in WordPress admin area

- `false` - Current page is on the frontend (your website)

### Frontend-Only Code

Most performance optimizations and frontend customizations should only run on the frontend:

```php

add_action( 'wp_enqueue_scripts', function() {

// Don't run in admin - performance optimizations aren't needed there

if ( is_admin() ) {

return;

}

// Frontend-only code

wp_dequeue_style( 'unwanted-plugin-style' );

wp_enqueue_style( 'my-frontend-style', get_stylesheet_uri() );

});

```

**Why check?** Admin area doesn't need performance optimizations, and modifying admin scripts can break the dashboard functionality.

### Admin-Only Code

For customizing the WordPress dashboard, use admin-specific hooks or check for admin:

```php

// Method 1: Use admin-specific hook

add_action( 'admin_enqueue_scripts', function() {

// This only runs in admin

wp_enqueue_style( 'my-admin-style', get_stylesheet_directory_uri() . '/admin.css' );

});

// Method 2: Check is_admin() in a general hook

add_action( 'wp_enqueue_scripts', function() {

if ( is_admin() ) {

// Admin-only code

wp_enqueue_style( 'my-admin-style', get_stylesheet_directory_uri() . '/admin.css' );

}

});

```

### Frontend-Specific Hooks

These hooks **only fire on the frontend** (your website):

- `wp_enqueue_scripts` - Load frontend CSS/JS

- `wp_head` - Frontend `<head>` section

- `wp_footer` - Frontend footer

- `the_content` - Filter post content (frontend display)

**Example:**

```php

// This only runs on frontend - no need to check is_admin()

add_action( 'wp_enqueue_scripts', function() {

wp_enqueue_style( 'frontend-style', get_stylesheet_uri() );

});

```

### Admin-Specific Hooks

These hooks **only fire in the admin dashboard**:

- `admin_enqueue_scripts` - Load admin CSS/JS

- `admin_head` - Admin `<head>` section

- `admin_footer` - Admin footer

- `admin_menu` - Modify admin menu

- `admin_init` - Admin initialization

**Example:**

```php

// This only runs in admin - no need to check is_admin()

add_action( 'admin_enqueue_scripts', function() {

wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri() . '/admin.css' );

});

```

### Hooks That Work in Both Areas

Some hooks fire in both admin and frontend:

- `init` - WordPress initialization (both areas)

- `wp_loaded` - After WordPress is fully loaded (both areas)

**Example with conditional logic:**

```php

add_action( 'init', function() {

if ( is_admin() ) {

// Admin-specific code

add_action( 'admin_menu', 'my_admin_menu_function' );

} else {

// Frontend-specific code

add_action( 'wp_head', 'my_frontend_head_function' );

}

});

```

### Common Patterns

**Pattern 1: Frontend-only performance optimization**

```php

add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {

// Never modify admin scripts

if ( is_admin() ) {

return $tag;

}

// Frontend optimization: add defer attribute

$tag = str_replace( ' src', ' defer src', $tag );

return $tag;

}, 10, 3 );

```

**Pattern 2: Different behavior for admin vs frontend**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_admin() ) {

// Admin: Load admin-specific styles

wp_enqueue_style( 'admin-custom', get_stylesheet_directory_uri() . '/admin.css' );

} else {

// Frontend: Load frontend styles and optimize

wp_enqueue_style( 'frontend-style', get_stylesheet_uri() );

wp_dequeue_style( 'unwanted-style' );

}

});

```

**Pattern 3: Admin dashboard customization**

```php

// Add custom CSS to admin dashboard

add_action( 'admin_head', function() {

?>

<style>

.wp-admin .my-custom-class {

background: #f0f0f0;

}

</style>

<?php

});

// Add custom JavaScript to admin

add_action( 'admin_enqueue_scripts', function() {

wp_enqueue_script( 'my-admin-script', get_stylesheet_directory_uri() . '/admin.js' );

});

```

**Pattern 4: Frontend website customization**

```php

// Add custom CSS to frontend

add_action( 'wp_head', function() {

?>

<style>

.my-frontend-class {

color: #333;

}

</style>

<?php

});

// Add custom JavaScript to frontend

add_action( 'wp_enqueue_scripts', function() {

if ( ! is_admin() ) {

wp_enqueue_script( 'my-frontend-script', get_stylesheet_directory_uri() . '/frontend.js' );

}

});

```

### When to Use Each Approach

**Use `is_admin()` check when:**

- You're using a hook that fires in both areas (like `init`)

- You want to prevent frontend code from running in admin

- You want to prevent admin code from running on frontend

**Use admin-specific hooks when:**

- You're only customizing the admin dashboard

- You want cleaner, more semantic code

- You're sure the hook only needs to run in admin

**Use frontend-specific hooks when:**

- You're only customizing the public website

- You're doing performance optimizations

- You're modifying visitor-facing content

### Quick Reference

| Hook | Runs In | Use For |

|------|---------|---------|

| `wp_enqueue_scripts` | Frontend only | Frontend CSS/JS |

| `admin_enqueue_scripts` | Admin only | Admin CSS/JS |

| `wp_head` | Frontend only | Frontend `<head>` content |

| `admin_head` | Admin only | Admin `<head>` content |

| `init` | Both | General initialization |

| `wp_loaded` | Both | After WordPress loads |

**Best Practice:** Always check `is_admin()` when using hooks that fire in both areas, or use the specific hook for the area you're targeting.

---

## WordPress Actions

Actions are hooks that fire at specific points during WordPress execution. They allow you to execute code at those moments.

### `wp_enqueue_scripts`

**What it does:** Fires when WordPress is ready to load CSS and JavaScript files on the frontend.

**When it runs:** Before `<head>` section is output, but after WordPress core has loaded.

**Common use cases:**

- Enqueue your theme's stylesheets and scripts

- Remove unwanted assets loaded by plugins

- Add custom JavaScript files

**Basic example:**

```php

add_action( 'wp_enqueue_scripts', function() {

wp_enqueue_style( 'my-theme-style', get_stylesheet_uri() );

wp_enqueue_script( 'my-theme-script', get_stylesheet_directory_uri() . '/js/script.js' );

});

```

**Advanced example with priority:**

```php

// Early priority - enqueue your styles

add_action( 'wp_enqueue_scripts', function() {

wp_enqueue_style( 'child-theme-style', get_stylesheet_uri() );

}, 10 );

// Late priority - remove unwanted assets

add_action( 'wp_enqueue_scripts', function() {

wp_dequeue_style( 'unwanted-plugin-style' );

}, 120 );

// Very late priority - catch assets loaded after your code

add_action( 'wp_enqueue_scripts', function() {

wp_dequeue_style( 'late-loading-style' );

}, 9999 );

```

**Why multiple priorities?** Different priorities let you run code at different stages:

- Priority 10 (default): Early - enqueue your styles

- Priority 120: Middle - remove unwanted assets

- Priority 9999: Very late - catch assets that were enqueued after your earlier code

---

### `wp_head`

**What it does:** Fires in the `<head>` section of the HTML document.

**When it runs:** When WordPress outputs the `<head>` tag.

**Common use cases:**

- Add meta tags

- Insert inline CSS

- Add tracking codes

- Add preconnect/dns-prefetch links

**Example:**

```php

add_action( 'wp_head', function() {

?>

<style>

@font-face {

font-family: 'Custom Font';

font-display: swap;

}

</style>

<?php

}, 2 );

```

**Priority 2:** Runs early in `<head>` so the CSS is available immediately.

**Another example - adding meta tags:**

```php

add_action( 'wp_head', function() {

echo '<meta name="author" content="Your Name">' . "\n";

echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";

});

```

---

### `elementor/frontend/after_enqueue_styles`

**What it does:** Custom Elementor hook that fires after Elementor has finished loading its frontend styles.

**When it runs:** After Elementor's styles are enqueued.

**Why needed?** Some plugins enqueue styles very late. This hook catches Elementor-specific styles that load after the main `wp_enqueue_scripts` hook.

**Example:**

```php

add_action( 'elementor/frontend/after_enqueue_styles', function() {

wp_dequeue_style( 'elementor-plugin-style' );

}, 9999 );

```

**Note:** This is a plugin-specific hook. Different plugins have their own custom hooks. Check plugin documentation for available hooks.

---

## WordPress Filters

Filters are hooks that allow you to modify data before it's used. Unlike actions, filters **must return a value**. Filters receive data, you modify it, and return the modified version.

### Understanding How Filters Work

Think of a filter as a data transformation pipeline:

1. WordPress has some data (e.g., a stylesheet HTML tag)

2. WordPress passes it through your filter function

3. Your function modifies the data

4. Your function returns the modified data

5. WordPress uses the modified data

**Critical rule:** Filters MUST return a value. If you don't return, WordPress will use `null` or the original value, which can break functionality.

```php

// ✅ Correct - returns modified value

add_filter( 'style_loader_tag', function( $html ) {

$html = str_replace( 'media="all"', 'media="print"', $html );

return $html; // Must return!

});

// ❌ Wrong - no return value

add_filter( 'style_loader_tag', function( $html ) {

$html = str_replace( 'media="all"', 'media="print"', $html );

// Missing return - WordPress won't see your changes!

});

```

---

### `wp_resource_hints`

**What it does:** Allows you to add resource hints (like preconnect, dns-prefetch) to the `<head>` section.

**When it runs:** When WordPress generates resource hint tags.

**What are resource hints?** They tell the browser to establish early connections to external domains, reducing load time. Common types:

- `preconnect` - Establish early connection (DNS, TCP, TLS)

- `dns-prefetch` - Resolve DNS early

- `prefetch` - Prefetch resources

**Basic example:**

```php

add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {

if ( 'preconnect' === $relation_type ) {

$urls[] = 'https://fonts.googleapis.com';

$urls[] = [

'href' => 'https://fonts.gstatic.com',

'crossorigin' => 'anonymous',

];

}

return $urls;

}, 10, 2 );

```

**Parameters:**

- `$urls` - Array of existing resource hints

- `$relation_type` - Type of hint ('preconnect', 'dns-prefetch', etc.)

**Returns:** Modified array of URLs

**Why preconnect?** Tells the browser to establish early connections to Google Fonts servers, reducing load time by eliminating DNS lookup and TLS handshake delays.

**More examples:**

```php

// Add DNS prefetch for CDN

add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {

if ( 'dns-prefetch' === $relation_type ) {

$urls[] = 'https://cdn.example.com';

}

return $urls;

}, 10, 2 );

// Add multiple preconnects

add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {

if ( 'preconnect' === $relation_type ) {

$urls[] = 'https://api.example.com';

$urls[] = 'https://static.example.com';

}

return $urls;

}, 10, 2 );

```

---

### `style_loader_tag`

**What it does:** Filters the HTML tag for enqueued stylesheets before it's output to the page.

**When it runs:** For each stylesheet that's being enqueued.

**What you receive:** The complete `<link>` tag HTML as a string.

**What you can do:**

- Modify attributes (add `media`, `onload`, etc.)

- Change the URL

- Block stylesheets from loading (return empty string)

- Add custom attributes

**Basic example - adding an attribute:**

```php

add_filter( 'style_loader_tag', function( $html, $handle, $href ) {

// Add data attribute to specific stylesheet

if ( 'my-custom-style' === $handle ) {

$html = str_replace( '<link ', '<link data-custom="true" ', $html );

}

return $html;

}, 10, 3 );

```

**Parameters:**

- `$html` - The complete `<link>` tag HTML

- `$handle` - The stylesheet handle (name)

- `$href` - The stylesheet URL

- `$media` - The media attribute (4th parameter in some cases)

**Returns:** Modified HTML string (or empty string to block)

**Advanced example - blocking specific fonts:**

```php

add_filter( 'style_loader_tag', function( $html, $handle, $href ) {

// Block Roboto font from loading

if ( strpos( $href, 'roboto' ) !== false ) {

return ''; // Empty string = don't load this stylesheet

}

return $html;

}, 4, 3 );

```

**Advanced example - adding font-display swap to Google Fonts:**

```php

add_filter( 'style_loader_tag', function( $html, $handle, $href ) {

// Check if this is a Google Fonts stylesheet

if ( strpos( $href, 'fonts.googleapis.com' ) !== false ) {

// Add display=swap parameter if not already present

if ( strpos( $href, 'display=' ) === false ) {

$separator = strpos( $href, '?' ) !== false ? '&' : '?';

$html = str_replace( $href, $href . $separator . 'display=swap', $html );

}

}

return $html;

}, 5, 3 );

```

**Advanced example - loading CSS asynchronously:**

```php

add_filter( 'style_loader_tag', function( $html, $handle, $href, $media ) {

// Only defer non-critical styles

$non_critical = ['animation', 'wpforms', 'social-icons'];

foreach ( $non_critical as $pattern ) {

if ( strpos( $handle, $pattern ) !== false ) {

// Use media="print" trick to load asynchronously

if ( $media === 'all' || $media === '' ) {

$html = str_replace(

"media='all'",

"media='print' onload=\"this.media='all'\"",

$html

);

}

break;

}

}

return $html;

}, 10, 4 );

```

**Priority matters with multiple filters:**

```php

// Priority 4: Block Roboto (runs first)

add_filter( 'style_loader_tag', function( $html, $handle, $href ) {

if ( strpos( $href, 'roboto' ) !== false ) {

return ''; // Block it

}

return $html;

}, 4, 3 );

// Priority 5: Add font-display=swap (runs after blocking)

add_filter( 'style_loader_tag', function( $html, $handle, $href ) {

if ( strpos( $href, 'fonts.googleapis.com' ) !== false ) {

// Modify $html

}

return $html;

}, 5, 3 );

// Priority 10: Async loading (runs last)

add_filter( 'style_loader_tag', function( $html, $handle, $href ) {

// Modify $html for async loading

return $html;

}, 10, 3 );

```

---

### `script_loader_tag`

**What it does:** Filters the HTML tag for enqueued scripts before it's output to the page.

**When it runs:** For each script that's being enqueued.

**What you receive:** The complete `<script>` tag HTML as a string.

**What you can do:**

- Add `defer` or `async` attributes

- Change the URL

- Block scripts from loading (return empty string)

- Add custom attributes

**Basic example - adding defer attribute:**

```php

add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {

// Add defer to non-critical scripts

if ( 'my-non-critical-script' === $handle ) {

$tag = str_replace( ' src', ' defer src', $tag );

}

return $tag;

}, 10, 3 );

```

**Parameters:**

- `$tag` - The complete `<script>` tag HTML

- `$handle` - The script handle (name)

- `$src` - The script URL

**Returns:** Modified HTML string (or empty string to block)

**What defer does:** Tells browser to download script in parallel but execute it after HTML parsing is complete. This improves page load performance.

**Advanced example - deferring non-critical scripts:**

```php

add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {

// Don't modify admin scripts

if ( is_admin() ) {

return $tag;

}

// Critical scripts that must load synchronously

$critical = ['jquery', 'jquery-core', 'elementor-frontend'];

foreach ( $critical as $critical_handle ) {

if ( strpos( $handle, $critical_handle ) === 0 ) {

return $tag; // Don't modify critical scripts

}

}

// Don't modify scripts that already have async or defer

if ( strpos( $tag, 'async' ) !== false || strpos( $tag, 'defer' ) !== false ) {

return $tag;

}

// Defer all other scripts

$tag = str_replace( ' src', ' defer src', $tag );

return $tag;

}, 10, 3 );

```

**Advanced example - blocking scripts by URL:**

```php

add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {

// Block scripts from specific paths

$blocked_paths = ['/unwanted-plugin/', '/analytics-old/'];

foreach ( $blocked_paths as $path ) {

if ( strpos( $src, $path ) !== false ) {

return ''; // Block this script

}

}

return $tag;

}, 10, 3 );

```

**Understanding defer vs async:**

- `defer` - Download in parallel, execute after HTML parsing (maintains order)

- `async` - Download in parallel, execute immediately when ready (order not guaranteed)

```php

// Defer - maintains execution order

$tag = str_replace( ' src', ' defer src', $tag );

// Async - executes when ready (faster but order not guaranteed)

$tag = str_replace( ' src', ' async src', $tag );

```

---

## WordPress Functions & Methods

### Enqueue Functions

#### `wp_enqueue_style()`

**What it does:** Tells WordPress to load a CSS file.

**Syntax:**

```php

wp_enqueue_style( $handle, $src, $deps, $version, $media );

```

**Parameters:**

- `$handle` - Unique name for the stylesheet (required)

- `$src` - URL to the stylesheet file (required)

- `$deps` - Array of handles this stylesheet depends on (optional)

- `$version` - Version number for cache busting (optional)

- `$media` - Media type (e.g., 'all', 'print') (optional)

**Basic example:**

```php

wp_enqueue_style( 'my-style', get_stylesheet_directory_uri() . '/style.css' );

```

**Advanced example with dependencies:**

```php

wp_enqueue_style(

'child-theme-style', // Handle

get_stylesheet_uri(), // URL to style.css

['parent-theme-style'], // Depends on parent theme

wp_get_theme()->get( 'Version' ), // Theme version for cache busting

'all' // Media type

);

```

**Why dependencies matter:** If your style depends on another stylesheet, WordPress will load the dependency first.

---

#### `wp_dequeue_style()`

**What it does:** Removes a stylesheet from the queue (prevents it from loading).

**Syntax:**

```php

wp_dequeue_style( $handle );

```

**Example:**

```php

wp_dequeue_style( 'font-awesome' ); // Prevents font-awesome.css from loading

```

**When to use:** When a plugin or theme loads a stylesheet you don't need.

---

#### `wp_deregister_style()`

**What it does:** Completely removes a stylesheet registration (more thorough than dequeue).

**Syntax:**

```php

wp_deregister_style( $handle );

```

**Why both?** `wp_dequeue_style()` removes it from current page, `wp_deregister_style()` prevents it from being re-enqueued elsewhere.

**Best practice - use both:**

```php

wp_dequeue_style( 'unwanted-style' );

wp_deregister_style( 'unwanted-style' );

```

---

#### `wp_dequeue_script()` and `wp_deregister_script()`

**What they do:** Same as style functions but for JavaScript files.

**Example:**

```php

wp_dequeue_script( 'unwanted-script' );

wp_deregister_script( 'unwanted-script' );

```

---

#### `wp_style_is()`

**What it does:** Checks if a stylesheet is enqueued, registered, or done.

**Syntax:**

```php

wp_style_is( $handle, $status );

```

**Parameters:**

- `$handle` - Stylesheet handle to check

- `$status` - Check type: 'enqueued', 'registered', or 'done'

**Example:**

```php

if ( wp_style_is( 'font-awesome', 'enqueued' ) ) {

wp_dequeue_style( 'font-awesome' );

}

```

**Use cases:**

- Check before dequeuing (avoid errors)

- Conditional logic based on what's loaded

- Debugging asset loading

---

### Theme Functions

#### `get_stylesheet_uri()`

**What it does:** Gets the URL to the active theme's `style.css` file.

**Returns:** Full URL string (e.g., `https://yoursite.com/wp-content/themes/theme-name/style.css`)

**Example:**

```php

$style_url = get_stylesheet_uri();

// Returns: https://yoursite.com/wp-content/themes/theme-name/style.css

```

---

#### `wp_get_theme()`

**What it does:** Gets the current theme object with all theme information.

**Returns:** WP_Theme object

**Common usage:**

```php

$version = wp_get_theme()->get( 'Version' ); // Get theme version

$name = wp_get_theme()->get( 'Name' ); // Get theme name

```

**Why use version?** For cache busting - when you update your theme, browsers will load the new CSS instead of cached version.

---

#### `get_stylesheet_directory_uri()`

**What it does:** Gets the URL to the active theme's directory.

**Returns:** Full URL string

**Example:**

```php

$js_url = get_stylesheet_directory_uri() . '/assets/js/script.js';

// Returns: https://yoursite.com/wp-content/themes/theme-name/assets/js/script.js

```

---

### Conditional Functions

WordPress provides many conditional functions to check what type of page is being viewed or what conditions are true. These are essential for running code only in specific contexts.

#### `is_admin()`

**What it does:** Checks if current page is in WordPress admin area.

**Returns:** `true` if in admin, `false` if on frontend

**Why use it?** Admin area doesn't need performance optimizations, and modifying admin scripts can break the dashboard.

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_admin() ) {

return; // Don't run on admin pages

}

// Your frontend-only code here

wp_dequeue_style( 'unwanted-style' );

});

```

---

#### `is_front_page()`

**What it does:** Checks if the current page is the front page (homepage) of the site.

**Returns:** `true` if viewing the homepage, `false` otherwise

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_front_page() ) {

// Load special homepage-only styles

wp_enqueue_style( 'homepage-style', get_stylesheet_directory_uri() . '/homepage.css' );

}

});

```

---

#### `is_home()`

**What it does:** Checks if the current page is the blog posts index page.

**Returns:** `true` if viewing the blog homepage, `false` otherwise

**Note:** Different from `is_front_page()`. `is_home()` is true for the blog posts page, while `is_front_page()` is true for the site's front page (which might be a static page).

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_home() ) {

// Load blog-specific styles

wp_enqueue_style( 'blog-style', get_stylesheet_directory_uri() . '/blog.css' );

}

});

```

---

#### `is_single()`

**What it does:** Checks if the current page is a single post.

**Returns:** `true` if viewing a single post, `false` otherwise

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_single() ) {

// Load single post styles

wp_enqueue_style( 'single-post-style', get_stylesheet_directory_uri() . '/single.css' );

}

});

```

**Check specific post type:**

```php

if ( is_single( 'product' ) ) {

// Only for 'product' post type

}

```

---

#### `is_page()`

**What it does:** Checks if the current page is a WordPress page (not a post).

**Returns:** `true` if viewing a page, `false` otherwise

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_page() ) {

// Load page-specific styles

wp_enqueue_style( 'page-style', get_stylesheet_directory_uri() . '/page.css' );

}

});

```

**Check specific page:**

```php

if ( is_page( 'about' ) ) {

// Only for 'about' page

}

if ( is_page( 42 ) ) {

// Only for page with ID 42

}

```

---

#### `is_archive()`

**What it does:** Checks if the current page is any type of archive (category, tag, date, author, etc.).

**Returns:** `true` if viewing an archive, `false` otherwise

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_archive() ) {

// Load archive styles

wp_enqueue_style( 'archive-style', get_stylesheet_directory_uri() . '/archive.css' );

}

});

```

---

#### `is_category()`

**What it does:** Checks if the current page is a category archive.

**Returns:** `true` if viewing a category archive, `false` otherwise

**Example:**

```php

if ( is_category() ) {

// Category archive page

}

// Check specific category

if ( is_category( 'news' ) ) {

// Only 'news' category

}

```

---

#### `is_tag()`

**What it does:** Checks if the current page is a tag archive.

**Returns:** `true` if viewing a tag archive, `false` otherwise

**Example:**

```php

if ( is_tag( 'featured' ) ) {

// Only 'featured' tag archive

}

```

---

#### `is_search()`

**What it does:** Checks if the current page is a search results page.

**Returns:** `true` if viewing search results, `false` otherwise

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_search() ) {

wp_enqueue_style( 'search-style', get_stylesheet_directory_uri() . '/search.css' );

}

});

```

---

#### `is_404()`

**What it does:** Checks if the current page is a 404 error page.

**Returns:** `true` if viewing 404 page, `false` otherwise

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_404() ) {

wp_enqueue_style( '404-style', get_stylesheet_directory_uri() . '/404.css' );

}

});

```

---

#### `is_user_logged_in()`

**What it does:** Checks if the current visitor is a logged-in user.

**Returns:** `true` if user is logged in, `false` otherwise

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_user_logged_in() ) {

// Load styles only for logged-in users

wp_enqueue_style( 'member-style', get_stylesheet_directory_uri() . '/member.css' );

}

});

```

---

#### `is_mobile()`

**What it does:** Checks if the current visitor is using a mobile device.

**Returns:** `true` if mobile device detected, `false` otherwise

**Note:** This function may not be available by default. You might need a plugin or custom detection.

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_mobile() ) {

// Load mobile-optimized styles

wp_enqueue_style( 'mobile-style', get_stylesheet_directory_uri() . '/mobile.css' );

}

});

```

**Alternative mobile detection:**

```php

function is_mobile_device() {

return wp_is_mobile();

}

```

---

#### `is_rtl()`

**What it does:** Checks if the site is using a right-to-left language (like Arabic or Hebrew).

**Returns:** `true` if RTL language, `false` otherwise

**Example:**

```php

add_action( 'wp_enqueue_scripts', function() {

if ( is_rtl() ) {

wp_enqueue_style( 'rtl-style', get_stylesheet_directory_uri() . '/rtl.css' );

}

});

```

---

#### `is_main_query()`

**What it does:** Checks if the current query is the main WordPress query (not a secondary query).

**Returns:** `true` if main query, `false` otherwise

**Use case:** Prevents code from running on secondary queries (like widgets, related posts, etc.).

**Example:**

```php

add_filter( 'the_content', function( $content ) {

// Only modify content in main query

if ( ! is_main_query() ) {

return $content;

}

// Modify main query content

return $content . '<p>Custom content</p>';

});

```

---

#### Combining Multiple Conditions

You can combine conditional functions with logical operators:

**AND (both must be true):**

```php

if ( is_single() && is_user_logged_in() ) {

// Single post AND user is logged in

}

```

**OR (either can be true):**

```php

if ( is_page() || is_single() ) {

// Page OR single post

}

```

**NOT (reverse the condition):**

```php

if ( ! is_admin() ) {

// NOT admin (frontend only)

}

```

**Complex example:**

```php

add_action( 'wp_enqueue_scripts', function() {

// Load on frontend, but not on homepage

if ( ! is_admin() && ! is_front_page() ) {

wp_enqueue_style( 'internal-pages-style', get_stylesheet_directory_uri() . '/internal.css' );

}

// Load on single posts OR category archives

if ( is_single() || is_category() ) {

wp_enqueue_style( 'content-style', get_stylesheet_directory_uri() . '/content.css' );

}

});

```

---

### Quick Reference: Common Conditional Functions

| Function | Checks For | Returns |

|---------|------------|---------|

| `is_admin()` | WordPress admin area | `true`/`false` |

| `is_front_page()` | Site homepage | `true`/`false` |

| `is_home()` | Blog posts index | `true`/`false` |

| `is_single()` | Single post | `true`/`false` |

| `is_page()` | WordPress page | `true`/`false` |

| `is_archive()` | Any archive page | `true`/`false` |

| `is_category()` | Category archive | `true`/`false` |

| `is_tag()` | Tag archive | `true`/`false` |

| `is_search()` | Search results | `true`/`false` |

| `is_404()` | 404 error page | `true`/`false` |

| `is_user_logged_in()` | Logged-in user | `true`/`false` |

| `is_mobile()` | Mobile device | `true`/`false` |

| `is_rtl()` | Right-to-left language | `true`/`false` |

| `is_main_query()` | Main WordPress query | `true`/`false` |

---

### PHP String Functions

#### `strpos()`

**What it does:** Finds the position of a substring within a string.

**Syntax:**

```php

strpos( $haystack, $needle );

```

**Returns:** Position number if found, `false` if not found

**Important:** Uses `!== false` because `strpos()` returns `0` if found at start (which is falsy), so we check for strict inequality.

**Example:**

```php

if ( strpos( $href, 'roboto' ) !== false ) {

// URL contains 'roboto'

}

```

**Common use cases:**

- Check if URL contains specific string

- Check if handle starts with prefix

- Pattern matching for asset management

---

#### `str_replace()`

**What it does:** Replaces occurrences of a string with another string.

**Syntax:**

```php

str_replace( $search, $replace, $subject );

```

**Example:**

```php

$tag = str_replace( ' src', ' defer src', $tag );

// Changes: <script src="...">

// To: <script defer src="...">

```

**Multiple replacements:**

```php

$html = str_replace(

['media="all"', "media='all'"],

['media="print"', "media='print'"],

$html

);

```

---

### Array Functions

#### `array_keys()`

**What it does:** Returns all the keys from an array.

**Example:**

```php

$handles = array_keys( $wp_scripts->registered );

// Returns: ['jquery', 'jquery-core', 'elementor-frontend', ...]

```

---

#### `implode()`

**What it does:** Joins array elements into a string.

**Syntax:**

```php

implode( $separator, $array );

```

**Example:**

```php

$handles_string = implode( ",", ['jquery', 'elementor-frontend'] );

// Returns: "jquery,elementor-frontend"

```

---

### Global Variables

#### `$wp_scripts` and `$wp_styles`

**What they are:** WordPress global objects containing all registered scripts and stylesheets.

**How to access:**

```php

global $wp_scripts, $wp_styles;

$all_scripts = $wp_scripts->registered;

$all_styles = $wp_styles->registered;

```

**Properties:**

- `$wp_scripts->registered` - Array of all registered scripts

- `$wp_styles->registered` - Array of all registered stylesheets

**Use case - logging all assets:**

```php

global $wp_scripts, $wp_styles;

error_log( 'Scripts: ' . implode( ',', array_keys( $wp_scripts->registered ) ) );

error_log( 'Styles: ' . implode( ',', array_keys( $wp_styles->registered ) ) );

```

---

### Debug Functions

#### `error_log()`

**What it does:** Writes a message to PHP error log.

**Syntax:**

```php

error_log( $message );

```

**Where to find logs:**

- Usually in `wp-content/debug.log` (if `WP_DEBUG_LOG` is enabled in `wp-config.php`)

**Example:**

```php

error_log( 'DEFERRED SCRIPT: ' . $handle );

```

**Enable debug logging in wp-config.php:**

```php

define( 'WP_DEBUG', true );

define( 'WP_DEBUG_LOG', true );

define( 'WP_DEBUG_DISPLAY', false );

```

---

## How Hooks Work Together

Here's the execution flow when a page loads:

1. **WordPress starts loading**

- Core WordPress files load

- Plugins and theme activate

2. **`wp_enqueue_scripts` fires (priority 10)**

- Child theme stylesheet is enqueued

- Other themes/plugins enqueue their assets

3. **`wp_enqueue_scripts` fires (priority 120)**

- Unwanted styles/scripts are removed

- Asset handles are logged if debug enabled

4. **`wp_enqueue_scripts` fires (priority 9999)**

- Late-loading assets are caught and removed

5. **`wp_head` fires (priority 2)**

- Inline CSS for font-display added

- Meta tags inserted

6. **`wp_resource_hints` filter runs**

- Preconnect hints added for external domains

7. **For each stylesheet: `style_loader_tag` filter runs**

- Priority 4: Block unwanted fonts

- Priority 5: Add font-display=swap

- Priority 10: Make non-critical CSS async

8. **For each script: `script_loader_tag` filter runs**

- Priority 10: Add defer to non-critical scripts

9. **Plugin-specific hooks fire**

- Elementor hooks, WooCommerce hooks, etc.

---

## Key Concepts for Beginners

### 1. Hook Priority Matters

Lower priority = runs earlier. Higher priority = runs later.

```php

add_action( 'wp_enqueue_scripts', 'function_a', 10 ); // Runs first

add_action( 'wp_enqueue_scripts', 'function_b', 120 ); // Runs later

add_action( 'wp_enqueue_scripts', 'function_c', 9999 ); // Runs last

```

### 2. Filters Must Return Values

Filters modify data, so you **must return** the modified value:

```php

add_filter( 'style_loader_tag', function( $html ) {

// Modify $html

return $html; // ← Must return!

});

```

### 3. Actions Don't Return Values

Actions just "do something" - they don't need to return anything:

```php

add_action( 'wp_enqueue_scripts', function() {

wp_enqueue_style( 'my-style', 'style.css' );

// No return needed

});

```

### 4. Anonymous Functions vs Named Functions

You can use either:

```php

// Anonymous function (inline)

add_action( 'wp_enqueue_scripts', function() {

// code

});

// Named function (reusable)

function my_enqueue_function() {

// code

}

add_action( 'wp_enqueue_scripts', 'my_enqueue_function' );

```

### 5. Global Variables

Access WordPress globals with `global` keyword:

```php

global $wp_scripts, $wp_styles;

$all_scripts = $wp_scripts->registered;

```

---

## Common Patterns

### Pattern 1: Conditional Execution

```php

if ( $enable_feature ) {

add_filter( 'wp_resource_hints', function() { /* ... */ } );

}

```

Only runs if the flag is enabled.

### Pattern 2: Early Return

```php

if ( is_admin() ) {

return; // Stop execution

}

```

Prevents code from running in admin area.

### Pattern 3: Loop Through Array

```php

foreach ( $kill_styles as $handle ) {

wp_dequeue_style( $handle );

wp_deregister_style( $handle );

}

```

Removes multiple assets efficiently.

### Pattern 4: String Matching

```php

if ( strpos( $handle, 'elementor-' ) !== false ) {

// Handle starts with 'elementor-'

}

```

Checks if handle contains a substring.

### Pattern 5: Check Before Modifying

```php

if ( wp_style_is( 'font-awesome', 'enqueued' ) ) {

wp_dequeue_style( 'font-awesome' );

}

```

Prevents errors by checking if asset exists first.

---

## Further Learning Resources

- [WordPress Plugin API: Actions](https://developer.wordpress.org/plugins/hooks/actions/)

- [WordPress Plugin API: Filters](https://developer.wordpress.org/plugins/hooks/filters/)

- [WordPress Codex: wp_enqueue_style()](https://developer.wordpress.org/reference/functions/wp_enqueue_style/)

- [WordPress Codex: wp_enqueue_script()](https://developer.wordpress.org/reference/functions/wp_enqueue_script/)

---

## Summary

WordPress hooks are powerful tools that let you customize WordPress without modifying core files:

- **Actions** perform tasks at specific times

- **Filters** modify data before it's used

- **Priority** controls execution order

- **Filters must return values**, actions don't

- Understanding hooks is essential for WordPress development

Start with simple hooks like `wp_enqueue_scripts` and `style_loader_tag`, then gradually explore more advanced hooks as you build your WordPress development skills.