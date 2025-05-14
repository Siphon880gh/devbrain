Problem: You're trying to make sure that the Facebook share preview displays a dynamic title based on the `$title` variable in your PHP code, but Facebook's sharing feature is instead picking up the `<meta property="og:title">` tag from your main page, which is static and set to "Google."

Here’s what’s happening and how you can address it:

1. **Facebook Caches OG Tags**: Facebook often caches Open Graph (`og:title`, `og:url`, etc.) metadata for URLs, which means it may not refresh the title and other metadata dynamically for each share link. If `$url` is always the same, Facebook will use its cached version of the Open Graph tags associated with that URL.

2. **Dynamically Changing OG Tags**: To dynamically set the Open Graph tags, you’d need each URL to be unique for Facebook to recognize each share as different. Here are a few approaches you could take:

   - **Append Query Parameters**: Append a unique parameter to `$url` (e.g., `?title=Your+Title+Text`). Facebook ignores query parameters in URL caching, so it may still show the latest Open Graph metadata when you do this. You’d also need server-side logic to update `<meta property="og:title">` based on the query parameter.

   - **Create a Dynamic Share Page**: Instead of linking directly to Facebook's share endpoint, create a PHP page (e.g., `share.php`) that sets the appropriate `<meta>` tags based on the title passed as a query parameter:
     ```php
     // share.php
     <?php
     $title = isset($_GET['title']) ? $_GET['title'] : "Default Title";
     ?>
     <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>" />
     ```
     Then, link to this new page from your main code:
     ```php
     $fb = "http://www.facebook.com/sharer.php?u=http://yourwebsite.com/share.php?title=" . urlencode($title);
     ```

3. **Facebook Debugger for Cache Clearing**: After making these changes, use [Facebook's Sharing Debugger](https://developers.facebook.com/tools/debug/) to scrape your URL again. This clears Facebook’s cache and forces it to read the updated metadata.

This setup should help Facebook display the correct title from your `$title` variable when sharing.