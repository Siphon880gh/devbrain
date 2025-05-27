Titled: Look at p-value and test statistic in Hypothesis Testing

In hypothesis testing, we often hear two key terms: the **P-value** and the **test statistic**. Both are critical to determining whether there’s evidence to reject a null hypothesis — but they play different roles.

---

## 🧪 What Is Hypothesis Testing?

Hypothesis testing is a method used to decide whether the evidence in a sample of data is strong enough to reject a general statement (the **null hypothesis**, H₀) about a population.

Every test involves two hypotheses:

- **H₀ (Null Hypothesis)**: There is no effect, no difference, or no relationship.
- **H₁ (Alternative Hypothesis)**: There is an effect, a difference, or a relationship — often the outcome you're testing for.

---

## 🧠 What Is a Test Statistic?

A **test statistic** (e.g., _z_, _t_, _F_, _r_) is a standardized number calculated from sample data. It quantifies how far your sample statistic (like the sample mean or variance) deviates from what you would expect under H₀.

|Symbol|Test Name|Purpose|Example Use Case|
|---|---|---|---|
|**z**|Z-test|Compare sample mean to population mean (σ known)|Average height comparison with known value|
|**t**|T-test|Compare sample means (σ unknown)|Drug group vs. placebo group|
|**F**|F-test / ANOVA|Compare variances or multiple group means|Checking variability between machines|
|**r**|Correlation|Measure strength of a linear relationship|Study hours vs. test scores|

---

## 🎯 What Is a P-Value?

The **P-value** is the **probability** of obtaining a result as extreme as (or more extreme than) the observed one, **if the null hypothesis were true**.
- **Small P-value (e.g., < 0.05)**: Unlikely to have happened by chance → reject H₀.
- **Large P-value (e.g., > 0.05)**: Likely under H₀ → fail to reject H₀.

---

## 🔗 How Test Statistics and P-Values Work Together

1. **You calculate the test statistic** from your data (e.g., _t = 2.10_).
2. **This test statistic corresponds to a P-value**, based on its distribution curve.
3. **You compare the P-value to your significance level** (commonly α = 0.05):
    - If **P ≤ α** → reject H₀ (statistically significant)
    - If **P > α** → fail to reject H₀


> In short: **test statistic** → **P-value** → **decision**

---

## 🧾 Example Table of Hypothesis Tests

|No.|H₀ (Null Hypothesis)|H₁ (Alternative Hypothesis)|Real-World Interpretation (H₁)|Test Statistic|P-Value|Conclusion (α = 0.05)|Example|
|---|---|---|---|---|---|---|---|
|1|μ = 50|μ ≠ 50|The population mean is significantly different from 50|z = 2.12|0.034|Reject H₀|Testing if average exam score ≠ 50 in a school|
|2|p = 0.25|p ≠ 0.25|The proportion is not 25% — there's a shift|z = 1.45|0.147|Fail to reject H₀|Checking if 25% of users click an ad, or if that has changed|
|3|μ₁ = μ₂|μ₁ ≠ μ₂|There is a difference between two group means|t = -0.87|0.391|Fail to reject H₀|Comparing mean blood pressure between treatment and control groups|
|4|σ₁² = σ₂²|σ₁² ≠ σ₂²|The variability differs between the two populations|F = 1.62|0.048|Reject H₀|Comparing consistency of two machines that fill bottles|
|5|ρ = 0|ρ ≠ 0|There is a relationship between variables X and Y|r = 0.82|<0.001|Reject H₀|Investigating if study time is correlated with exam performance|

---

## 🧭 Final Thoughts

- The **test statistic** is the raw score that shows how unusual your data is.
- The **P-value** is the probability of seeing a result that extreme if nothing unusual was happening.
- We use both to make evidence-based decisions.

Together, they form the backbone of modern statistical inference.