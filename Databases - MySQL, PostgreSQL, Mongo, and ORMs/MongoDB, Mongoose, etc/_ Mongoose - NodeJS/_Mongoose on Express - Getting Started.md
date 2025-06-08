## 🧩 Step-by-Step Guide: Mongoose with Express + MongoDB

### 1. **Install Mongoose**

```bash
npm install mongoose
```

---

### 2. **Connect to MongoDB**

Use `mongoose.connect()` with options like `useUnifiedTopology` for stable, modern connections:

```js
mongoose.connect('mongodb://localhost:27017/yourDb', {
  useNewUrlParser: true,
  useUnifiedTopology: true
});
```

> Unified topology improves reconnections, cluster handling, and modern URI support.

---

### 3. **Define Schema & Model**

Create your Mongoose schema and compile it into a model:

```js
const userSchema = new mongoose.Schema({
  name: String,
  email: String,
  age: Number
});

const User = mongoose.model('User', userSchema); // becomes collection "users"
```

> Collections are auto-created when you insert the first document.

---

### 4. **Integrate with Express**

Use the model in your route handlers:

```js
app.get('/users', async (req, res) => {
  const users = await User.find();
  res.json(users);
});

app.post('/users', async (req, res) => {
  const newUser = new User(req.body);
  const savedUser = await newUser.save();
  res.status(201).json(savedUser);
});
```

> See full Express + Mongoose example.

---

### 5. **Use One Connection by Default**

Most apps use a single Mongoose connection. Models created via `mongoose.model()` are tied to this connection.

---

### 6. **Advanced: Multiple Connections**

If using multiple databases:

```js
const db1 = mongoose.createConnection('mongodb://localhost:27017/db1');
const UserDb1 = db1.model('User', userSchema);
```

> Use `.model()` on each connection object—not `mongoose.model()`—for proper DB targeting.

---

## ✅ Summary

|Step|Action|
|---|---|
|1|Install Mongoose|
|2|Connect using `mongoose.connect()`|
|3|Define Schema & Model|
|4|Use in Express routes|
|5|Rely on single global connection (or use `createConnection` for multiple DBs)|

---

Let me know if you want a sample boilerplate project layout or starter repo!