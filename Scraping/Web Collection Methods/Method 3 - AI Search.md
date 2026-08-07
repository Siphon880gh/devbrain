Part of: [[_PRIMER - Four Ways to Scrape the Web]]

**Question it answers:** "What exists on the web about X?"  
**Input:** Natural-language query  
**Output:** Ranked URLs + snippets (citation-ready for LLMs)

---

## What it is

AI search APIs are built for **LLM workflows**. You send a natural-language question; you get back titles, URLs, and snippets optimized for downstream summarization.

This is **not** the same as pasting a URL into a fetch call ([[Method 1 - Direct HTTP Fetch]] / [[Method 2 - URL Scraping API]]).

Example question AI search answers well:

> "Who are the top coworking operators in Austin and what do they charge?"

Contrast with keyword SERP ranking → [[Method 4 - Google Search API (SERP)]] · [[FAQ - Web Collection Methods]]

---

## How AI search powers an AI scraper

Typical agent pipeline (full write-up: [[Pipeline - Discover, Fetch, Extract, then Summarize]]):

1. **AI Search** — discover relevant URLs and context snippets from a business question
2. **URL Scraping API or Direct Fetch** — retrieve full page content for top results
3. **LLM extraction** — pull structured fields (price, features, headcount signals)
4. **Memory / report** — write findings to a briefing doc or dashboard

Step 1 without Step 2 gives you summaries without primary-source verification.  
Step 2 without Step 1 means you already knew every URL — fine for monitoring, useless for open-ended research.

---

## Providers

→ [[Providers - AI Search APIs]]

| Provider | Pricing (approx.) | Strength |
|----------|-------------------|----------|
| [Tavily](https://tavily.com) | 1k free/mo · ~$5/1k | Agent-native; LangChain/LlamaIndex friendly; citation-ready snippets |
| [Exa](https://exa.ai) | Free tier · ~$7/1k | Neural/semantic search; strong for technical docs and research papers |
| [You.com](https://you.com/platform) | $100 credits free | Real-time web + cited research modes |
| [Linkup](https://linkup.so) | Free tier · usage-based | Deep research API with sourced answers and structured outputs |
| [Perplexity](https://www.perplexity.ai/settings/api) | Usage-based | Ranked web results (Search API); also offers Sonar chat models |
| [Jina](https://jina.ai) | 10M tokens free | LLM-optimized search **and** reader stack (`s.jina.ai`) |

**Environment variables:** `TAVILY_API_KEY`, `EXA_API_KEY`, `YDC_API_KEY`, `LINKUP_API_KEY`, `PERPLEXITY_API_KEY`, `JINA_API_KEY`

Enable multiple providers with priority fallback so a single outage does not stall your agents.

---

## Note on vault coverage

This Scraping folder historically covered **fetch/render** tooling (Puppeteer, Crawlbase, proxies) and **scraping Google HTML for SERPs**. AI Search as a discovery layer was missing until this note set — it sits *before* fetch in the BI agent stack.
