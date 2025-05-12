In this tutorial you will learn one-shot prompting, etc; iterative prompting etc

---

Users interact with large language models (LLMs) by entering instructions in plain language. This user-provided text is called a **prompt**—it's how you tell the AI what you want it to do.

Once the model receives the prompt, it generates a **response**, also known as the **output**.

While this course focuses on generating **text-based outputs**, different generative AI models can produce other types of outputs—such as images, when using tools like Midjourney or Stable Diffusion.

A prompt might be as simple as a direct question like `Who was the first president of the United States?` or a creative request such as `Write a haiku about the beauty of AI.`

Prompts can also be complex and include detailed instructions or examples to guide the model toward producing a more relevant and useful result. Since LLMs rely on massive datasets to generate their responses, the _specific words_ you use in a prompt can have a big impact on the output.

---

### Prompt Engineering

**Prompt engineering** is the practice of carefully designing prompts to produce better, more relevant AI-generated outputs.

Understanding how these models work—and where their limitations lie—can help you craft prompts that more effectively guide the model.

Key concepts to keep in mind:

- Small changes in phrasing can cause big differences in output. It’s worth experimenting with different wordings.
    
- LLMs are **text predictors**—they generate the most likely next word or token based on your input.
    
- Responses are **stochastic**, meaning they include some randomness. Running the same prompt multiple times might yield different outputs.
    
- Be cautious of **AI hallucinations**—confident but incorrect or misleading outputs. Clear, specific prompts reduce the risk.
    
- Some prompts may require **domain expertise**. For example, asking for medical advice based on a case history should involve accurate medical language and an understanding of possible treatments.
    

---

### Components of a Well-Engineered Prompt

A solid prompt usually includes at least one of the following:

- A question
    
- Instructions
    

You can further enhance the prompt with optional elements like:

- **Input data**: Additional context (e.g., user demographics, file contents, tone preferences).
- **Examples**: Clear instances of what you want (or don’t want) in the output.

These elements guide the model to generate a more useful and tailored response.

![](9OqqnLL.png)


In the example above, instead of a generic request like “Tell me a joke about penguins,” the prompt specifies a **tone**—“dad joke”—which helps the model aim for the desired style.

Likewise, examples help filter the model’s output by showing it what kind of result you’re after. Let’s say you want a shark movie recommendation. You’ll get a better answer if you include what you liked and didn’t like:

> “I liked _Jaws_, _The Shallows_, and _Open Water_ — but not _Sharknado_ or _The Meg_.”

![](wtUPcSr.png)

Order matters. Examples are more effective when placed **after instructions**, and reordering them can change the result. So don’t hesitate to test different formats.

---

### Prompting Techniques

#### Iterative Prompting

Iterative prompting involves refining your prompt step-by-step to get closer to your desired result. It’s ideal for complex tasks where the first response isn’t perfect.

Here’s the typical flow:

1. **Start general**: “Explain iterative prompting in AI.”
2. **Assess the response**.
3. **Refine**: “Give an example of iterative prompting.”
4. **Drill down**: “How does it work for software debugging?”
5. **Wrap up**: Summarize findings or continue with a new focus.

**When to use it:**

- For complex or layered topics
- When you need clarification
- In creative or technical workflows

This approach lets you guide the conversation and hone in on what you need.

---

### Techniques to Improve AI Output

#### Zero-shot, One-shot, and Few-shot Prompting

These techniques refer to how much information you give the model in the prompt.

**Zero-shot prompting** means giving no examples. You rely on the model’s training to produce a general output.

![](igrPD8P.png)


**One-shot prompting** gives a single example to steer the model.

![](MSHg33E.png)


**Few-shot prompting** offers multiple examples (usually 2–5), narrowing the model’s focus.

![](KUngOve.png)


The more relevant examples you provide, the more specific and useful the output becomes.

---

#### Chain of Thought (CoT) Prompting

**Chain of Thought prompting** instructs the model to reason through its response step by step.

![](lJgoUzp.png)


To use CoT, you’ll want to include phrases like:

> “Explain your reasoning step by step.”

You can also ask the model to use a specific format or outline.

Here’s a comparison between standard and CoT outputs:

![](ZoOEcWu.png)

CoT not only improves factual accuracy but also shows _how_ the model arrived at an answer, making it easier to verify. It also reduces hallucinations by encouraging transparency.

---

#### Prompting for Citations

Asking the model to include **sources** improves credibility and reduces hallucination risk.

You can be general:

> “Answer only using reliable sources and cite them.”

Or specific:

> “Use only peer-reviewed medical journals.”

![](c85pQhK.png)

This approach lets you trace and fact-check responses while nudging the model toward higher-quality data.

---

#### Assigning a Role

You can improve the model’s responses by asking it to play a specific **role**—such as a teacher, doctor, or movie critic.

![](PuRKLcS.png)

By setting a role, you’re giving the model context, which improves the relevance and tone of its response.

---

#### Q&A Follow-Ups

Engaging the model in a back-and-forth Q&A helps guide it toward a better result. You can ask follow-up questions to correct or narrow the focus.

Even forceful prompts like all-caps or exclamation points can influence tone and output style:

![](Oz2xPDX.png)

---

#### Using Templates

Prompt templates combine several techniques (instructions, examples, roles) into a reusable format.

This lets you plug in new data while maintaining consistent, high-quality results.

Templates are especially useful for tasks that are repeated often—like generating reports, writing emails, or giving recommendations.
