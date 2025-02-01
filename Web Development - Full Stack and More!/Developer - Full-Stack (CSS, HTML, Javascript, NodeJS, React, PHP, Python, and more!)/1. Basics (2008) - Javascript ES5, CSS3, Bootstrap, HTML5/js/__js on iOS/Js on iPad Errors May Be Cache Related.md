
Although it could be WebKit related because it has a stricter and unique take on some aspects of javascript, it could also be a caching issue

A level of complexity that could crash your web app is caching differences of iPad Safari. iPad Safari insists on a stale js file despite letting your html or php changes thru. This mismatch could cause js errors that you don't get on another device

What's irritating is that iPad ignores your cache control header that orders get a new copy of js files

**Reminder:**

The first level of complexity is just being on a WebKit engine browser because of how fussy it is (Desktop Safari, and all browsers on iPad or iPhone). But testing on different browser is not enough because iPad itself is fussy (by being aggressive with cache). 

**Reminder:**

So when you test on Safari, test across at least desktop Safari and iPad Safari
That's in addition to testing on Desktop Chrome....

See if it's caching using a stale js file that causes glitches on the app.

**Using remote developer:**
![](gwkkUjg.png)

iPad Safari can exhibit more aggressive caching behavior than iPhone Safari or Desktop/Laptop Safari so far into 12/24. To see why, refer to...