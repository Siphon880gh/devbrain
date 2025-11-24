Note: This has not been fully developed because I didn't need it. But it has enough information for you to develop your own Puppeteer IDE or Macro script or plan

You know that these are Transistor.FM audios in circle.so curriculum when you see the Transistor logo when playing an audio:
![[Pasted image 20251123232653.png]]

---

A page with audio files look like:
![[Pasted image 20251123231442.png]]

Clicking one of the rows would prepopulate a modal
![[Pasted image 20251123232653.png]]

That modal has the attribute
```
data-testid="modal-content"
```

Query for:
```
<div id="embed-player"
```

It actually contains an attribute `x-data` that has all the mp3 files. Then it's suggested you output a cURL command for each mp3 files, much like how it was done at the enhanced script at [[_Scrape videos circle.so - Decided download multiple files (m3u8 non-headered files)]] Then you can run a .sh file or terminal curl command to download the mp3's