
## CVE-2025-55182

For Next JS: The published affected range includes `>= 15.3.0-canary.0, < 15.3.6`

It is an upstream React Server Components issue, not just a Next.js issue. 

It affects these React packages when they are used with vulnerable versions: 
- react-server-dom-webpack
- react-server-dom-parcel
- react-server-dom-turbopack
- The vulnerable versions called out are 19.0.0, 19.1.0, 19.1.1, and 19.2.0

----

## Other Concerns

**React Native?**
**No — React Native is not directly affected** by **CVE-2025-55182**. The React Native team explicitly says React Native does not depend on the impacted React Server Components packages, which are the ones involved in this vulnerability.

---

## Solution

Upgrade immediately to 15.3.6 or later on your line. Next.js says there is no workaround; **upgrading is required**.  
  
If the app was internet-exposed and unpatched during the disclosure window, Next.js/Vercel recommend **rotating secrets** after patching and redeploying

Change your **root password** too. Users have noted their servers were changed into cryptomining servers from this hack.

**Have many NextJS apps on the same server?** Run ssh to search for: `next.config.js` and `next.config.ts`

