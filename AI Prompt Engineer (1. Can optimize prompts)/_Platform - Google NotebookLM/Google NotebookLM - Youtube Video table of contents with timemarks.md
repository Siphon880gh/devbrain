Google Notebook can look at your Youtube video and then generate a table of contents with timemarks

Free
[https://notebooklm.google.com/](https://notebooklm.google.com/)

Select Youtube as source:
![[Pasted image 20250212003547.png]]

For our example I use `[https://www.youtube.com/watch?v=6kHCE1_LaO0](https://www.youtube.com/watch?v=6kHCE1_LaO0)` which is a tutorial on ComfyUI (free text to video generator that is configured using a flowchart of nodes, giving you AI Engineering control over the generative process)
![[Pasted image 20250212003624.png]]


Now you must add the text audio transcript.

> [!note] What happens if you start asking for table of contents and timemarks now?
> It would be erroneous because as of 2/2025, you cannot trust Google's NotebookLM to accurately watch through the video and come up with the correct timemarks. It'll still hallucinate timemarks. Notice so many topics discussed at 0:03 which is impossible, because it's incorrect.
> ![[Pasted image 20250212003807.png]]


Let's add the audio transcript as a second source.

At the youtube video, visit description for the Transcript:
![[Pasted image 20250212003841.png]]

Then click and select all of the transcript and copy to your clipboard:
![[Pasted image 20250212003900.png]]


Back at NotebookLM, add a new source:
![[Pasted image 20250212003926.png]]

Select copied text:
![[Pasted image 20250212010420.png]]

Then paste from clipboard:
![[Pasted image 20250212003946.png]]

Your sources should be 2:
![[Pasted image 20250212003959.png]]


Finally, ask:
```
Using the audio transcript, please generate table of contents of main topics and sub topics. Add time codes so I can jump to the specific topic.
```

Google NotebookLM responds with a table of contents and timemarks:
![[Pasted image 20250212004020.png]]

---

Another way to learn is to Generate a Deep Dive conversation with Two hosts at the top right (If you are a type of learner from listening to conversations).

