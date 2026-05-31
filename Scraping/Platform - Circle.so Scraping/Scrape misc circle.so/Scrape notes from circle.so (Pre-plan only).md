Note: This has not been fully developed because I didn't need it. But it has enough information for you to develop your own Puppeteer IDE or Macro script or plan

---

A page with audio files look like:
![[Pasted image 20251123233755.png]]

Clicking one of the rows would prepopulate a modal
![[Pasted image 20251123233857.png]]

That modal has the attribute
```
data-testid="modal-content"
```

But keep in mind if your instructor likes to embed other materials like this:
![[Pasted image 20251123234950.png]]

Then consider how you’ll actually scrape those files. Ideally, you don’t want to download everything manually — though that can be your fallback. As a last resort, you could simply gather all the download links (the same way you collect curl or ffmpeg commands) and batch-download them yourself if there aren’t too many embeds.
![[Pasted image 20251123235331.png]]

That should be enough information for you to develop a Puppeteer IDE or Macro script or plan