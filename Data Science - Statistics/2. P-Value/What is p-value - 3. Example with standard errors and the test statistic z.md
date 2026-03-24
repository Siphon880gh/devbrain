## Example of Finding a P-value

Suppose a school says its students score an average of **70** on a test.

You think the true average is different, so you test:

- **Null hypothesis (H₀):** μ = 70
- **Alternative hypothesis (H₁):** μ ≠ 70

You take a sample and get:

- Sample mean = **75**
- Known population standard deviation = **10**
- Sample size = **25**

## Step 1: Find the standard error

$$
SE = \frac{\sigma}{\sqrt{n}} = \frac{10}{\sqrt{25}} = \frac{10}{5} = 2
$$

## Step 2: Find the z-score

$$
z = \frac{\bar{x} - \mu}{SE} = \frac{75 - 70}{2} = \frac{5}{2} = 2.5
$$

So the sample mean is **2.5 standard errors above** the mean predicted by the null hypothesis.

## Step 3: Find the P-value

For **z = 2.5**:

- Area to the right is about **0.0062**

Since this is a **two-tailed test** $(\mu \ne 70)$, multiply by 2:

$$
P = 2(0.0062) = 0.0124
$$

## Final answer

$$
P \approx 0.0124
$$

That means:

**If the true mean really were 70, there would be about a 1.24% chance of getting a sample result this far from 70 or farther just by random chance.**

## Conclusion

Because **0.0124 < 0.05**, the result is unusual enough that we would usually **reject the null hypothesis**.

## In plain English

- The null hypothesis said the average is **70**
- Your sample gave **75**
- That difference was large enough that it would be pretty unlikely under H₀
- So the P-value came out small