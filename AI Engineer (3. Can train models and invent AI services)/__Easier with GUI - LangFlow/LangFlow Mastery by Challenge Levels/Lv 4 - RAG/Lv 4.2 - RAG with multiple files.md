Status: Coming soon - Weng

RAG with multiple files is pretty much the same with one small difference.

This tutorial assumes you already know how to perform RAG with one file.

---

**The difference**

At the Load file flow, you connect a Directory component instead of a File component.
- Directory component is also found inside the "Data" components category:
![[Pasted image 20250211033118.png]]

Enter the path to the folder that contains your txt files or pdf files. Unfortunately the field as of 2/2025 does not open a browse window, so you have to enter or paste it manually. You can test the path is correct by opening the terminal the running `ls "PATH"` where PATH is your path.

You may choose to narrow the File Types as well at the File Types field.

The directory component will concatenate all the files as one big file. It's the Split Text component as usual that chunks them over to AstraDB which will vectorize your RAG content using a text embedding model.

After you are done loading the data, go to the retrieval flow and run that flow with a RAG question as usual.

---

**Caveat about new collection**

If you are working from an older RAG workspace and replaced the File component with Directory component, and you've changed the collection name in the retrieval flow (hence Langflow will create a new collection at AstraDB), you must change the collection name at the Retrieval flow's AstraDB component too. But there's a quirk where the new collection at retrieval has 0 records still, and therefore your retrieval will fail despite you having loaded and ingested the data already. To read about the quirk and the solution: [[Langflow Quick - AstraDB Collection still 0 records]]