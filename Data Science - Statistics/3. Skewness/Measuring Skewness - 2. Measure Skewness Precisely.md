## Understanding the Skewness Formula

A distribution is **skewed** when one tail stretches farther than the other. In other words, the data is not balanced evenly on both sides.

A formal way to measure this is with **skewness**.

## The skewness formula

A common population formula for skewness is:

$$  
\text{Skewness} = \frac{E[(X-\mu)^3]}{\sigma^3}  
$$

This is called the **third standardized moment**.

---

## What the symbols mean

- $X$ = the random variable
- $\mu$ = the mean
- $\sigma$ = the standard deviation
- $E$ = the expected value

---

## What does $E$ mean?

$E$ is not a single data value like $x=5$ or $\mu=10$.

$E$ is an **operator**. It means **expected value**, which is basically the **average** of something.

So in this expression:


$$  
E[(X-\mu)^3]  
$$


the $E$ is telling you:

> take the average of $(X-\mu)^3$

You can think of it like a math instruction.
That means:

> take the average of an expression over the whole distribution

So you do this:

1. take each value $X$
2. subtract the mean $\mu$
3. cube the result
4. **average those cubed values**

So $E[(X-\mu)^3]$ means:

> the average of the cubed deviations from the mean

If you are working with a full population or a theoretical distribution, $E$ refers to that full average.

If you are working with a sample instead, software usually uses a **sample skewness formula** rather than this exact population formula.

---

## Why is the difference raised to the third power?

The third power is used for **two main reasons**.

### 1. It keeps the sign

This is the key idea:

- $(-2)^2 = 4$ → the sign disappears
- $(-2)^3 = -8$ → the sign stays negative

So when values are cubed:
- values **below** the mean contribute **negative** numbers
- values **above** the mean contribute **positive** numbers

That lets skewness show **direction**:
- more pull in the **right tail** gives **positive skewness**
- more pull in the **left tail** gives **negative skewness**

### 2. It gives more weight to extreme values

Cubing makes large deviations matter much more than small ones.

Examples:
- $2^3 = 8$
- $5^3 = 125$

And on the negative side:
- $(-1)^3 = -1$
- $(-2)^3 = -8$
- $(-3)^3 = -27$

So long tails stand out more strongly.

> Skewness uses the third power because cubing keeps the sign and highlights extreme values.

---

## Why not use the second power?

Because squaring does **not** show direction.

For example:
- $(-2)^2 = 4$
- $(2)^2 = 4$

Both become positive, so left and right look the same.

That is why the second power is used for **variance**, which measures **spread**, not asymmetry:

$$  
E[(X-\mu)^2]  
$$

Variance asks:

> How far are values from the mean?

Skewness asks:

> Is one side of the distribution stretching farther than the other?

That is why skewness needs the **third power**.

---

## Why divide by $\sigma^3$?

In the formula

$$  
\text{Skewness} = \frac{E[(X-\mu)^3]}{\sigma^3}  
$$

the $\sigma^3$ standardizes the result.

This matters because $(X-\mu)^3$ has **cubed units**. Dividing by $\sigma^3$ removes those units.

That makes skewness **unitless**, which lets you compare different datasets more fairly.

---

## How to interpret skewness

In general:

- **Skewness = 0** → symmetric
    
- **Skewness > 0** → right-skewed
    
- **Skewness < 0** → left-skewed
    
- a larger absolute value means stronger skew
    

So:

- a large positive skewness means a stronger **right tail**
    
- a large negative skewness means a stronger **left tail**
    

---

## Sample skewness in real data

In real life, you usually work with a **sample**, not an entire population.

Because of that, software usually calculates a **sample skewness statistic**. Different textbooks and programs may use slightly different formulas, but they all aim to do the same thing:

> estimate how asymmetric the distribution is

So even though the population formula uses $E$, the sample version is based on the actual data values you have.

---

## Simpler ways to estimate skewness

There are also simpler formulas that connect skewness to the mean, median, and mode.

### Pearson’s skewness

$$  
\text{Pearson skewness} = \frac{\text{Mean} - \text{Mode}}{\text{SD}}  
$$

### Pearson’s second skewness

$$  
\text{Pearson’s second skewness} = \frac{3(\text{Mean} - \text{Median})}{\text{SD}}  
$$

This second formula turns the **mean vs. median** idea into a rough number.

So instead of only saying:

- mean is larger than median, so the distribution is probably right-skewed
    

you get a simple numeric estimate too.

These formulas are not as complete as the full third standardized moment, but they can be useful shortcuts.

---

## A simple way to remember moments

You can think of moments like this:

- **1st moment**: center
    
- **2nd moment**: spread
    
- **3rd moment**: skewness or asymmetry
    
- **4th moment**: tail heaviness or kurtosis
    

So the **third moment** is the one that naturally captures skewness.

---

## Best practice

Do not rely on only one measure.

It is better to use several clues together:

- **mean vs. median**
    
- **histogram**
    
- **boxplot**
    
- **skewness value**
    

That gives you both a visual and a numeric sense of the distribution’s shape.

---

## Final takeaway

A distribution is skewed when one tail is longer or heavier than the other.

A quick shortcut is:

- **Mean > Median** → usually **right-skewed**
    
- **Mean < Median** → usually **left-skewed**
    

But the formal measure is:

$$  
\text{Skewness} = \frac{E[(X-\mu)^3]}{\sigma^3}  
$$

The main ideas to remember are:

- $E$ means **expected value**, or average over the distribution
    
- the **third power** keeps the sign
    
- the **third power** also emphasizes extreme values
    
- dividing by $\sigma^3$ makes the result unitless
    

A very simple way to remember it is:

> Squaring loses the sign, but cubing keeps it.

For example:

- $(-2)^2 = 4$
- $(-2)^3 = -8$

That is why skewness can show whether a distribution leans to the left or to the right.

If you want, I can also turn this into a more polished **blog-style article** with stronger transitions and slightly more natural teaching tone.