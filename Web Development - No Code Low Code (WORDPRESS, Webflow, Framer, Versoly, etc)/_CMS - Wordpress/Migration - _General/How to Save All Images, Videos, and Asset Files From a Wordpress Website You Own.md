If the website is on WordPress and you are cloning it because you no longer want it to run on WordPress, exporting the media library is one of the important steps.

In WordPress, go to:

```txt
Tools → Export → Media → Download Export File
```

WordPress can export media records into an XML export file. The official Learn WordPress lesson notes that the export tool lets you choose “media” as the export type. ([Learn WordPress](https://learn.wordpress.org/lesson/tools-export-and-import/"))
![[Pasted image 20260530002121.png]]


---

Once you have the XML file, ask ChatGPT:
![[Pasted image 20260530001419.png]]
^ That's a direct prompt you can memorize

But a better prompt is:
```txt
I exported this WordPress XML file. Please extract and clean all media URLs from it.

Return only direct downloadable media URLs, one per line.

Include files such as:
- jpg
- jpeg
- png
- gif
- webp
- svg
- mp4
- mov
- webm
- pdf
- mp3
- wav

Here is the XML:
[paste XML here]
```

After ChatGPT gives you the cleaned list of URLs, give that list to Cursor or another coding agent.

Prompt Cursor:

```txt
Help me download all of these media URLs into a local folder named `old-version-assets/`.

Here are the URLs:
[paste URL list here]
```
