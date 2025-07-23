Required knowledge:
Know how to RAG with one file per [[Lv 4.1 - RAG with one file]]

---


The Load flow
In place of File or Directory, use the URL component (also under "Data" components category).
Enter your url
Eg. `https://cdn.preterhuman.net/texts/history/american/Knights_Templar.txt`
^ If the url is 404, you may choose another txt url or upload your own txt file to your own web hosting instead
![[Pasted image 20250212191426.png]]

Then run the Load flow. You may want to test that chunking worked properly (click "Chunks" out port at "Split Text" component) and if it did not split into multiple chunks, you can fix it by adding a space into the Separator field. This is discussed at [[Langflow Split Text - How to inspect or debug]] and [[Langflow Split Text - Chunking not working]].

Then as usual, test the Retrieval. You can ask a similar question from a previous challenge:
Eg. `The most prominent Knight Templar?`
![[Pasted image 20250212182032.png]]

---

**Discussion**

URL’s data points are (Clicking Data out port at URL):
![[Pasted image 20250212191818.png]]