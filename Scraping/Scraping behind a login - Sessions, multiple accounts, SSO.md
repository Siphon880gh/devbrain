Situation: The content you need is only visible after logging in, such as a course, a membership site, or an internal dashboard. You have legitimate access. How do you scrape it without fighting the login?

For example, scraping a bootcamp's course pages on an LMS like Canvas, using several accounts with different roles, each of which could see a different course.

---

## Easiest option: scrape inside your own logged-in browser

Anything that runs **in your normal, headed browser tab** already has your session cookies:
- Scripts pasted into the DevTools **Console** (see [[JS - Prep a page for copy and paste into notes app]])
- **Userscripts** (Tampermonkey) and Chrome extensions such as Puppeteer IDE (see [[Case Study - Headed Chrome TamperMonkey vs Puppeteer IDE]])
- `fetch()` calls to the **same site** from that tab's console

So the login problem goes away: you log in by hand, then scrape. This is one of the main reasons to scrape headed rather than headless ([[Headed vs Headless Scraping]]). If you need a headless browser later, log in once headful and reuse the session ([[Common Pattern - Puppeteer Headful, Then Puppeteer Headless]]).

### Fetching other pages with your session

From the site's own tab, same-origin requests include your cookies automatically:

```js
const res = await fetch("/some/protected/page", { credentials: "include" });
const html = await res.text();
const doc = new DOMParser().parseFromString(html, "text/html");
console.log(doc.title);
```

Some platforms also have a **REST API that accepts your browser session** for read requests. Canvas, for example, has `/api/v1/courses/<course_id>/pages` and `/api/v1/courses/<course_id>/modules`. Canvas may prefix session-authenticated JSON with `while(1);` (a JSON-hijacking guard). Strip it before `JSON.parse`:

```js
const txt = await (await fetch("/api/v1/courses/<course_id>/modules?per_page=100")).text();
const data = JSON.parse(txt.replace(/^while\(1\);/, ""));
console.table(data.map((m) => ({ id: m.id, name: m.name })));
```

---

## Several accounts or roles

- **One account per window.** Use an **Incognito/Private window** or a **separate browser profile** for each account, so their cookies don't mix and you don't end up in the wrong account partway through a scrape.
- **Different roles and accounts can see different content.** A tutor, TA, or staff account may see a different (older, simpler, or more complete) copy of the same course than a student in a current class. Write down **which account and which copy** you scraped, and compare one or two pages between copies before choosing which one to scrape.
- **Guessing usernames for role accounts** (e.g. `team-role@company.com` patterns) is a dead end unless you were given them. Keep a note of what's missing instead.

---

## Login pages, alternate domains, and SSO

- **Several login URLs for one platform.** A hosted platform may answer on its vendor domain (e.g. `<school>.instructure.com`) *and* a custom domain, and an account may work on both. If one fails or redirects, try the other.
- **Direct login form vs SSO.** Many platforms send you to an SSO provider by default. Canvas, for example, has a native login form at `/login/canvas` that skips the SSO redirect for accounts that have a local password.
- **SSO pass-through redirects** carry the page you wanted in a `target=` (or `return_to=`, `next=`) parameter. If you land on a generic page after logging in, decode that parameter and open the target yourself.

---

## Plan for access ending

- **Shared or role logins get shut down.** Organizations routinely stop shared accounts (and announce it ahead of time, if you're lucky). Scrape while you have access, and keep a dated note of when each login stopped working.
- **Sessions expire mid-scrape.** A script that suddenly finds nothing has often been redirected to a login page. Make your scripts fail loudly when the content container is missing (the [[JS - Verify a scraped page is complete (and QA checklist)|verification script]] does this).
- After the scrape is done, **keep the logins somewhere private** in case you need to go back and check a page that came out wrong.

---

## Credential hygiene

- Keep usernames and passwords in a **password manager or a private vault**, never in published notes, scripts you share, or screenshots.
- Page source and page-data globals contain **session details and tokens**. Strip them before sharing (see [[JS - Read page data from embedded JS globals (ENV, __NEXT_DATA__)]]).
- If the site blocks automation even with a valid login, that's bot protection, not an auth problem: [[403 Forbidden During Scraping, Probably Cloudflare detected you]].

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. Please do not break any laws. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
