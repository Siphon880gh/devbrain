
#### **Example of `top_p` in Action**

Let's say the model is generating the next word for:  
👉 **"The capital of France is"**

And it predicts these probabilities for possible next words:

|Word|Probability|
|---|---|
|Paris|0.50|
|Lyon|0.15|
|Marseille|0.10|
|Tokyo|0.05|
|London|0.03|
|Other words|0.17|

- **If `top_p = 0.9`**, the model selects from the smallest group of words whose total probability adds up to **90%** (Paris, Lyon, and Marseille).
    - This allows some randomness while keeping the answer mostly correct.
- **If `top_p = 0.5`**, it selects only the top 50% probability words (**Paris only**)—making it very **deterministic**.
- **If `top_p = 1.0`**, it considers **all words**, leading to more diverse but sometimes incorrect or less relevant completions.