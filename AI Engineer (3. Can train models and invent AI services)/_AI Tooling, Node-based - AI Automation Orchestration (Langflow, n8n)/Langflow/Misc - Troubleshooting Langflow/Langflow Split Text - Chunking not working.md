Let's say you have text files at a directory that you're splitting/chunking:
![[Pasted image 20250212190348.png]]

But when you click "Chunks" out port at Split Text component, there's only one chunk when you know the text files are much longer:
![[Pasted image 20250212190436.png]]

It's supposed to be:
![[Pasted image 20250212190448.png]]

---

**Solution:**

Add space at Split Text's separator field:
![[Pasted image 20250212190525.png]]

When you run the flow again, clicking "Chunks" out port should show the chunks:
![[Pasted image 20250212190448.png]]

---

**Discussion**

If you had still loaded the only-one chunk into AstraDB, it would have looked like this at DataStax's AstraDB web dashboard:
![[Pasted image 20250212190948.png]]

At loading, it would complain about the page_content. If you had it fixed and multiple chunks load into AstraDB, then you see a normal:
![[Pasted image 20250212191018.png]]