https://en.wikipedia.org/wiki/Amortized_analysis

The symbol is:
![](https://i.imgur.com/FNN6nCI.png)


The amortized analysis is the average performance in the worse case scenario.

So it's like if T(n) is the worse case, then you average it with number of operations n:
```
T(n)/n
```

Gs. Amortized analysis is similar to average case analysis, however it considers probabilistic assumptions. So you may have different categories of operations that are costlier. So you'll be adding T(n) + T(n<sub>1</sub>) + T(n<sub>2</sub>), then dividing by how many operations