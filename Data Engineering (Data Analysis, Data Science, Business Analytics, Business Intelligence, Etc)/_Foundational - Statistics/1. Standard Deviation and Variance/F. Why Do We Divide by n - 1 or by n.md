Titled: Why Do We Divide by n - 1 or by n

You use:
- $N$ for **population variance** and **population standard deviation**
- $n - 1$ for **sample variance** and **sample standard deviation**

In other words:
- use **$N$** when you have the **entire population**
- use **$n - 1$** when you have a **sample** and you are estimating the population spread

That rule applies to **both** variance and standard deviation.

---

## Review the Formulas

### Population Variance

$$
\sigma^2 = \frac{\sum (x_i - \mu)^2}{N}
$$

### Population Standard Deviation

$$
\sigma = \sqrt{\frac{\sum (x_i - \mu)^2}{N}}
$$

### Sample Variance

$$
s^2 = \frac{\sum (x_i - \bar{x})^2}{n - 1}
$$

### Sample Standard Deviation

$$
s = \sqrt{\frac{\sum (x_i - \bar{x})^2}{n - 1}}
$$

---

## Why $n - 1$?

When you use the **sample mean** $\bar{x}$, the data is already pulled a little toward that mean.

That makes the spread look a little too small.

If we divided by $n$, we would usually **underestimate** the true population variance.

Dividing by $n - 1$ helps correct for that.

This is called **Bessel’s correction**.

---

## Why Does This Happen?

Once you know the sample mean, only $n - 1$ values are really free to vary.

For example, suppose the sample mean must be 10.

If you already know the first 4 values in a sample of 5, the last value is forced to be whatever makes the mean stay 10.

So there are only **$n - 1$ degrees of freedom**.

That is why we divide by $n - 1$, not because of the square root.

---

## Important Note

- **Sample variance** with $n - 1$ is an unbiased estimator of population variance
- **Sample standard deviation** also uses $n - 1$, but after taking the square root, it is not perfectly unbiased anymore

So the square root does **not** make it more precise in that way.

The square root mainly changes the units back to the original scale.

---

## Summary

- **Population** formulas use $N$
- **Sample** formulas use $n - 1$
- The square root is **not** the reason for using $n - 1$
- We use $n - 1$ because sample data tends to underestimate the true population spread