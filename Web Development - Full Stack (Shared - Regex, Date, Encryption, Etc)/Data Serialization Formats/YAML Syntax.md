
Example:
```
site:
  name: "Example Studio"
  url: "https://www.example.com"
  location: "City, State"

seo:
  meta_title: "Studio Services with On-Site Support"
  meta_description: "Reserve a studio session with on-site support. Audio, video, and livestream options available."
  canonical_url: "https://www.example.com/studio"

content:
  hero_heading: "Studio Session + Support Included"
  hero_subheading: |
    Show up and create—support is handled.
    Audio, video, lighting, and livestream help available.
  call_to_action:
    label: "Reserve a Session"
    href: "/reserve"

features:
  - "On-site technician"
  - "Multi-camera video"
  - "Livestream add-on"
  - "Editing available"
```

## YAML syntax walkthrough (using the sample)

### 1) It’s all `key: value`

A **key** is the label on the left. A **value** is the data on the right.

```yaml
site:
  name: "Example Studio"
```

- `site:` is a key whose value is a **nested object** (a map).
    
- `name:` is another key inside `site`.
    

### 2) Indentation creates structure

YAML uses **spaces** to show nesting.

```yaml
site:
  name: "Example Studio"
  url: "https://www.example.com"
```

Everything indented under `site:` belongs to `site`.

Rule of thumb: pick an indent size (commonly **2 spaces**) and be consistent. Avoid tabs.

### 3) Strings: when to use quotes

You _can_ write simple strings unquoted, but quotes prevent “surprises.”

```yaml
meta_title: "Studio Services with On-Site Support"
```

Use quotes when the value contains:

- `:` (colon)
    
- `#` (can start a comment)
    
- leading/trailing spaces
    
- lots of punctuation
    
- something that might look like a boolean/number (`yes`, `no`, `on`, `123`)
    

### 4) Lists use hyphens `-`

A list is a set of items:

```yaml
features:
  - "On-site technician"
  - "Multi-camera video"
```

- `features:` is the key
    
- each `- ...` is one item in the list
    

### 5) Multi-line text: `|`

`|` means “literal block scalar” = **keep line breaks exactly**.

```yaml
hero_subheading: |
  Show up and create—support is handled.
  Audio, video, lighting, and livestream help available.
```

The stored value includes the newline between the two lines.

### 6) The colon gotcha (red squiggles)

If your value includes a colon and it’s **not** quoted, the YAML parser/editor can think you’re starting a new key.

Risky:

```yaml
meta_description: Book now: support included
```

Safe:

```yaml
meta_description: "Book now: support included"
```

If you see a red squiggly underline, wrapping the whole value in **double quotes** is usually the fastest fix.

### 7) Comments start with `#`

Anything after `#` is ignored unless it’s inside quotes:

```yaml
meta_title: "Studio Services" # shown in browser tab
```