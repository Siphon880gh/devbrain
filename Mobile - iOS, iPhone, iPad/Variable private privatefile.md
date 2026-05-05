
Control flow - private and fileprivate variables

These two forms of access control are similar, but there are two differences.

If you mark something fileprivate it can be read anywhere in the same file it was declared – even outside the type [hence namesake fileprivate, as in private to file] On the other hand, a private property can only be read inside the type that declared it, or inside extensions to that type that were created in the same file. 

In practice you’re likely to see private used significantly more than fileprivate.

If you want a let variable that's also fileprivate, you code it as:L
```
fileprviate let someVariable = ...
```
