Aka: Get Started

## Bcrypt

One-way hashing algorithm, not encryption. No need to keep secret. Even if the database dumped by hackers, the hacker can't reverse engineer the hashed passwords to their plain passwords.  

Plain password to hashed password:
```
await bcrypt.hash(user.password, 10);
```
`10` is the salt rounds parameter.

### What does it do?

- The number `10` determines how many times the hashing algorithm will run internally to generate a unique hash. The cost factor (10) means the algorithm runs 2¹⁰ = 1024 iterations internally.
- Higher values make the hash more secure but also slower to compute. A value of `10` is a common choice because it balances security and performance. You can set it higher for better security (e.g., `12` or `14`), but this will slow down hashing.

### Secret seed?

No, bcrypt does not require a secret seed like some other hashing or encryption algorithms. 

Instead, it uses a salt, which is automatically generated if not provided. Bcrypt is designed to protect passwords without needing a separate secret. The hashed password has the seed as part of it already.

Can I provide my own salt? Yes. You still don't need to store it though.  

### The Hashed

A bcrypt hash typically looks like this:
```
$2b$10$JmB9RfwKc7xQeV.LMfZQdeL6gti5K16L8BDn00x5q1PllYAGaXY2C
```

It consists of:

1. Prefix (`$2b$`) – Bcrypt algorithm version.
2. Cost Factor (`10$`) – Work factor (salt rounds).
3. Salt (`JmB9RfwKc7xQeV.LMfZQde`) – Randomly generated per password.
4. Hashed Password (`L6gti5K16L8BDn00x5q1PllYAGaXY2C`) – Final hash output.  

### 🚀 Example:

```
const bcrypt = require('bcrypt');  // Hash password (salt included in result) const hashedPassword = await bcrypt.hash("mypassword", 10); console.log(hashedPassword);  // Later, verify the password const isMatch = await bcrypt.compare("mypassword", hashedPassword); console.log(isMatch); // true if correct, false otherwise
```

---

## 🔒 Why bcrypt hashes can't be reversed

Even though the hash contains the cost factor (rounds) and salt, bcrypt is a one-way function due to how it processes passwords:

### 1️⃣ Each Hash is Computed Iteratively

- Bcrypt applies the hashing function multiple times (e.g., 2¹⁰ = 1024 times for cost factor 10).
- Each iteration modifies the result, making it increasingly difficult to derive the original input.

### 2️⃣ The Output is Truncated

- Bcrypt intentionally discards parts of the intermediate hash at each round.
- This means some information is lost, making it impossible to reverse.

### 3️⃣ Hashing is Non-Reversible by Design

- Hashing functions (including bcrypt) do not encrypt data; they transform it in a way that cannot be undone.
- Even though you know:
    
    - The cost factor (number of rounds)
    - The salt (randomized per hash)
    
    You still don’t know the original password because each transformation step loses original data.

**Brute-Force Time Calculation**

Let’s say a **high-end GPU** can compute **1 million bcrypt hashes per second** at **cost factor 10**.

### **Example: Cracking a 10-character password**

1. Suppose the character set is **95 possible characters** (uppercase, lowercase, digits, symbols).
    
2. A **10-character password** has:
    
    9510=5.987×1019 (possible passwords)9510=5.987×1019 (possible passwords)
3. If an attacker can compute **1,000,000 bcrypt hashes per second**:
    
    5.987×1019106=5.987×1013 seconds1065.987×1019​=5.987×1013 seconds
4. Converting to years:
    
    5.987×101360×60×24×365≈1.9 million years60×60×24×3655.987×1013​≈1.9 million years

So, even with **1 million guesses per second**, it would take about **1.9 million years** to brute-force a strong 10-character password.