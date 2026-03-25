When a web server suddenly starts using very high CPU, the first job is not to guess the fix. The first job is to figure out **what kind of problem this is**.

A high CPU spike usually comes from one of these:
- heavy or malicious traffic, such as **bots**, scanners, scrapers, or flood-style abuse
- a bad or recently changed **vhost** configuration
- a **provider-side update** or system-level change that introduced a conflict, cleanup issue, or unexpected behavior
- both at the same time

That last case is common. A bad vhost may not look catastrophic under light traffic, but once bots or scanners hit it, the CPU problem becomes much more obvious.

So before changing random config lines, start by asking:
- **Did anything recently change?**
- **Did the hosting provider recently update the server?**
- **Is the server being hit by bots or abusive traffic?**

Those three questions help you decide which direction to investigate first.

## Start with timing and recent changes

One of the simplest and most useful questions is:

**What changed right before the CPU issue started?**

Examples:
- a new vhost was added
- an include file was modified
- a redirect was changed
- HTTP to HTTPS logic was adjusted
- a `try_files` rule was added
- a `root`, `alias`, or `index` path was edited
- a Cloudflare or reverse proxy setting changed
- SSL was renewed, replaced, or partially broken
- the hosting provider updated the VPS, kernel, packages, control panel, or system components

That last one is important. Sometimes the problem did not come from something you changed manually. The provider may have pushed an update, and that update may have introduced a conflict, left behind stale state, changed how services start, or exposed an issue that had not shown up before.

Because of that, an early first check is:

**Did the provider recently update the server?**

Your provider may have emailed you about a server maintenance or server update. They might have a status page that shows planned maintenance and updates. Or they may have a server update/change log.

If the timing matches, try a clean VPS restart first. A restart can sometimes clear stale processes, temporary conflicts, broken service state, or partial update issues.

If the system comes back normal after a restart, that points more toward a temporary update-related conflict or cleanup issue. If the problem comes back immediately after reboot, then keep investigating because the underlying cause is still present.

So one practical early step is:
- check whether the hosting provider recently updated the server
- if so, restart the VPS and see whether the high CPU condition clears
- if the problem remains, continue the investigation instead of assuming the reboot fixed the root cause
## Checking whether the server is being hit by bots or abusive traffic

Sometimes the server is not broken at all. It is just being overwhelmed by request volume.

That can come from:
- bot scans
- scraper traffic
- brute-force attempts
- vulnerability probes
- distributed background internet noise
- targeted abuse or denial-of-service style request floods

Abusive traffic can happen for different reasons. A business competitor or hostile actor may try to overwhelm your site and take it offline. Scrapers may target a website that contains valuable or content-rich data. Sometimes automated scanners detect that a site looks vulnerable, and the server then gets repeatedly probed by bots looking for anything useful, such as weaknesses to exploit, sensitive information, or financially valuable data.

---

If the issue was triggered by a hosting provider update, a VPS restart may be a simple and effective first fix.

If the cause is a vhost problem or abusive bot traffic, the troubleshooting usually becomes more involved. In that case, refer to the following branches.

---

## Branch A: Check whether a vhost problem is causing the CPU spike

If traffic does not look unusually high, or if the problem started right after a config change, then the vhost itself becomes a stronger suspect.

A bad vhost can create problems such as:
- redirect loops
- internal rewrite loops
- `try_files` loops
- broken `root`, `alias`, or `index` behavior
- repeated filesystem lookups
- bad include inheritance
- recursive path resolution
- symlink-related path issues

In those cases, even normal traffic can create high CPU usage because every request becomes expensive.

A useful early clue is whether the problem began right after editing:
- the site vhost
- an include or snippet
- PHP routing
- SSL redirect logic
- reverse proxy settings
- document root paths

If that timing fits, let's look into the vhost, following [[Nginx vhost - Troubleshooting - vhost problems that cause high CPU usage]]

---
## Branch B: Check whether the server is under bot or scanner pressure

Sometimes the server is not broken at all. It is just busy because it is being hit hard.

That can come from:
- bot scans
- scraper traffic
- brute-force attempts
- vulnerability probes
- distributed background internet noise
- targeted abuse or denial-of-service style request floods

Refer to [[Diagnosing Bot Attacks - Detecting Traffic Bot Problems vs. Other Causes]] on how to find out if it's bot attacks. If it is bot attacks, refer to the other solutions in that folder.

If traffic looks fairly normal, then the next step is the **vhost-checking and fixing article**.