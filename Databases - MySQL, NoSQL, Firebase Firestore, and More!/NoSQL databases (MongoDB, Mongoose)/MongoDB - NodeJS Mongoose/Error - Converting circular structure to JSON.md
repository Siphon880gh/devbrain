

It’s because the .find operation keeps looping as a ServerSessionPool and you didnt catch it with an async await, so it tries to convert into JSON


![](PYXy3FJ.png)
