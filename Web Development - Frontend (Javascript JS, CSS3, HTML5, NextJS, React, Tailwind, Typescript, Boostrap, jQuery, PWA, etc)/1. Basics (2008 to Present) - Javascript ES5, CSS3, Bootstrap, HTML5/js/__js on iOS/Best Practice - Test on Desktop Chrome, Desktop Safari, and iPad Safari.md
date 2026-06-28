
Test on Desktop Chrome, Desktop Safari, and iPad Safari

When you test on Safari, test across at least desktop Safari and iPad Safari

That's in addition to testing on Desktop Chrome.... (not iPad or iPhone Chrome because Apple forced all browsers on there to be WebKit like Safari)

**Quick reason why:**
This is due to a fussy WebKit Safari and also due to sticky cache on iPad. Read more about that in this folder js on iOS. For example, WebKit engine requires you to pass in parameter event in event handlers if you want to access the event target, WebKit engine renders multiple images differently, etc that stands out from other web browsers.