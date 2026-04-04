iPad Safari aggressively caches which can cause your js and css files to be stale copies while webpages are leniently allowed to refresh. This is worse than just presenting an older version of the app, but because of the mismatch between aspects of your codebase could crash the app.

Apple decided iPad because it may be “on-the-go” and not have stable internet connection, and because websites usually have mobile optimized pics but not necessarily iPad optimized pics, THEN, because of that, iPad is aggressively sticky with cache.

Many of the cache busting strategies that work on other devices, does NOT work for iPad, as pointed out to at [[Useless Cache Control Strategies on iPad]]. However, service workers / Vite / CRA takes care of cache busting easily by naming the bundle js and css files uniquely with hashes.

If you cannot use service workers / Vite / CRA, then iPad caching busting can be found here:
[[iPad Safari aggressively caches - 1. Why]]
[[iPad Safari aggressively caches - 2. How to mitigate]]