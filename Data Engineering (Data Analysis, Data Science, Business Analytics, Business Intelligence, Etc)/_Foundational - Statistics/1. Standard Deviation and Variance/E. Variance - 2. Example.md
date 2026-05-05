Variance tells you the average squared distance from the mean.

---

## Example Data

Use this data set:

$$
2,\ 4,\ 4,\ 4,\ 5,\ 5,\ 7,\ 9
$$

---

## 1. Population Variance

Use this formula:

$$
\sigma^2 = \frac{\sum (x_i - \mu)^2}{N}
$$

### Step 1: Find the mean

$$
\mu = \frac{2+4+4+4+5+5+7+9}{8} = \frac{40}{8} = 5
$$

### Step 2: Find each distance from the mean and square it

| Value $x_i$ | $x_i - \mu$ | $(x_i - \mu)^2$ |
|---|---:|---:|
| 2 | -3 | 9 |
| 4 | -1 | 1 |
| 4 | -1 | 1 |
| 4 | -1 | 1 |
| 5 | 0 | 0 |
| 5 | 0 | 0 |
| 7 | 2 | 4 |
| 9 | 4 | 16 |

### Step 3: Add the squared distances

$$
9+1+1+1+0+0+4+16 = 32
$$

### Step 4: Divide by $N$

$$
\sigma^2 = \frac{32}{8} = 4
$$

### Population variance answer

$$
\sigma^2 = 4
$$

---

## 2. Sample Variance

Use this formula:

$$
s^2 = \frac{\sum (x_i - \bar{x})^2}{n - 1}
$$

### Step 1: Find the sample mean

$$
\bar{x} = \frac{40}{8} = 5
$$

### Step 2: Add the squared distances

$$
\sum (x_i - \bar{x})^2 = 32
$$

### Step 3: Divide by $n - 1$

$$
s^2 = \frac{32}{8 - 1} = \frac{32}{7} \approx 4.57
$$

### Sample variance answer

$$
s^2 \approx 4.57
$$

---

## Final Answers

- **Population variance:** $\sigma^2 = 4$
- **Sample variance:** $s^2 \approx 4.57$

---

## Important Note

Variance is in **squared units**, not the original units.

That is why people often use **standard deviation**, which is the square root of variance and goes back to the original units.