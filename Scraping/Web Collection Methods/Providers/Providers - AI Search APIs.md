# Providers — AI Search APIs

Method: [[Method 3 - AI Search]] · Quick ref: [[Quick Reference - All APIs by Method]]

---

| Provider | Pricing (approx.) | Strength |
|----------|-------------------|----------|
| [Tavily](https://tavily.com) | 1k free/mo · ~$5/1k | Agent-native; LangChain/LlamaIndex friendly; citation-ready snippets |
| [Exa](https://exa.ai) | Free tier · ~$7/1k | Neural/semantic search; strong for technical docs and research papers |
| [You.com](https://you.com/platform) | $100 credits free | Real-time web + cited research modes |
| [Linkup](https://linkup.so) | Free tier · usage-based | Deep research API with sourced answers and structured outputs |
| [Perplexity](https://www.perplexity.ai/settings/api) | Usage-based | Ranked web results (Search API); also offers Sonar chat models |
| [Jina](https://jina.ai) | 10M tokens free | LLM-optimized search **and** reader stack (`s.jina.ai`) |

**Environment variables:** `TAVILY_API_KEY`, `EXA_API_KEY`, `YDC_API_KEY`, `LINKUP_API_KEY`, `PERPLEXITY_API_KEY`, `JINA_API_KEY`

Enable multiple providers with priority fallback so a single outage does not stall agents.

Pipeline position: discovery stage of [[Pipeline - Discover, Fetch, Extract, then Summarize]] — then fetch with [[Method 1 - Direct HTTP Fetch]] or [[Method 2 - URL Scraping API]].
