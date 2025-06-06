### Decide use case (What you're using the AI for)
These are some uses:
- Determine if a movie's reviews are positive or negative.
- Help chatbots answer questions.
- Help predicts text when writing an email.
- Can quickly summarize long legal contracts.
- Differentiate words that have multiple meanings based on the surrounding text.

For more use cases, refer to [[_Categories - Types of AI]] which describe the types of AI and their uses.

### Decide environment (Run locally or on the cloud)

You're running locally if your computer can handle it. 
- Your platform:
	- Mac: A 8B model runs pretty reasonable on an Apple M1 chip on 16GB Ram. Simple query will have a response time of 30seconds - 1 minute. However, 8B parameter models may be often incorrect when asked questions, and they will hallucinate and lie to sound confident. A 8B model runs pretty reasonable on an Apple M1 chip on 16GB Ram. Simple query will have a response time of 30seconds - 1 minute.
	- Windows NVIDIA: This is preferred because you have GPU which handles AI better.
- Try other people's premade tools
	- PrivateGPT primordial branch: 
		- We are not using PrivateGPT's latest copy because that's been rewritten to be UI focused, which would make it too opaque for you to learn how AI works, and also because it's not scripting based then you can't easily implement it into your own server or apps
		- Clone and try to augment PrivateGPT with pdfs, then query the PDF:
		  https://github.com/zylon-ai/private-gpt/tree/primordial

You're running server for app purposes:
- You may need to buy a GPU server or Cloud server like AWS. A traditional VPS or dedicated server with CPU can work but is not the best at running large LLM or even a normal sized LLM but with high traffic

You'r running on the cloud for learning purposes
- Google Vertex AI
- Hugging Face: Community shares theirs, and the code is ready to work because it spins up GPU processes
- Google Colab: Community shares theirs, and the code is ready to work because it spins up GPU processes
