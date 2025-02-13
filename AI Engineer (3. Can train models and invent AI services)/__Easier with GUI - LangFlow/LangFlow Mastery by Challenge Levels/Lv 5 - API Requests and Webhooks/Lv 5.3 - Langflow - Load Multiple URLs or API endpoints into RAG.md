Required knowledge:
Know how to RAG with one file per [[Lv 5.2 - Langflow - Load URL or API endpoint into RAG]]

---

You can add multiple URLs by clicking the "+" next to URL field:
![[Pasted image 20250212192122.png]]



---

**Discussion**

Let's say we have two URL's both to the same:
```
https://cdn.preterhuman.net/texts/history/american/Knights_Templar.txt
```

URL’s data points are (Clicking Data out port at URL) are as expected:
![[Pasted image 20250212192221.png]]

Clicking Chunks out port at Split Text component will be as expected
At one single URL it was 30 chunks. At two of the same URLs, it became 60 chunks:
![[Pasted image 20250212192330.png]]

And if you checked DataStax's AstraDB web dashboard, you'll see 60 additional records.