
**How to use**: Turn on persistent "Table of Contents"
**Why TOC**: This is a very dense document with a lot of sections

---

## 🏢 Structured Data for a Directory Website

A **directory site** (e.g. for doctors, lawyers, restaurants, etc.) can use structured data to make listings rich and searchable.

### Example Use Case: A Local Business Directory

**What you can mark up:**

|Feature|Schema Type|Benefit in SERP|
|---|---|---|
|Each listing’s business|`LocalBusiness`|Shows hours, phone, address|
|Reviews or ratings|`AggregateRating`|Shows star ratings|
|Business category|`Organization`, `ProfessionalService`, etc.|Enables filtering by business type|
|Events hosted|`Event`|Shows upcoming events for a venue|
|Location|`Place`, `PostalAddress`|Enables map pin or nearby filtering|
|FAQ about services|`FAQPage`|Displays collapsible Q&A|

### Sample JSON-LD for One Business in a Directory

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Jane's Organic Café",
  "image": "https://example.com/logo.jpg",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "123 Green Ave",
    "addressLocality": "Santa Monica",
    "addressRegion": "CA",
    "postalCode": "90401",
    "addressCountry": "US"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.7",
    "reviewCount": "135"
  },
  "telephone": "+1-310-555-0199",
  "openingHours": "Mo-Sa 08:00-18:00"
}
</script>
```


---

# 🏠 Structured Data for a Directory Site Homepage

The **homepage** often represents the directory itself — not an individual listing — so we use the `WebSite` and optionally `Organization` or `SearchAction` types.

### ✅ Example: Homepage with Search Functionality

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "CityCare Directory",
  "url": "https://citycare.example.com",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://citycare.example.com/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
```

You can pair that with:

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "CityCare",
  "url": "https://citycare.example.com",
  "logo": "https://citycare.example.com/logo.png",
  "sameAs": [
    "https://www.facebook.com/CityCare",
    "https://twitter.com/CityCare"
  ]
}
</script>
```

---

# 📄 Structured Data for Search Result Pages (Listings)

Search results pages often show **multiple businesses**. While Google doesn’t index markup for all listings on a single page, it’s still best practice to include schema per business in a structured and clean way.

> ⚠️ Pro Tip: Only show structured data for listings that are visible on the page.

---

### ✅ Example: Multiple Businesses (e.g., Restaurants in Santa Monica)

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "LocalBusiness",
      "name": "Fresh Green Bowl",
      "image": "https://example.com/images/greenbowl.jpg",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "123 Main St",
        "addressLocality": "Santa Monica",
        "addressRegion": "CA",
        "postalCode": "90401",
        "addressCountry": "US"
      },
      "telephone": "+1-310-555-0123",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.5",
        "reviewCount": "82"
      }
    },
    {
      "@type": "LocalBusiness",
      "name": "Ocean Thai Kitchen",
      "image": "https://example.com/images/oceanthai.jpg",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "456 Ocean Ave",
        "addressLocality": "Santa Monica",
        "addressRegion": "CA",
        "postalCode": "90401",
        "addressCountry": "US"
      },
      "telephone": "+1-310-555-0456",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "120"
      }
    }
  ]
}
</script>
```

This format uses `@graph` to combine multiple objects in one script block.

---

## 🧱 Next Step Suggestions

Would you like templates for:

- 🧑‍⚕️ Individual business profile page (single local business with reviews)?
    
- ❓ FAQ schema for a business or service?
    
- 📅 Event schema for businesses hosting events (great for venues, gyms, etc.)?
    
- 🧰 JSON-LD generator tailored to your use case?
    

Let me know and I’ll tailor the next section!

---

# 🔎 Structured Data for an Individual Business Profile Page

When a user clicks on a listing from your directory (e.g., “Ocean Thai Kitchen”), they land on a **dedicated business profile page**. This page should include **rich structured data** specific to that business.

## 🎯 Why It Matters

This type of schema helps search engines:

- Display star ratings and reviews in search
- Show contact info directly in Google results
- Display business hours and service areas
- Connect users to map directions, menus, or booking actions

## ✅ Recommended Schema Types

|Type|Purpose|
|---|---|
|`LocalBusiness`|Core business details|
|`PostalAddress`|Physical address|
|`AggregateRating`|Average user review score|
|`OpeningHoursSpecification`|Weekly hours of operation|
|`Review` (optional)|Individual user reviews|
|`Menu` or `hasMenu`|Link to menu (restaurants only)|
|`SameAs`|Social or third-party profiles|

## 📦 Example JSON-LD: Restaurant Profile Page

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "Ocean Thai Kitchen",
  "image": "https://example.com/images/oceanthai.jpg",
  "description": "Authentic Thai cuisine with ocean views in Santa Monica.",
  "url": "https://directory.example.com/ocean-thai-kitchen",
  "telephone": "+1-310-555-0456",
  "priceRange": "$$",
  "servesCuisine": "Thai",
  "hasMenu": "https://directory.example.com/ocean-thai-kitchen/menu",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "456 Ocean Ave",
    "addressLocality": "Santa Monica",
    "addressRegion": "CA",
    "postalCode": "90401",
    "addressCountry": "US"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "120"
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      "opens": "11:00",
      "closes": "21:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Saturday", "Sunday"],
      "opens": "12:00",
      "closes": "22:00"
    }
  ],
  "sameAs": [
    "https://www.facebook.com/oceanthaikitchen",
    "https://www.instagram.com/oceanthaikitchen"
  ]
}
</script>
```



---

## 🧪 Validate and Test

Use validation tools at [[Structured Data - Validation Tools]]

---

### Next up?



Let me know and I’ll expand accordingly.