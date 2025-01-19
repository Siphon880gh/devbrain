
UPDATE 1/18/25: Seems to not be a problem anymore after reaching out to support. Support said wasn't a problem. Maybe it's possible our own code.

---

Goal was finding all real estate agents and brokers’ email addresses using Google Search, having “@“ with double quotes:
- emails have @ in their text
- By surrounding with double quotations, you are telling Google this keyword is mandatory

I kept getting misleading errors from having "@" at the end of the url:
```
{"original_status":403,"pc_status":503,"url":"https://www.google.com/search?q=pasadena+california+real+estate+email+@","body":"Request failed, with status codes original_status: 403 and pc_status: 503. Please try the request again, as this one is not charged, or contact support if the problem persists. If you want close to 100% success, try our Crawler which is normally included in the same price: https://crawlbase.com/docs/crawler"}
```

From a series of failures until eventual success, I figured out that special characters cannot be at the end of the url. Have reached out to support so this quirk may be patched up by now.

This fails:
```
const url = 'https://www.google.com/search?q=pasadena+california+real+estate+email+%40';
```

This fails
```
const url = encodeURIComponent('https://www.google.com/search?q=pasadena+california+real+estate+email@');
```

**But this succeeds:**
```
const url = encodeURIComponent('https://www.google.com/search?q=pasadena+real+estate+@+email');
```