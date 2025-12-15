A good way to think about AI browsers, _as long as you’re clear that it’s a mental model for prompting_, not a claim about how any specific product actually works today - is AI browser modes.

This is a **prompting framework layered on top of browser capabilities**. It helps users reason about _how to ask_ an AI browser to do something, assuming the browser has deep integration with the page, tabs, DOM, metadata, CSS, and transcripts.

Below is a refined explanation, followed by **additional “Modes”** that naturally emerge when you assume the browser can do _everything_ in your checklist.

---

## First: Reframe This Clearly for the Reader

> **Important framing**  
> These “modes” are **not product features**. They are a _conceptual framework_ for thinking about how to prompt an AI browser, based on what the browser is capable of doing.
> 
> As AI browsers evolve and gain deeper access to pages, tabs, metadata, CSS, and interaction APIs, these modes become increasingly useable.

---


### 1. Actor Mode

**What it is:**  
Direct, user-like interaction with the page. Think of it as straight forward cases and quick steps, such as filling out forms and macro playing certain user interactions. It operates quickly.

**Characteristics:**

- Clicks, types, scrolls, submits
    
- Waits for UI state changes
    
- Minimal reasoning
    
- Fast execution (step-by-step, ~1 second per action)
    

**Best used when:**

- Filling forms
    
- Exporting reports
    
- Clicking through predictable workflows
    
- Pulling small, well-defined fields
    

**Can the AI browser run js scripts?**
- In certain situations, it may be necessary to change the DOM or point to a specific DOM by selectors, as if you ran code in the DevTools console. Can the AI browser chat interface run console scripts? If it can't run scripts, is it because DOM modifying scripts are banned but DOM reading scrips are allowed?

**Relies on checklist items:**  
Page interaction, navigation, DOM access, form manipulation

---

### 2. Thinker Mode

**What it is:**  
Goal-oriented reasoning where the AI figures out _how_ to achieve an outcome.  Can handle broad or "fuzzy" goals". One of its approaches is breaking down the goal into actionable steps.

**Characteristics:**

- Breaks fuzzy goals into steps
    
- Chooses which tabs to open
    
- Decides what to read or extract
    
- Slower, more deliberative
    

**Best used when:**

- Researching a topic
    
- Comparing products or pages
    
- Exploring unfamiliar sites
    
- “Figure this out for me” requests
    

**Relies on checklist items:**  
Multi-tab awareness, navigation, data extraction, transcript detection

---

### 3. Tasker Mode (Deterministic Mode)

**What it is:**  
Execution of a **predefined, explicit procedure**.

**Characteristics:**

- You provide an ordered list of steps
    
- No improvisation
    
- Retries and failure handling
    
- Auditable and repeatable
    

**Best used when:**

- Accuracy matters more than creativity
    
- You want predictable outcomes
    
- Automating audits or checks
    
**Can the AI browser run js scripts?**
- In certain situations, it may be necessary to change the DOM or point to a specific DOM by selectors, as if you ran code in the DevTools console. Can the AI browser chat interface run console scripts? If it can't run scripts, is it because DOM modifying scripts are banned but DOM reading scrips are allowed?
  
**Relies on checklist items:**  
Full interaction, DOM access, metadata access, CSS extraction, tab control

---

### 4. Reader Mode

**What it is:**  
The AI treats the page as a **document**, not an interface.

**Characteristics:**

- Extracts and restructures content
    
- Ignores layout and UI noise
    
- Focuses on meaning and hierarchy
    

**Example prompts:**

- “Summarize this page as if it were a whitepaper.”
    
- “Extract the main argument and supporting points.”
    

**Relies on:**

- Accurate DOM reading
    
- JavaScript-rendered content
    
- Transcript detection for videos
    

---

### 5. Researcher Mode

**What it is:**  
Workspace-building behavior across tabs.

**Characteristics:**

- Opens multiple results in parallel
    
- Leaves tabs open for inspection
    
- Cross-references sources
    
- Builds a trail you can verify
    

**Example prompts:**

- “Open the top 5 results and compare their pricing tables.”
    
- “Research this topic and leave all sources open.”
    

**Relies on:**

- Multi-tab awareness
    
- Persistent tabs
    
- Navigation and search capability
    

---

### 6. Auditor Mode

**What it is:**  
Systematic inspection of a page’s **non-visible layers**.

**Characteristics:**

- Reads metadata, JSON-LD, schema
    
- Extracts canonical URLs and OG tags
    
- Checks consistency between body and metadata
    

**Example prompts:**

- “Audit this page’s SEO metadata.”
    
- “Compare on-page headings vs structured data.”
    

**Relies on:**

- Meta tag access
    
- Structured data parsing
    
- DOM + head awareness
    

---

### 7. Inspector Mode

**What it is:**  
Developer- and designer-focused analysis.

**Characteristics:**

- Extracts computed CSS values
    
- Identifies fonts, colors, spacing
    
- Traces styles back to variables or stylesheets
    

**Example prompts:**

- “What font and color system does this page use?”
    
- “Extract the primary CSS variables.”
    

**Relies on:**

- CSSOM access
    
- Computed styles
    
- Source tracing (inline vs stylesheet vs variables)
    

---

### 8. Annotator Mode

**What it is:**  
Inline augmentation of the page.

**Characteristics:**

- Highlights sections
    
- Adds notes or overlays
    
- Visually marks issues or suggestions
    

**Example prompts:**

- “Highlight claims that need citations.”
    
- “Mark sections that could be simplified.”
    

**Relies on:**

- DOM manipulation
    
- Overlay injection
    
- Page mutation permissions
    

---

### 9. Instructor Mode

**What it is:**  
The AI uses the page as a **live teaching surface**.

**Characteristics:**

- Step-by-step guidance
    
- UI callouts and explanations
    
- Pauses for user confirmation
    

**Example prompts:**

- “Walk me through how to do this, step by step.”
    
- “Explain each option before I choose.”
    

**Relies on:**

- DOM awareness
    
- Event handling
    
- User-state tracking
    

---

### 10. Archivist Mode

**What it is:**  
Extraction and preservation.

**Characteristics:**

- Pulls clean data from pages
    
- Exports tables, text, transcripts
    
- Structures output for reuse
    

**Example prompts:**

- “Export all pricing tables as CSV.”
    
- “Save the full transcript and key timestamps.”
    

**Relies on:**

- Accurate data extraction
    
- Transcript detection
    
- Structured output generation
    

---

## Why This Framework Is Useful

When AI browsers ship major updates, you can re-evaluate them by asking:

> _Which of these modes just became possible — or more reliable?_

---

## Bottom Line

Your original framing is solid. The key is being explicit that:

- These are **prompting modes**, not product labels
- They depend entirely on **browser-level capabilities**
- Different tasks benefit from **different modes of interaction**

Think of it as a **map of intent**, layered on top of an AI browser’s actual powers.