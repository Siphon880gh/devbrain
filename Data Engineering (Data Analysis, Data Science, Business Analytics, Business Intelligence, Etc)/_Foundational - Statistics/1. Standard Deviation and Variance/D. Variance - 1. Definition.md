![[Pasted image 20260324015314.png]]
^ Above from https://mathmonks.com/variance

---

# Variance

Variance tells you how spread out the data is from the mean.

It measures the **average squared distance** from the mean.

A larger variance means the data is more spread out.  
A smaller variance means the data is closer to the mean.

---

## Population Variance

$$
\sigma^2 = \frac{\sum (x_i - \mu)^2}{N}
$$

Where:

- $\sigma^2$ is the population variance
- $\sum$ is the symbol for summation, meaning add everything that follows
- $x_i$ is a particular value in your data
- $\mu$ is the population mean
- $(x_i - \mu)$ is the distance between a value and the population mean
- $(x_i - \mu)^2$ means that distance is squared
- $N$ is the population size

---

## Sample Variance

$$
s^2 = \frac{\sum (x_i - \bar{x})^2}{n - 1}
$$

Where:

- $s^2$ is the sample variance
- $\sum$ is the symbol for summation, meaning add everything that follows
- $x_i$ is a particular value in your data
- $\bar{x}$ is the sample mean
- $(x_i - \bar{x})$ is the distance between a value and the sample mean
- $(x_i - \bar{x})^2$ means that distance is squared
- $n$ is the sample size

---

## Why is it squared?

The distances are squared so that:

- negative and positive distances do not cancel each other out
- values farther from the mean count more
- the result can be used in other statistics formulas

---

## Population vs. Sample Variance

- Use **population variance** when you have the entire group.
- Use **sample variance** when you only have part of the group and want to estimate the whole population.

When calculating sample variance, we divide by $n - 1$ instead of $n$ to make the estimate more accurate.