
**How to Prevent Caching in Botpress Cloud**  
To ensure your bot always returns fresh, live results, you can bypass caching in two ways:

- **Permanent solution**: Add `And discard:{{Date.now()}}` to all AI-related components (such as AI Task prompts or Knowledge Base contexts). This dynamic value forces a new response each time.
- **Cache busting during development**: Publish your bot and test it in an incognito browser window to avoid cached responses during development.