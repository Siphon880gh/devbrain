**TLDR**:
- Skip using sed for text manipulation (eg. replacing text recursively on files)
- Instead use perl:
```
find . -type f \( -name "*.php" -o -name "*.html" \) -exec perl -pi -e 's|old_url|new_url|g' {} +
```

---

## What is `sed` and What Can It Do?

`sed` (Stream Editor) is a powerful command-line tool used for text manipulation, particularly for modifying files in place. It can:

- Perform find-and-replace operations on text.
- Process files without loading them entirely into memory (efficient for large files).
- Be used recursively with `find` to modify multiple files at once.

### Why `sed` is Popular

Despite its inconsistencies, `sed` remains widely used because:

#### 1. **Pre-installed on Unix-like Systems**

- Available by default on Linux, macOS (BSD), and BSD-based systems.
- No extra dependencies are needed, making it a convenient choice for quick text processing.

#### 2. **Efficient for Large Files**

- Works as a stream editor, processing text line by line without loading everything into memory.
- In certain cases, it can be faster than alternatives like `awk` or `perl`.

#### 3. **Useful for Shell Scripting & Automation**

- Frequently used in shell scripts (`bash`, `zsh`, etc.).
- Helps with mass text substitution, configuration updates, and log file processing.

#### 4. **Simple Syntax for Common Tasks**

- One-liners like:
    
    ```sh
    sed -i 's/foo/bar/g' file.txt
    ```
    
    make replacements quick and easy.

---

## Why `sed` Differs Between Operating Systems

### 1. **BSD `sed` (macOS) vs. GNU `sed` (Linux)**

- macOS (BSD `sed`) requires `-i ''` (an empty argument) for in-place editing because it expects an explicit backup suffix.
- Linux (GNU `sed`) does not require an empty argument and works with just `-i`.

**Example:**

- macOS:
    
    ```sh
    sed -i '' 's/old/new/g' file.txt
    ```
    
- Linux:
    
    ```sh
    sed -i 's/old/new/g' file.txt
    ```
    

### 2. **Historical Evolution**

- `sed` originated in Unix in the 1970s, and different Unix-like operating systems implemented their own variations.
- BSD and GNU tools evolved separately, leading to syntax differences.

### 3. **Different Defaults**

- **macOS `sed`** is more conservative, requiring explicit backup handling.
- **GNU `sed`** is more permissive, assuming in-place editing without a backup.

---

## **Best Cross-Platform Alternatives**

If you frequently switch between macOS, Linux, and Windows, OR you work in a team with different OS, consider these alternatives:

### 1. **Use Perl (Works Everywhere)**

```sh
find . -type f \( -name "*.php" -o -name "*.html" \) -exec perl -pi -e 's|old_url|new_url|g' {} +
```

✅ Works on Linux, macOS, and Windows (via Git Bash or WSL).

### 2. **Install GNU `sed` on macOS**

- Install GNU `sed` using Homebrew:
    
    ```sh
    brew install gnu-sed
    ```
    
- Use `gsed` instead of `sed`:
    
    ```sh
    gsed -i 's|old_url|new_url|g' file.html
    ```
    

✅ Ensures consistent behavior with Linux.

---

## **Conclusion**

- `sed` is fast, lightweight, and available on most Unix-like systems.
- Its inconsistencies stem from BSD vs. GNU differences.
- For cross-platform consistency:
    - Use `perl` for reliable behavior on all systems.
    - Install GNU `sed` (`gsed`) on macOS for a Linux-like experience.

Would you like a script that detects the OS and selects the appropriate `sed` version automatically? 🚀