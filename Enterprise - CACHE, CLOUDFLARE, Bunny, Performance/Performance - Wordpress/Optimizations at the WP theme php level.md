## When does this apply:
- This is after you've done all the other optimizations including plugins like WPRocket
- Now the only place to further optimize is the theme file

---

## Warning!
Editing PHP files in your child theme is risky if you don't know what you're doing. This is only for developers. If you try to optimize while learning PHP, you might crash the entire website and not be able to log in. PHP is responsible for putting the HTML that gets delivered to your website in your web browser.


**Safety Contingencies:**
- Have backups that can be restored
- Work on a staging server rather than production when possible
- Give yourself SFTP access (via FileZilla or another FTP client) so you can fix code if the dashboard becomes unavailable
- If the site crashes and you can't access the dashboard or WP file manager, use FTP to fix the code

---

## Create a child theme

Create a child theme so that theme updates won't wipe your optimizations. If you do not remember how to create a child theme, you probably shouldn't be messing with theme files.

However, you can review how to create a child theme at my coder notes: codernotes.wengindustries.com/?open=2.%20Make%20WordPress%20Child%20Theme%20(Minimal%20Setup).

## Use this functions.php

Adapt it to your needs:
```
<?php

// When enabled, logs JS/CSS handles to the error log for later use in performance-related asset tweaks.
$peek_handles = false; // Set to false to disable when done optimizing performance

// When enabled, logs which scripts and styles are being deferred (excludes critical/core dependencies)
$peek_deferred = false; // Set to false to disable

// Block Roboto font site-wide (prevents loading)
// Why: The Roboto font can cause a performance hit due to its many variations, which lead to larger file sizes and more requests if not optimized. Using multiple weights and styles, such as bold and italic, significantly increases the performance impact because it will load different woff2 files
// Concern: If Roboto hard coded, web browser looks for css fall back fonts, then system fonts
$block_roboto_font = true; // Set to false to allow Roboto

// Enable Google Fonts optimization (preconnect and font-display:swap)
$preconnect_google_fonts = true; // Set to false if not using Google Fonts. Will preconnect TLS Handshake. Check Elementor -> Advanced -> Google Fonts

/* Load in child's style. */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get( 'Version' )
    );
});

/* Optimize font loading */
/* To find out:
 - See if Google Fonts enabled in Elementor settings
 - Visit website with Network panel opened, filtering to `fonts.g`
*/
if ( $preconnect_google_fonts ) {
    // Add preconnect for Google Fonts and other external font sources
    // add_action( 'wp_head', function() {
    //     echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    //     echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    // }, 1 );
    // -> Plays nicely with other themes/plugins and lets WP manage hints
    add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
        if ( 'preconnect' === $relation_type ) {
            $urls[] = 'https://fonts.googleapis.com';
            $urls[] = [
                'href'        => 'https://fonts.gstatic.com',
                'crossorigin' => 'anonymous',
            ];
        }
        return $urls;
    }, 10, 2 );

    // Add font-display=swap to Google Fonts URLs
    add_filter( 'style_loader_tag', function( $html, $handle, $href ) {
        // Check if this is a Google Fonts stylesheet
        if ( strpos( $href, 'fonts.googleapis.com' ) !== false || strpos( $href, 'fonts.gstatic.com' ) !== false ) {
            // Add display=swap parameter if not already present
            if ( strpos( $href, 'display=' ) === false ) {
                $separator = strpos( $href, '?' ) !== false ? '&' : '?';
                $html = str_replace( $href, $href . $separator . 'display=swap', $html );
            }
        }
        return $html;
    }, 5, 3 );
}

// Block Roboto font from loading (Part 1: prevent stylesheet loading)
if ( $block_roboto_font ) {
    add_filter( 'style_loader_tag', function( $html, $handle, $href ) {
        // Block any link that include Roboto css or Roboto font
        if ( strpos( $href, 'roboto' ) !== false ) {
            return ''; // Don't load this stylesheet
        }
        return $html;
    }, 4, 3 ); // Priority 4 runs before font-display filter at priority 5
}

// Optimize self-hosted fonts (e.g., Font Awesome loaded from Elementor plugin directory)
// These fonts are typically below the fold and should use font-display: swap
add_action( 'wp_head', function() {
    global $block_roboto_font;
    ?>
    <style>
        /* Force font-display: swap for self-hosted fonts to prevent render blocking */
        /* Font Awesome and other icon fonts are typically below the fold */
        @font-face {
            font-family: 'Font Awesome 6 Free';
            font-display: swap;
        }
        @font-face {
            font-family: 'Font Awesome 5 Free';
            font-display: swap;
        }
        @font-face {
            font-family: 'FontAwesome';
            font-display: swap;
        }
    </style>
    <?php
}, 2 );
// Use asset handles to manipulate their tag render in
add_action( 'wp_enqueue_scripts', function() {
    // Never mess with scripts in the admin or block editor because it doesn't need a performance boast for SEO
    if ( is_admin() ) { 
        return;
    }
    
    /* Peek into asset handles */
    global $peek_handles;
    if ( $peek_handles ) {
        global $wp_scripts, $wp_styles;
        error_log( '--- SCRIPTS ---' );
        error_log( implode( ",", array_keys( $wp_scripts->registered ) ) );
        error_log( '--- STYLES ---' );
        error_log( implode( ",", array_keys( $wp_styles->registered ) ) );
    } // if peek_handles

    // Kill any?
    $kill_styles  = [ 
        'font-awesome',
        'font-awesome-5-all',
        'font-awesome-4-shim',
        'elementor-icons-fa-solid',
        'elementor-icons-fa-regular',
        'elementor-icons-fa-brands',
        'hfe-social-icons',
        'hfe-social-share-icons-brands',
        'hfe-social-share-icons-fontawesome'
    ];
    $kill_scripts = [ ];
    // 'jquery-migrate'? some plugins using legacy code may need it. so let's not kill off migrate.
    // Remove jquery-migrate (saves ~6KB, only needed for old jQuery plugins)

    foreach ( $kill_styles as $handle ) {
        wp_dequeue_style( $handle );
        wp_deregister_style( $handle );
    }
    foreach ( $kill_scripts as $handle ) {
        wp_dequeue_script( $handle );
        wp_deregister_script( $handle );
    }


    // TODO if needed - bundle/minifiy multiple js
    //wp_enqueue_script(
    //    'site-main',
    //    get_stylesheet_directory_uri() . '/assets/js/bundle.min.js',
    //    [ 'jquery' ],
    //    '1.0.0',
    //    true // in footer
    //);
}, 120 );


/**
 * Dequeue Header Footer Elementor Font Awesome styles.
 * Was very sticky. This is not needed for rest of site where Elementor inline font awesome icon convert to SVG setting is obeyed.
 */
function hotfix_dequeue_hfe_fontawesome() {
    // Don't interfere with wp-admin
    if ( is_admin() ) {
        return;
    }

    $handles = [
        'hfe-social-share-icons-brands-css',
        'hfe-social-share-icons-fontawesome-css',
        'hfe-nav-menu-icons-css',
    ];

    foreach ( $handles as $handle ) {
        if ( wp_style_is( $handle, 'enqueued' ) ) {
            wp_dequeue_style( $handle );
            wp_deregister_style( $handle );
        }
    }

    // Optional: log that this ran (if WP_DEBUG_LOG is enabled)
    // if ( function_exists( 'error_log' ) ) {
    //     error_log( 'hotfix_dequeue_hfe_fontawesome executed' );
    // }
}

// Run VERY late on the main enqueue hook
add_action( 'wp_enqueue_scripts', 'hotfix_dequeue_hfe_fontawesome', 9999 );

// Also run after Elementor/HFE enqueue their frontend styles
add_action( 'elementor/frontend/after_enqueue_styles', 'hotfix_dequeue_hfe_fontawesome', 9999 );


add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {
    global $peek_deferred;

    // Never mess with scripts in the admin or block editor because it doesn't need a performance boast for SEO 
    if ( is_admin() ) {
        return $tag;
    }

    // Keep styles by src path (partial match) - useful for CDNs, specific directories, etc.
    $kept_src_paths = [
        '/wp-includes/js/dist/', // Core block editor packages
        // 'cdnjs.cloudflare.com',
        // 'cdn.jsdelivr.net',
        // '/wp-content/plugins/specific-plugin/',
    ];
    foreach ( $kept_src_paths as $kept_path ) {
        if ( strpos( $src, $kept_path ) !== false ) {
            return $tag;
        }
    }

    // Kill styles by src path rather than handle (partial match) - useful for CDNs, specific directories, etc.
    $kill_src_paths = [
    ];
    foreach ( $kill_src_paths as $killed_path ) {
        if ( strpos( $src, $killed_path ) !== false ) {
            return "";
        }
    }
    
    
    // Absolutely critical - must load synchronously in head
    $critical_sync = [
        'jquery',
        'jquery-core',
        // 'jquery-migrate', // only legacy plugin code
        'jquery-ui-core',
        'elementor-recaptcha-api',
        'elementor-recaptcha_v3-api',
        'wpforms-recaptcha'
    ];
    
    // Core dependencies - keep synchronous but can be in body/footer
    $core_dependencies = [
        'backbone',
        'underscore',
        'lodash',
        'backbone-marionette',
        'backbone-radio',
        'elementor-common-modules',
        'elementor-web-cli',
        'elementor-frontend',
        'elementor-frontend-modules',
        'elementor-dialog',
        'elementor-common',
        'elementor-webpack-runtime', // eg. Elementor table of contents needed
        'elementor-pro-webpack-runtime',
        'elementor-pro-frontend',
        'pro-elements-handlers',
        'eael-', // Essential Addons
        'hfe-', // Header Footer Elementor
        'moment',
        'wp-util',
        'wp-api-request',
        'wp-i18n',
        'wp-hooks',
        'wp-polyfill',
        'wp-data',
        'wp-dom-ready',
        'wp-element',
        'wp-components',
        'wp-plugins',
        'wp-redux-routine',
        'wp-a11y',
        'react',
        'react-dom',
        'jquery-validate',
        'yoast-seo-premium-frontend-inspector',
    ];

    // Don't modify critical sync scripts
    foreach ( $critical_sync as $critical ) {
        if ( strpos( $handle, $critical ) === 0 ) {
            return $tag;
        }
    }
    
    // Don't modify core dependencies
    foreach ( $core_dependencies as $dependency ) {
        if ( strpos( $handle, $dependency ) === 0 ) {
            return $tag;
        }
    }

    // Don't modify scripts that already have async or defer
    if ( strpos( $tag, 'async' ) !== false || strpos( $tag, 'defer' ) !== false ) {
        return $tag;
    }

    // Defer all other scripts
    $tag = str_replace( ' src', ' defer src', $tag );
    
    // Log deferred scripts when peek flag is enabled
    if ( $peek_deferred ) {
        error_log( "DEFERRED SCRIPT: {$handle}" );
    }

    return $tag;
}, 10, 3 );

// Load non-critical CSS asynchronously
add_filter( 'style_loader_tag', function( $html, $handle, $href, $media ) {
    global $peek_deferred;

    // Keep styles by href path rather than handle (partial match) - useful for CDNs, specific directories, etc.
    $kept_href_paths = [
        // '/font-awesome/css/' // Removed - we want to block FA files instead
    ];
    foreach ( $kept_href_paths as $kept_path ) {
        if ( strpos( $href, $kept_path ) !== false ) {
            return $html;
        }
    } 

    // Kill styles by href path rather than handle (partial match) - useful for CDNs, specific directories, etc.
    $kill_href_paths = [
        '/font-awesome/css/'
    ];
    foreach ( $kill_href_paths as $killed_path ) {
        if ( strpos( $href, $killed_path ) !== false ) {
            return "";
        }
    } 

    
    // Critical CSS that should load normally (to prevent FOUC)
    $critical_styles = [
        'elementor-frontend',
        'elementor-post-', // Matches elementor-post-3254, etc.
        'elementor-icons', // Other icon libraries (not FA)
        'hello-elementor',
        'hello-elementor-child-style',
        'eael-', // Essential Addons
        // 'hfe-', // Header Footer Elementor
        'header-footer',
        'widget-heading',
        'widget-nav-menu',
        'widget-image',
        'widget-icon',
    ];
    
    // Check if this is a critical style
    foreach ( $critical_styles as $critical ) {
        if ( strpos( $handle, $critical ) !== false ) {
            return $html; // Load normally
        }
    }
    
    // Only defer these specific non-critical styles (icons, animations, rarely-used widgets)
    // Tip: Icons and fonts that appear below the fold - defer those too
    $defer_styles = [
        'animation',
        'wpforms',
        'widget-blockquote',
        'widget-social-icons',
        'v4-shims',
    ];
    
    // Check if this style should be deferred
    $should_defer = false;
    foreach ( $defer_styles as $defer ) {
        if ( strpos( $handle, $defer ) !== false ) {
            $should_defer = true;
            break;
        }
    }
    
    if ( ! $should_defer ) {
        return $html; // Load normally if not in defer list
    }
    
    // Load deferred CSS asynchronously using media print until loaded trick
    if ( $media === 'all' || $media === '' ) {
        $html = str_replace( "media='all'", "media='print' onload=\"this.media='all'\"", $html );
        $html = str_replace( 'media="all"', 'media="print" onload="this.media=\'all\'"', $html );
        $html = str_replace( "media=''", "media='print' onload=\"this.media='all'\"", $html );
        
        // If no media attribute exists, add it
        if ( strpos( $html, 'media=' ) === false ) {
            $html = str_replace( ' />', ' media="print" onload="this.media=\'all\'" />', $html );
            $html = str_replace( '>', ' media="print" onload="this.media=\'all\'">', $html );
        }
    }

    // Log deferred scripts when peek flag is enabled
    if ( $peek_deferred ) {
        error_log( "DEFERRED STYLE: {$handle}" );
    }
    
    return $html;
}, 10, 4 );

?>
```

