Newer OpenAI models (like o3, 4o-mini, etc.) sometimes emit **non-standard Unicode characters** that can break JSON, HTML, or downstream tooling if you aren’t sanitizing their output.

This isn’t documented as an official “watermarking” scheme; it’s mostly a side-effect of training on messy real-world text. But you _do_ need to code around it.

---

## 1. What kind of weird characters?

You’ll commonly see:

### Spaces / whitespace

- **Narrow no-break space**: `U+202F`
- **Non-breaking space**: `U+00A0` (NBSP)
- **Zero-width characters**: `U+200B`, `U+200C`, `U+200D`, `U+2060`, `U+FEFF`
- Other odd spaces: em space, en space, thin space, etc. (`U+2000–U+200A`)

These look like normal spaces (or are invisible), but they are _different code points_.

**Impact:**
- Splitting on `" "` doesn’t work as expected.
- Keys like `"user id"` (with U+202F) don’t match `"user id"` (ASCII).
- CSS or HTML can break if these appear in selectors, class names, attributes, or inside `<style>` blocks.

---

### Smart punctuation

- “ ” (curly double quotes)
- ‘ ’ (curly single quotes)
- – (en dash), — (em dash)

**Impact:**

- JSON becomes invalid if keys or strings are wrapped in curly quotes instead of `"` or `'`.
- CSS property names can break if a dash turns into `–`/`—` instead of `-`.

---

### Control characters & malformed escapes

You may also encounter:

- Control chars, e.g., `\u0005`, `\u0010` inside strings.
- Broken Unicode escapes, e.g., `\u20` instead of `\u0020`, or `\xA0` in what looks like JSON.

**Impact:**

- Strict JSON parsers reject the payload.
- Tools that assume “well-formed UTF-8 + proper `\uXXXX` escapes” can crash or silently misbehave.

---

## 2. How this bites you in real life

### 2.1 JSON / structured output

Common failure modes:

- The model returns something that _looks_ like JSON:
    ```json
    {
      “title”: “Hello”,
      “ok”: true
    }
    ```
    
    but those quotes are U+201C / U+201D, so `JSON.parse()` fails.
    
- Hidden NBSP or narrow spaces in keys:
    ```json
    { "user id": 123 }
    ```
    
    You try to read `"user id"` and get `undefined`.
    
- Invalid escapes:
    ```json
    { "space": "\u20" }  // not valid JSON
    ```
    
    Your JSON parser throws, even though the payload looks “fine” in a text editor.

---

### 2.2 HTML / CSS

When you ask the model for full HTML templates:

- **CSS rules get ignored** if the selector or property name contains an em space, zero-width char, or non-standard dash:
    ```css
    .stylе-block {
      color: red;
    }
    ```
    
    If one of those letters is a look-alike Unicode char, the browser may drop the rule.
    
- **Inline `style` attributes** and `<style>` blocks can fail partially or completely if a bad character appears in a critical spot (e.g., in `font-family`, `background-color`, or around `{` / `}`).
    

From your perspective: “I pasted the HTML, but the styles don't apply.”

---

## 3. Detection & cleanup strategies

Treat model output as _untrusted text_. Always sanitize before parsing or rendering.

### 3.1 Basic JS sanitizer

```js
// Replace exotic spaces with normal spaces
// Also covers em spaces
function normalizeSpaces(str) {
  return str
    // NBSP, narrow NBSP, and most Unicode spaces
    .replace(/[\u00A0\u202F\u2000-\u200B\u2060]/g, ' ')
    // Collapse runs of whitespace
    .replace(/\s+/g, ' ')
    .trim();
}

// Strip zero-width characters entirely
function stripZeroWidth(str) {
  return str.replace(/[\u200B-\u200D\uFEFF]/g, '');
}

// Replace smart punctuation with ASCII
function asciiPunctuation(str) {
  const map = {
    '“': '"', '”': '"',
    '‘': "'", '’': "'",
    '–': '-', '—': '-',
  };
  return str.replace(/["“”‘’–—]/g, ch => map[ch] ?? ch);
}
```

Typical flow for JSON:

1. `asciiPunctuation`
2. `stripZeroWidth`
3. `normalizeSpaces` (optional, depending on how strict you want to be)
4. Then `JSON.parse`

---

### 3.2 Python example

```python
import re

SPACE_RANGE = r'[\u00A0\u202F\u2000-\u200B\u2060]'
ZERO_WIDTH_RANGE = r'[\u200B-\u200D\uFEFF]'

def normalize_spaces(text: str) -> str:
    text = re.sub(SPACE_RANGE, ' ', text)
    return re.sub(r'\s+', ' ', text).strip()

def strip_zero_width(text: str) -> str:
    return re.sub(ZERO_WIDTH_RANGE, '', text)

def ascii_punctuation(text: str) -> str:
    replacements = {
        '“': '"', '”': '"',
        '‘': "'", '’': "'",
        '–': '-', '—': '-',
    }
    for k, v in replacements.items():
        text = text.replace(k, v)
    return text
```

You can wrap this logic in a “sanitize LLM output” utility and run it on every response before using it.

---

## 4. Hardening your ChatGPT API integration

### 4.1 Use structured outputs/JSON modes whenever possible

- Prefer model features that enforce JSON/structured output (e.g., JSON mode / schemas) over “Please return valid JSON” in natural language.
- Still sanitize _inside_ string fields (they can still contain weird characters) but you’ll avoid syntax-level breakage.

### 4.2 Prompt-level constraints (helpful, not sufficient)

Add system/instruction hints like:

- “Use only straight quotes (`\"` and `'`) and ASCII hyphen (`-`).”
- “Do not use smart quotes or fancy dashes.”
- “Avoid non-breaking or zero-width spaces; use normal spaces only.”

This reduces incidents, but doesn’t fully eliminate them. Don’t rely on prompts alone.

---

### 4.3 Always post-process before parsing or rendering

For anything structured:

- **JSON / YAML / CSV:**
    
    - Run through a sanitizer.
        
    - Parse with a strict parser.
        
    - On error, log the raw output and model version.
        
- **HTML / CSS / templates:**
    
    - Sanitize, then optionally run through a linter or tolerant parser.
        
    - If something breaks visually, check for weird Unicode in the `<style>` block and attribute names.

---

### 4.4 Monitor when you change models

When you move from one model to another (e.g., `gpt-4o-mini` → `o3`):

- Log a sample of responses.
- Automatically scan for:
    - NBSP / narrow NBSP
    - Zero-width characters
    - Smart quotes / em dash
- Alert or sample responses if counts spike.

This catches regressions early before users see broken JSON or unstyled pages.

---

## 5. TL;DR for API devs

- **Yes**, ChatGPT models sometimes emit non-standard Unicode: NBSP, narrow NBSP, zero-width chars, smart quotes, odd dashes, etc.
    
- This can **silently break JSON, keys, HTML/CSS, and downstream tools**.
    
- Solution:
    
    - Use structured/JSON modes where possible.
    - Run all model output through a **sanitizer** (normalize spaces, remove zero-width, convert smart punctuation).
    - Validate and parse _after_ sanitization.
    - Monitor behavior when upgrading models.
