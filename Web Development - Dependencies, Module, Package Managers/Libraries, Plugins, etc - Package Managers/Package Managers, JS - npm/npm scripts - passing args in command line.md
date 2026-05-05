## Passing Multiple Arguments to an NPM Script

If you need to pass multiple arguments to an NPM script, follow these steps:

### 1️⃣ Define the Script in `package.json`

Add a script inside the `package.json` file:

```json
{
  "scripts": {
    "test": "node -e \"console.log(process.argv.slice(2))\""
  }
}
```

- This script runs a simple Node.js command that prints all arguments passed after `npm run test`.

### 2️⃣ Run the Script with Arguments

Execute the script from the terminal like this:

```sh
npm run test -- "$(pwd)" STRING_1 STRING_2
```

### 🔍 Explanation:

- `--` tells NPM that everything after it should be treated as arguments.
- `$(pwd)` passes the current working directory.
- `STRING_1` and `STRING_2` are example arguments.

### 📝 Example Output:

If your current directory is `/home/user`, running the command might output:

```sh
[ '/home/user', 'STRING_1', 'STRING_2' ]
```

Now, your script can easily handle multiple arguments! 🚀


---

## $(pwd) vs `pwd`

Using backticks (`` `pwd` ``) works similarly to `$(pwd)`, but `$(pwd)` is the **recommended** approach. Here’s why:

---

### 🔍 Difference Between `` `pwd` `` and `$(pwd)`

#### ✅ Using `$(pwd)` (Preferred)

```sh
npm run test -- "$(pwd)" STRING_1 STRING_2
```

- `$(pwd)` **executes** `pwd` and inserts the result.
- It correctly handles spaces in directory names.
- It is more **readable** and **nestable** (e.g., `$(command1 $(command2))`).

#### ✅ Using Backticks `` `pwd` `` (Works, but not Recommended)

```sh
npm run test -- "`pwd`" STRING_1 STRING_2
```

- Backticks **also execute** `pwd` and insert the result.
- However, backticks are **harder to read** and **nesting them is tricky**.
    - Example: `` `command1 `command2 `` `` (confusing and error-prone).
- They are considered **older syntax**, while `$(...)` is **modern and preferred**.

#### ❌ Without Quotes (Problematic)

```sh
npm run test -- `pwd` STRING_1 STRING_2
```

- If your directory contains spaces (e.g., `/Users/My Folder`), the argument will break:
    - It will be treated as **multiple arguments** instead of one.
    - Example:
        
        ```sh
        npm run test -- /Users/My Folder STRING_1 STRING_2
        ```
        
        - This incorrectly passes `/Users/My` and `Folder` as two separate arguments.

### 🏆 Conclusion:

✅ **Use `$(pwd)`** for modern, safe, and readable scripting. 🚀