## Features in functions.php

1. Enqueueing and dequeuing

	- Enqueues child theme stylesheet (hello-elementor-child-style)
	
	- Dequeues/deregisters Font Awesome styles and scripts
	
	- Dequeues Header Footer Elementor Font Awesome styles

2. Font optimization
	
	- Google Fonts preconnect (TLS handshake optimization)
	
	- Adds font-display=swap to Google Fonts URLs
	
	- Blocks Roboto font from loading
	
	- Forces font-display:swap for self-hosted fonts (Font Awesome 5/6)

3. Script deferring
	
	- Defers non-critical scripts
	
	- Preserves critical scripts (jQuery, Elementor core, reCAPTCHA) as synchronous
	
	- Preserves core dependencies (backbone, underscore, Elementor modules, React, etc.)

4. CSS async loading
	
	- Loads non-critical CSS asynchronously using the media print trick
	
	- Preserves critical CSS (Elementor frontend, theme styles, widgets) for normal loading
	
	- Selectively defers specific non-critical styles (animations, wpforms, social icons)

5. Asset management by path

	- Kills/keeps scripts by source path (not just handle)
	
	- Kills/keeps styles by href path
	
	- Useful for CDNs and specific plugin directories

6. Debug/logging

	- Logs all registered script and style handles (when $peek_handles is enabled)
	
	- Logs deferred scripts and styles (when $peek_deferred is enabled)

