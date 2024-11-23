
The `robots.txt` file is a standard text file used by websites to provide instructions to web crawlers about which pages or sections of a site should or should not be crawled. Its syntax and functionality are the same regardless of whether the web server is **Apache**, **Nginx**, or any other server type. However, the way the web server is configured to serve the `robots.txt` file can differ.

### Key Similarities

1. **Content and Format**:
    
    - The `robots.txt` file itself is identical between servers. Its format follows the [Robots Exclusion Protocol](https://www.robotstxt.org/), which is server-agnostic.
    
    Example `robots.txt`:
    
    ```
    User-agent: *
    Disallow: /private/
    Allow: /public/
    ```
    
2. **Location**:
    
    - The file is usually placed in the root directory of the website, such as `/var/www/html/robots.txt`, and accessed via `http://yourdomain.com/robots.txt`.

---

To include multiple `Disallow` directives in a `robots.txt` file, you simply add each `Disallow` line under the relevant `User-agent`. Each `Disallow` specifies a path that you want to block. Here's how to format it:

### Example of Multiple `Disallow` Directives

```plaintext
User-agent: *
Disallow: /private/
Disallow: /temp/
Disallow: /test/
Allow: /public/
```

### Explanation:

- **`User-agent: *`**: Applies the rules to all web crawlers.
- **`Disallow`**: Specifies the directories or files that crawlers are not allowed to access.
- **`Allow`**: Explicitly allows crawling of certain paths, even if a broader rule blocks access.

---

### Advanced Example (Different Rules for Different Crawlers)

You can also define multiple sets of rules for different crawlers:

```plaintext
User-agent: Googlebot
Disallow: /private/
Disallow: /test/

User-agent: Bingbot
Disallow: /sensitive-data/

User-agent: *
Disallow: /backup/
```

### Notes:

- **Order Matters**: Rules are applied based on the `User-agent` they match. The first match determines the rules for a specific crawler.
- **Crawl Delay and Specific Files**: You can also include a crawl delay or block specific files:
    
    ```plaintext
    User-agent: *
    Disallow: /example-directory/
    Disallow: /example-file.html
    ```
    

Feel free to add as many `Disallow` lines as needed!