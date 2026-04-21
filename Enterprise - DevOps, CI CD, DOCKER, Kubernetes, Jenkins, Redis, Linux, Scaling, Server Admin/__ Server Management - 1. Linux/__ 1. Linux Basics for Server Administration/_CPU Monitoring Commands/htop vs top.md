### `top` vs `htop` (with context)

Both `top` and `htop` are real-time system monitoring tools that **show running processes ranked by CPU usage (highest to lowest)**. They’re commonly used when your server feels slow or CPU usage spikes and you want to quickly see what’s causing it.

---

### `top`

- Built-in on almost every Linux system
    
- Displays processes sorted by CPU usage by default
    
- Text-based and less intuitive
    
- Keyboard-driven (you press keys like `P`, `M`, etc. to sort)
    
- Lightweight and always available
    

---

### `htop`

- Improved, more user-friendly version of `top` (needs install)
    
- Shows the same CPU-ranked processes, but with:
    
    - Color-coded CPU, memory, and swap bars
        
    - Scrollable process list
        
    - Mouse support (click to interact)
        
- Easy to:
    
    - Kill processes (`F9`)
        
    - Search (`/`)
        
    - Sort (just click or use function keys)
        
- Can show process trees (parent/child relationships)
    

---

### **MNEMONIC**: What does the “h” in `htop` stand for?

It’s not officially defined, but commonly understood as:

👉 **“human-friendly” top**

Basically, it’s `top` made easier to use.

---

### Quick takeaway

- `top` → default, minimal, always there
- `htop` → clearer, faster to use, better for real debugging