7. Resource hints

	- Adds preconnect hints for Google Fonts domains via wp_resource_hints filter

8. Admin/editor protection

	- Skips performance optimizations in admin and block editor contexts

9. Header Footer Elementor Font Awesome hotfix

	- Special function (hotfix_dequeue_hfe_fontawesome) that runs very late to dequeue sticky HFE Font Awesome styles

	- Hooks into both wp_enqueue_scripts and elementor/frontend/after_enqueue_styles

10. Configurable flags

	- $peek_handles - Enable/disable handle logging
	
	- $peek_deferred - Enable/disable deferred asset logging
	
	- $block_roboto_font - Enable/disable Roboto font blocking
	
	- $preconnect_google_fonts - Enable/disable Google Fonts optimization

These focus on performance optimization, font loading, and selective asset management for a WordPress/Elementor site.
  
---
## Walkthrough of functions.php

### Configuration Flags (Lines 3-10)

**Lines 3-4: `$peek_handles`**
- When enabled, logs all JavaScript and CSS handles to the error log
- Set to `true` to discover what assets are being loaded
- Check logs in WP Engine (or PHP error logs) to see all plugin names, CSS, and JavaScript handles
- **Important:** Turn this off immediately after use as it slows down the server
- The logs show you the handle names needed to modify arrays later in the code

