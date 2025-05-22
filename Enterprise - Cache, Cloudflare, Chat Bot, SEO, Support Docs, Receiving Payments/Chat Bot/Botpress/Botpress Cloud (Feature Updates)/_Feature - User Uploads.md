

If you take a look at the Chat interface (Emulator), at the bottom left is a plus "+" button to upload files:
![[Pasted image 20250520054205.png]]

Botpress Cloud allows users to upload a file, which can then be processed in multiple ways.
- If the file contains images, you can use Vision AI to analyze or extract text using OCR. 
- For text-based files, the **Raw File** card automatically uploads the file to Botpress Cloud’s server and returns a URL. You can then use **Execute Code** to read the file contents from that URL and pass the data to other cards—for example, feeding the content into an **AI Generate Text** card for further processing. Refer to [[3.1 Knowledge Base - From User's File Upload]]

Although you can test uploading files as the chat user in Chat Emulator, you have to enable it for the public at:
![[Pasted image 20250521214232.png]]