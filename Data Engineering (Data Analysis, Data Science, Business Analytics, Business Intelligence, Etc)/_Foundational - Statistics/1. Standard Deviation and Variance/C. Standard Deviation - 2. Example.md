Standard deviation tells you how spread out the data is from the mean.

---

## Example Data

Use this data set:

$$
2,\ 4,\ 4,\ 4,\ 5,\ 5,\ 7,\ 9
$$

---

## 1. Population Standard Deviation

Use this formula:

$$
\sigma = \sqrt{\frac{\sum (x_i - \mu)^2}{N}}
$$

Where:

- $\sigma$ = population standard deviation
- $x_i$ = each value
- $\mu$ = population mean
- $N$ = number of values in the population

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
\frac{32}{8} = 4
$$

### Step 5: Take the square root

$$
\sigma = \sqrt{4} = 2
$$

### Population standard deviation answer

$$
\sigma = 2
$$

---

## 2. Sample Standard Deviation

Use this formula:

$$
s = \sqrt{\frac{\sum (x_i - \bar{x})^2}{n-1}}
$$

Where:

- $s$ = sample standard deviation
- $x_i$ = each value
- $\bar{x}$ = sample mean
- $n$ = number of values in the sample

For this same data:

$$
2,\ 4,\ 4,\ 4,\ 5,\ 5,\ 7,\ 9
$$

### Step 1: Find the sample mean

$$
\bar{x} = \frac{40}{8} = 5
$$

### Step 2: Add the squared distances

$$
\sum (x_i - \bar{x})^2 = 32
$$

### Step 3: Divide by $n-1$

$$
\frac{32}{8-1} = \frac{32}{7} \approx 4.571
$$

### Step 4: Take the square root

$$
s = \sqrt{\frac{32}{7}} \approx \sqrt{4.571} \approx 2.14
$$

### Sample standard deviation answer

$$
s \approx 2.14
$$

---

## Final Answers

- **Population standard deviation:** $\sigma = 2$
- **Sample standard deviation:** $s \approx 2.14$

---

## Why are they different?

The sample standard deviation uses $n-1$ instead of $n$. This makes it a better estimate of the population standard deviation when you only have a sample instead of the full population.