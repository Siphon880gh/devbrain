iPads are aggressive with caching. Remember that although you could use Chrome or Firefox on iPad, Apple enforces that all web browsers must use the same WebKit engine

Here are useless caching strategies. For caching strategy that lets you cache bust on an iPad, it usually involves changing the filename or the url to the file assets, and there is a seamless way to do so if you're using PHP that does not force you to make another commit, crowding the git diffs - Refer to [[iPad Safari aggressively caches - 2. How to mitigate]].

Useless caching strategies:
- Etag
- Clear-Site-Data
- Cache-Control and Pragma Headers

## Etag useless on iPad Cache Busting
  
Etag:
- The `ETag` is specific to the HTTP response for the current request.
- If you set an `ETag` in your PHP file, it only affects the caching behavior of that PHP response, **not the individual assets (e.g., JS or CSS files) linked within the HTML served by the PHP file.**
```
header('ETag: "my-custom-version-123"');  
```

Etag used at the server level is also individual files. You can write match rules to change Etag for each file but that is impractical. Instead, using no-cache header, the web browser  validates with server that the file exists (fallback to cached copy if file not exists or can't connect on server) and then checks the Last Modified Time to determine if need a fresh redownload

Unfortunately, it fails at cache busting on iPads.


## Etag useless on iPad Cache Busting

What about: `Clear-Site-Data: "*"`. Unfortunately, Safari (both on macOS and iOS/iPadOS) does not support the Clear-Site-Data header. This includes clearing cookies, storage, cache, etc., through this mechanism.

## Cache-Control and Pragma Headers

For iPad, even no-store vs no-cache, must-revalidate - at nginx vhost or php header code   can't be depended on. Apples philosophy is not giving control to the user nor the developer, so you're forced to use new url by appending a version number, which is not friendly to code reviews because of multiple script and link tags crowding the git diffs. Optimal solution that forces new url without irritating code reviewers (or those who want a clean organized commit history) is at [[iPad Safari aggressively caches - 2. How to mitigate]]