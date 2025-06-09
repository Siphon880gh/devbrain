
When this occurs: After scraping.

### 🧼 **What are the Data Artifacts**

Data artifacts refer to unintended or extraneous characters, symbols, or formatting issues that appear in data — often as a result of scraping, parsing errors, encoding mismatches, or inconsistent input sources.

These artifacts can include things like:
- `\xa0` (non-breaking spaces),
- strange quote marks (e.g., `â€œ` instead of `"`)
- leftover HTML tags (`<br>`, `&nbsp;`)
- repeated characters, broken lines, or truncation glitches.

Data cleaning is often required after scraping** to remove these artifacts and ensure consistency, especially before feeding the data into a model, analysis pipeline, or UI.

---

### 🧼 **Data Cleaning Checklist**

#### 🔣 **Character & Encoding Fixes**

-  Remove or replace non-breaking spaces (`\xa0`, `&nbsp;`)
-  Convert smart quotes or weird encoding artifacts (`â€œ` → `"`)
-  Normalize unicode characters (e.g., using Python’s `unicodedata.normalize`)
-  Strip invisible or control characters (`\u200b`, `\x00`, etc.)

#### 🔍 **HTML & Markup Cleanup**

-  Remove HTML tags (`<div>`, `<br>`, etc.)
-  Decode HTML entities (`&amp;`, `&lt;`, etc.)
-  Remove inline styles, scripts, or comments

#### 📏 **Whitespace & Line Breaks**

-  Trim leading/trailing whitespace
-  Collapse multiple spaces/tabs into one
-  Normalize line endings (e.g., `\r\n` → `\n`)

#### 🗑️ **Noise Removal**

-  Drop boilerplate or navigation text (like "Subscribe", "Read More", etc.)
-  Remove timestamps, footers, or auto-generated junk
-  Strip repeated headers or watermarks
    
#### 📐 **Formatting & Structure**

-  Normalize case (e.g., title case or lower case)
-  Standardize number/date formats
-  Detect and fix truncated or merged text
-  Split/join improperly parsed fields

#### 🧪 **Sanity Checks**

-  Validate against known patterns (e.g., emails, URLs, currency)
-  Check for duplicates or near-duplicates
-  Log or flag empty or suspiciously short entries

---


### After Cleaning

After **cleaning**, you typically move into the **"Transform" and "Load"** stages of **ETL (Extract, Transform, Load)**. Here's how it fits in:

#### 🛠️ **Where Cleaning Fits in ETL**

|Step|Description|
|---|---|
|**Extract**|Pull raw data from sources (e.g. websites, APIs, databases).|
|**Clean**|_[Part of Transform]_ Remove artifacts, standardize formats, fix structure.|
|**Transform**|Apply business logic: enrich, reformat, join datasets, deduplicate, etc.|
|**Load**|Insert final clean data into a target system (database, data warehouse, etc).|

#### ✅ **Typical Next Steps After Cleaning**

After removing junk and normalizing data:

1. **Transform:**
    - Standardize column names and data types
    - Convert text to structured formats (e.g., extract JSON from HTML blobs)
    - Join/merge with reference data (e.g., country codes → country names)
    - Create calculated fields (e.g., `age` from `birthdate`)
    - Handle nulls or missing values
        
2. **Validate:**
    
    - Run tests for schema correctness
    - Ensure value distributions make sense
    - Check for business rule violations (e.g., "price must be > 0")
        
3. **Load:**
    - Save to a database (PostgreSQL, MongoDB, etc.)
    - Export to CSV/JSON files
    - Push to a data warehouse (e.g., BigQuery, Snowflake)
    - Index into a search engine (e.g., Elasticsearch)