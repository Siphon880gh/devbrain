Example Prompt:
```
Complete this writing peice:

Bifidobacterium infantis
- Infant Microbiome & Immunity: It is a pioneer colonizer of the neonatal gut. When paired with breast milk, it lowers intestinal inflammation, strengthens the intestinal barrier, and accelerates the maturation of a healthy immune

Bifidobacterium longun NI338
- ___

Bifidobacterium lactis NI315
- ___

Bifidobacterium bifidum NI310
- ___
```

---

That’s mainly a **template-completion prompt** or **structured continuation prompt** but when it comes to N-shot, it's a **One-Shot Prompting**.

More specifically, it combines a few prompting styles:


**1. Few-shot prompting, lightly**  
Because you gave one example, it acts like a “one-shot” example. The model learns the format from that first item.

**2. Fill-in-the-blank prompting**  
You give blanks like:

`Bifidobacterium longum NI338 - ___`

and ask the model to complete them.

**3. Pattern-completion prompting**  
You provide one completed example:

`Bifidobacterium infantis - Infant Microbiome & Immunity: ...`

Then the model infers the style, structure, tone, and level of detail for the remaining items.

**4. Structured writing prompt**  
The desired output is not open-ended. It has a clear structure:

`Organism/strain`  
`- Use Case Title: Explanation`

A cleaner label would be:

**“One-shot structured completion prompt”**

Or more casually:

**“Fill-in-the-blank pattern prompt.”**