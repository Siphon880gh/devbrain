Before putting your website behind Cloudflare’s proxy, especially on the free Cloudflare plan, it is important to understand the limits first. This helps you avoid surprises later if your website or web app needs higher limits.

On Cloudflare’s free plan, common limits include:
- **100 MB upload/request size limit**
- **120-second request timeout**
- **5 custom rules**, such as rules for skipping bot protection on specific URL paths

These limits are usually fine for normal websites. However, they can become a problem for apps that need large file uploads, long-running API requests, or many custom security and caching rules.

Higher paid Cloudflare plans have higher limits, but they still have limits. Cloudflare lists the available plans here:

[https://www.cloudflare.com/plans/](https://www.cloudflare.com/plans/)

However, the plan page does not always explain every detailed limit, such as the exact number of custom rules included on the free plan.