**Lines 6-7: `$peek_deferred`**
- When enabled, logs which scripts and styles are being deferred
- Useful for debugging what's being deferred vs. what's loading normally
- **Important:** Turn this off immediately after use as it slows down the server

**Lines 9-10: `$preconnect_google_fonts`**
- Even though Google Fonts may be disabled in Elementor, other plugins might load Google Fonts
- When `true`, this pre-connects to Google's servers (fonts.googleapis.com, fonts.gstatic.com)
- Pre-connect performs a TLS handshake early, so when fonts are actually requested, they load faster

### Child Theme Stylesheet Loading (Lines 12-20)

**Lines 13-20: `wp_enqueue_scripts` action**
- Ensures the child theme's stylesheet is loaded
- This is standard WordPress child theme functionality

### Font Optimization (Lines 22-69)

**Lines 27-46: Google Fonts Pre-connect and Display Swap**
- Lines 29-32: Adds preconnect link tags in the HTML head
- Lines 35-45: `style_loader_tag` filter adds `display=swap` to Google Fonts URLs
- `display=swap` prevents layout shifting from invisible text - the browser shows fallback fonts immediately, then swaps to Google Fonts when loaded
- Without this, text can be invisible for up to 3 seconds

**Lines 50-69: Self-hosted Font Optimization**
- Forces `font-display: swap` for Font Awesome fonts via CSS @font-face rules
- This is more of a general boilerplate since Font Awesome is removed elsewhere
- You can remove this section if confident no font files will load, but it's harmless to leave
### Asset Discovery and Removal (Lines 71-121)

