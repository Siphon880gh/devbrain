
Two possibilities:
- You want no caching for your bot
- You're experiencing the same conversation in a shared link or published link

---

**How to Prevent Caching in Botpress Cloud**  
To ensure your bot always returns fresh, live results, you can bypass caching in two ways:

- **Permanent solution**: Add `And discard:{{Date.now()}}` to all AI-related components (such as AI Task prompts or Knowledge Base contexts). This dynamic value forces a new response each time.
- **Cache busting during development**: Publish your bot and test it in an incognito browser window to avoid cached responses during development.

---

If it's your Share or Publish link that needs to be cache busted because it just loads an old conversation. It may have been by design to load old chat from LocalStorage or it's truly cached. Your options:
- Click pencil for new chat conversation at the top left:
  ![[Pasted image 20250521222903.png]]
- Append some url string at the end of the url to cache bust:
  Instead of `https://cdn.botpress.cloud/webchat/v2.4/shareable.html?configUrl=https://files.bpcontent.cloud/2025/05/17/14/SOMETHING-SOMETHING.json` , visit `https://cdn.botpress.cloud/webchat/v2.4/shareable.html?configUrl=https://files.bpcontent.cloud/2025/05/17/14/SOMETHING-SOMETHING.json&v=3`
- Visit Incognito