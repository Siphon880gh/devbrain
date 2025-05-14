Aka: Get Started

## Context - What is LD?
In structured data, "LD" in "JSON-LD" stands for ==Linked Data==. JSON-LD is a format for structuring data in a way that is easy for both humans and machines to understand. It uses JSON syntax to represent data in a linked format, making it possible to connect different pieces of information across the web.

---

# 🧠 Beginner’s Guide to Structured Data for SEO and Rich Results

## ✅ What Is Structured Data?

**Structured data** is a standardized way of providing information about a web page and its content — typically using **Schema.org** vocabulary — so that search engines can understand it more effectively. It is usually implemented in **JSON-LD** format inside a `<script>` tag.

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Beginner’s Guide to Structured Data",
  "description": "Learn how structured data improves your site’s visibility with rich results."
}
</script>
```

---

## 🎯 What Can Structured Data Do?

By implementing structured data, your site may be eligible for **enriched or “rich” results** on Google Search.

Here are common types of enriched data:

| Type              | Enriched Display on Google     | Schema Type Example                   |
| ----------------- | ------------------------------ | ------------------------------------- |
| ⭐ Product         | Price, Availability, Reviews   | `Product`, `Offer`, `AggregateRating` |
| 🍽️ Recipe        | Cooking time, calories, rating | `Recipe`                              |
| 📰 Article/News   | Logo, date, breadcrumbs        | `NewsArticle`, `Article`              |
| 📦 FAQ            | Expandable Q&A under snippet   | `FAQPage`                             |
| 📍 Local Business | Address, hours, map link       | `LocalBusiness`                       |
| 🎓 Course         | Provider, length, content      | `Course`                              |
| 📅 Event          | Time, location, ticket info    | `Event`                               |
| 🎬 Movie/TV       | Ratings, cast, trailer         | `Movie`, `TVSeries`                   |
| 🧠 HowTo          | Step-by-step guides            | `HowTo`                               |

----

## 🎓 Learn Now

Learn the syntax and application by reviewing the Structured Data templates for various use cases

Templates:
- [[Structured Data Template - Directory Listing Website]]
- [[Structured Data Template - Product Demo Events Over Zoom]]

Validate your code (Learn through trial and error):
- [[Structured Data - Validation Tools]]

Take on challenges while building out the Data Structure using supported types, per the Schema documentation:
[[Structured Data Documentation - Supported Schema Types]]

---

## 🛠️ Tools for Creating Structured Data

- **[Google’s Structured Data Markup Helper](https://www.google.com/webmasters/markup-helper/)**
- **[Schema.org Validator](https://validator.schema.org/)**
- **[Rich Results Test](https://search.google.com/test/rich-results)**

---

## 📌 Best Practices

- Only mark up **visible** content.
- Stick to **relevant Schema.org types** — don’t force markup.
- Keep your structured data **accurate and updated**.
- Validate with tools after implementing.
