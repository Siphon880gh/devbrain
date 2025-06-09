
If a note includes too many solution options (e.g., data providers), you can guide AI by using a prompt like this:

> _“I’ve included an article listing several possible solutions. Please help me choose the best one. If there’s a better option not listed, feel free to suggest it—but first, ask me any questions you need in order to make the best recommendation.”_

Then add context like:

> _“Here’s some information about my business that might help:_  
> _We are a [type of business] targeting [audience/segment] by offering [product/service/value prop].”_

And finally, paste the list of solutions:

```
Here’s the article:
“””
{…}
“””
```

---

The final prompt:
```
I’ve included an article listing several possible solutions. Please help me choose the best one. If there’s a better option not listed, feel free to suggest it—but first, ask me any questions you need in order to make the best recommendation.

Here’s some information about my business that might help:
{_We are a [type of business] targeting [audience/segment] by offering [product/service/value prop]}

Here’s the article:
“””
{…}
“””
```