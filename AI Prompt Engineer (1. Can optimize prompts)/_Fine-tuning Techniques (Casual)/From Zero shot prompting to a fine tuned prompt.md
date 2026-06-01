**Goal**: 
- Use zero-shot prompting to discover a strong response, then refine the original prompt so it can reliably produce that same quality again.

**What we will do:**
- Asking a general question with no examples = **zero-shot prompting**
- Trying the same prompt in new chats to get different outputs = **sampling / prompt iteration**
- Giving ChatGPT your original prompt + a good response and asking it to improve the prompt = **prompt refinement**, **prompt optimization**, or **reverse prompt engineering**

---

**First step**

Start with a general question.

This works well when you do not know the topic deeply yet. Sometimes ChatGPT gives an answer that feels like it “read your mind” and includes helpful ideas you did not think to ask for.

When that happens, you can turn that good answer into a better prompt so future responses follow the same direction.

If the answer is not quite right, try asking the same general question again in a separate chat. Ideally, use a clean chat thread without memory. You can also use ChatGPT logged out in an incognito window.

Compare the answers and choose the one closest to what you wanted.

---

**Second step**

Take your original prompt and the response you liked. Then ask ChatGPT to improve the prompt.

Use this format:

```txt
I have a prompt:
"""
PROMPT
"""

That returned this response:
"""
RESPONSE
"""

Please refine my prompt so that it will return the same type of response.
```