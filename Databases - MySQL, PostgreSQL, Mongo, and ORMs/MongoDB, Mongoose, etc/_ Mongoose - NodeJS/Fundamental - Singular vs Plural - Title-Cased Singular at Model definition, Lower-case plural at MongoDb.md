
Title-Cased Singular at Model definition:
models/User.js:
```
const User = mongoose.model('User', dealSchema);

export default Deal;
```

Lower-case plural at MongoDb. Mongoose will automatically insert the lowercase plural form into MongoDb:
![[Pasted image 20250607231248.png]]

---

**Concerned You Might’ve Made Mistakes in Past Projects?**

For example, suppose you accidentally defined your Mongoose model with a plural name:

```js
const User = mongoose.model('Users', dealSchema);
```

Technically, that's incorrect — Mongoose expects the model name to be singular. You might get called out by an instructor or a more experienced developer.

But don’t panic: Mongoose is smart enough to detect that "Users" is already plural, so it won’t turn it into something awkward like `"userss"` in MongoDB. It’ll simply preserve the name as-is when creating the collection.

Still, stick with the convention: use a **singular** model name like `"User"` and let Mongoose handle the pluralization automatically.
