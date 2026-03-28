In your AI Engineering code or tools, you may find settings like Temperature, Top K, Top P and Min P. This article will discuss their purposes

![[Pasted image 20260327031756.png]]
^ Above from https://www.thecloudgirl.dev/blog/mastering-ai-creativity-a-guide-to-temperature-top-k-and-top-p

---
## AI Creativity Controls: Temperature, Top-K, Top-P, and Min-P

When people adjust AI “creativity” settings, they are usually changing how the model selects the next word or token. These controls do not give the model new knowledge or unlock hidden domains. The knowledge is already there. What changes is how narrowly or broadly the model samples from the possible next-token choices.

### Temperature

Temperature mainly changes how willing the model is to move away from the most likely next token.

A helpful way to think about it:

**Low temperature**

- stays closer to the highest-probability continuation
    
- more consistent
    
- more repeatable
    
- better for factual, structured, or precise work
    

**High temperature**

- is more willing to choose lower-probability continuations
    
- more varied
    
- more surprising
    
- sometimes more creative, but also more error-prone
    

So temperature does affect wording, but not only wording. It can also influence:

- which ideas get selected
    
- which examples or analogies get used
    
- how the response is structured
    
- how willing the model is to make interpretive or conceptual leaps
    

That is why higher temperature can make the model feel more imaginative. It is not accessing new knowledge. It is simply sampling less obvious paths through the knowledge it already has.

### Example

Prompt: **“Give me a slogan for a coffee shop.”**

**Low temperature:**  
“Fresh coffee, served with care.”

**Higher temperature:**  
“Wake your soul, one cup at a time.”

The underlying knowledge is the same in both cases. The difference is the sampling behavior.

### Top-K and Top-P

Top-k and top-p are additional sampling controls that limit which tokens are even allowed to be chosen.

**Top-k** limits the model to a fixed number of the most likely tokens.  
If top-k is 40, the model can only choose from the 40 most likely next-token options.

Mnemonic: **Top-k = top kount = top count**  
It is the count of words or tokens allowed into the selection pool.

This tends to make output more stable and controlled.

**Top-p**, also called **nucleus sampling**, works differently.  
Instead of choosing a fixed number of tokens, it chooses from the smallest group of top tokens whose combined probability reaches a threshold p.

Mnemonic: **Top-p = top probability pool** (Think of a pool of different sized botches)
It is based on cumulative probability, not a fixed count.

This usually creates more flexible and natural variation because the token pool can grow or shrink depending on the context.

### How Top-K and Top-P Feel in Practice

These settings shape how broad the model’s choice pool is.

For example:

- a **high top-p** close to 1.0 with a **low top-k** under 50 often feels more controlled and predictable
    
- a **high top-k** above 100 with a **very low top-p** can sometimes feel less coherent, because the model may be forced into an awkward balance between broad token access and a narrow probability cutoff
    

In simple terms:

- **top-k** controls the maximum number of candidate tokens
    
- **top-p** controls how much total probability mass is allowed into the pool
    

### Min-P

Min-p is often considered a stronger and more adaptive alternative to top-k and top-p, especially in local-model workflows.

Instead of using a fixed token count or cumulative probability threshold, min-p compares every candidate token to the probability of the top token.

The rule is:

**A token is allowed only if its probability is greater than:**

top token probability × min-p value

So if:

- the top token has probability **0.9**
    
- min-p is **0.1**
    

then any token with probability above **0.09** can stay in the selection pool.

What makes min-p useful is that it adjusts the token pool dynamically:

- when the model is very confident, the cutoff stays high, so the pool stays tighter
    
- when the model is less confident, the cutoff drops, so more options are allowed in
    

That makes min-p feel more adaptive than top-k or top-p. It widens the pool when uncertainty is higher and tightens it when the model already has a very strong guess.

This is one reason min-p has become popular in local model communities.

### Best Way to Think About All of This

None of these settings add knowledge to the model. They only change how the model samples from the knowledge it already has.

What changes is:

- which paths through that knowledge get explored
    
- how far the output drifts from the most likely continuation
    
- how often unusual associations or less-common phrasing appear
    

So the best summary is:

**Temperature changes randomness in token selection.**  
**Top-k, top-p, and min-p change which candidate tokens are available for selection.**

Together, these settings influence:

- predictability
    
- variety
    
- coherence
    
- stylistic range
    
- willingness to make conceptual leaps
    

But they do **not** expand the model’s actual understanding or give it access to new domains.

### Practical Shortcut

A useful rule of thumb:

**Use lower creativity settings for:**

- code
    
- math
    
- legal-style drafting
    
- extraction
    
- strict formatting
    
- high-precision tasks
    

**Use medium settings for:**

- normal writing
    
- summaries
    
- general brainstorming
    
- business writing
    

**Use higher settings for:**

- slogans
    
- creative writing
    
- ideation
    
- alternative angles
    
- more expressive or experimental outputs
    