**Lines 72-75: Admin Check**
- Never optimizes scripts/styles in the admin area
- Performance optimization is frontend-only for SEO purposes
- Prevents breaking Elementor editor or other admin functionality

**Lines 78-85: Peek Handles Logging**
- When `$peek_handles` is true, logs all registered script and style handles
- Outputs to error log: "--- SCRIPTS ---" followed by comma-separated handles, then "--- STYLES ---"
- Use this to discover handle names for optimization
- Note: Logs may be truncated if there are many handles - you may need to improve the logging code or increase PHP log limits

**Lines 88-98: `$kill_styles` Array**
- Array of style handles to completely remove from loading
- Currently includes Font Awesome variants and Header Footer Elementor social icon styles
- As a developer, add handles here that you want to kill off
- Get handle names from the `$peek_handles` log output

**Line 99: `$kill_scripts` Array**
- Array of script handles to completely remove
- Currently empty - WP Rocket and other tweaks handle script optimization
- Add script handles here if you need to completely block certain JavaScript files

**Lines 103-110: Dequeue and Deregister Loops**
- Two foreach loops that go through `$kill_styles` and `$kill_scripts`
- Calls `wp_dequeue_style()` and `wp_deregister_style()` (or script equivalents)
- This prevents these assets from loading on the final page

### Header Footer Elementor Font Awesome Hotfix (Lines 123-158)


**Lines 128-151: `hotfix_dequeue_hfe_fontawesome()` Function**
- Additional guarantee that Font Awesome gets removed from Header Footer Elementor
- Font Awesome has different handles in different theme situations
- Every theme is different, so this catches variants that might slip through
- Removes Header Footer Elementor social share icon styles and nav menu icon styles

**Lines 154-157: Action Hooks**
- Runs very late (`9999` priority) on `wp_enqueue_scripts`
- Also runs after Elementor/HFE enqueue their frontend styles
- Ensures this runs after other enqueue operations

### Script Loader Tag - JavaScript Deferral (Lines 160-268)

**Lines 164-166: Admin Check**
- Early return if in admin - never modify admin scripts 

**Lines 169-179: `$kept_src_paths` Array**
- Keep scripts by URL path (partial match) rather than handle name
- Useful for CDNs or when you don't know the handle
- Currently keeps `/wp-includes/js/dist/` (WordPress core block editor packages)
- If a script's source path matches, it returns the tag unmodified

**Lines 182-188: `$kill_src_paths` Array**
- Kill scripts by URL path (partial match)
- Currently empty
- If a script's source path matches, it returns empty string (script doesn't load)  

**Lines 192-200: `$critical_sync` Array**
- Absolutely critical scripts that must load synchronously in the head
- These cannot be deferred
- Includes jQuery (Elementor Pro needs it immediately), reCAPTCHA scripts
- If a script handle matches, returns the tag unmodified (loads immediately)

**Lines 203-238: `$core_dependencies` Array**
- Core dependencies that should stay synchronous but can be in body/footer
- Includes Elementor Pro scripts, Essential Addons, Header Footer Elementor, React, etc.
- Distinction between `critical_sync` and `core_dependencies` is somewhat semantic - both prevent deferral
- You could optimize by combining into one array, but keeping separate helps with organization
- If a script handle matches, returns the tag unmodified

