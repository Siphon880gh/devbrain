When choosing models, optimize for **task size, risk, and token cost** — especially in tools like Cursor, where AI usage is prepaid and then topped off.

A practical way to do this is to **classify the task first**:
- light, low-risk work
- medium-difficulty implementation
- large, risky, or architecture-changing refactors

Then choose the model based on the **best performance-to-cost tradeoff**, not just the most powerful model every time.

A good way to research model choice is to:
- look for a **performance vs. cost graph**
- check what experienced users are saying about real-world usage, especially on Reddit
- use **image search** to quickly find comparison charts, since some of the most useful graphs may show up in Reddit posts or discussions

A useful rule of thumb is:
- use **cheaper, faster models** for planning, exploration, and lower-risk work
- use **stronger models** for high-risk execution, complex changes, or tasks where mistakes are expensive

---

For example, based on recent comparison graphs and Reddit discussions, I might choose:

- **For planning vs. implementation** for medium-difficulty tasks:
    - **GPT-5.4 mini high** for planning
    - **GPT-5.4 medium** for implementation

- For **larger or riskier refactors**, I would step up model strength:
	- **GPT-5.4 medium** for planning
	- **GPT-5.4 high** for implementation

---

Example performance vs cost graph found on Google Images on 3/27/26:
![[Pasted image 20260327003850.png]]
