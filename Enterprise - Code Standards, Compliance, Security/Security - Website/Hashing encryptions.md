
## ❌ BAD

Hashing can be vulnerable **if you use weak or outdated methods**, such as:
- **MD5** or **SHA1** (fast and broken — easily brute-forced or rainbow-tabled)
- No salt, or same salt for every user

**These _can_ be reverse engineered** with lookup tables and modern GPUs.

---

## ✅ GOOD

**bcrypt, Argon2, or password_hash()** in PHP = secure, not reversible

---

## 🔮 FUTURE

But one quantum computing becomes accessible, they will be cracked too. Even RSA public/private keys will be easily cracked with quantum computing.