**Lines 241-252: Critical and Core Checks**
- Two foreach loops check if the script handle matches `$critical_sync` or `$core_dependencies`
- If matched, returns tag unmodified (no deferral)

**Lines 255-257: Already Optimized Check**
- If script already has `async` or `defer` attribute, return unmodified
- Prevents double-optimization or conflicts with other plugins

**Line 260: Defer All Other Scripts**
- All scripts not in the above arrays get `defer` attribute added
- This makes them load at the very end

**Lines 263-265: Deferred Script Logging**
- When `$peek_deferred` is true, logs which scripts were deferred
- Useful for debugging

**Important Notes:**
- If you install new plugins and they cause problems, they might need to be added to `$critical_sync` or `$core_dependencies`
- WP Rocket has similar options but with limitations (e.g., can't combine JS if deferring)
- Modifying PHP directly allows maximum optimization but risks breaking things

### Style Loader Tag - CSS Optimization (Lines 271-360)

**Lines 275-282: `$kept_href_paths` Array**
- Keep styles by href path (partial match)
- Currently empty (commented out Font Awesome path)
- If a style's href path matches, returns HTML unmodified

**Lines 285-292: `$kill_href_paths` Array**
- Kill styles by href path (partial match)
- Currently includes `/font-awesome/css/` to block Font Awesome CSS files
- If a style's href path matches, returns empty string (style doesn't load)
- This is the array you modify as a developer when killing CSS by path

**Lines 296-309: `$critical_styles` Array**
- Critical CSS that should load normally (prevents FOUC - Flash of Unstyled Content)
- Includes Elementor frontend styles, post-specific styles, icons, child theme styles
- If a style handle matches, returns HTML unmodified (loads normally)

**Lines 312-316: Critical Style Check**
- Foreach loop checks if style handle matches `$critical_styles`
- If matched, returns HTML unmodified

**Lines 320-326: `$defer_styles` Array**
- Specific non-critical styles to defer (icons, animations, rarely-used widgets)
- Only styles in this array get deferred
- If not in this array, styles load normally
  
**Lines 329-339: Defer Check Logic**
- Checks if style handle matches `$defer_styles` array
- If not in defer list, returns HTML unmodified (loads normally)

**Lines 342-352: Media Print Trick for Async CSS**
- Loads deferred CSS asynchronously using the "media print until loaded" trick
- Changes `media='all'` to `media='print' onload="this.media='all'"`
- This is a workaround because browsers don't natively support async CSS loading
- The CSS initially loads only for print preview, but once loaded, JavaScript changes it back to 'all' media
- This technique may be replaced by cleaner approaches in the future, but as of November 2025, this is still needed

**Lines 355-357: Deferred Style Logging**
- When `$peek_deferred` is true, logs which styles were deferred
- Useful for debugging
### Key Arrays to Modify

When optimizing further, these are the arrays you'll modify:

1. **`$kill_styles` (line 88)** - Style handles to completely remove
2. **`$kill_scripts` (line 99)** - Script handles to completely remove
3. **`$kept_src_paths` (line 169)** - Script paths to keep unmodified
4. **`$kill_src_paths` (line 182)** - Script paths to kill
5. **`$critical_sync` (line 192)** - Scripts that must load synchronously
6. **`$core_dependencies` (line 203)** - Core scripts that shouldn't be deferred
7. **`$kept_href_paths` (line 275)** - Style paths to keep unmodified
8. **`$kill_href_paths` (line 285)** - Style paths to kill
9. **`$critical_styles` (line 296)** - Styles that must load normally
10. **`$defer_styles` (line 320)** - Styles to defer
### Debugging Workflow
1. Set `$peek_handles = true` (line 4)
2. Visit your website pages
3. Check WP Engine logs (or PHP error logs) to see all handles
4. Add handles to appropriate arrays (`$kill_styles`, `$kill_scripts`, `$defer_styles`, etc.)
5. Set `$peek_handles = false` to stop logging
6. Test the website to ensure nothing broke
7. If something breaks, move problematic handles to `$critical_sync` or `$core_dependencies`
### Code Quality Notes
- The logging code could be refactored into its own function instead of spread throughout
- This code was built while focused on optimizing performance rather than readable code. We can improve it further.
- The distinction between `$critical_sync` and `$core_dependencies` is somewhat semantic - you could combine them into one array for slightly better performance