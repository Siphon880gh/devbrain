After generating the project stakeholder orientation document per [[Generate Orientation Document for Stakeholder]], we can create a graph prompt that will perform sophisticated market research to help us fine tune our app to be more competitive in the market (eg. researched competitors).

Firstly, at Cursor AI where your codebase and the project stakeholder orientation document is, run this prompt to meta generate a graph prompt for market research:
```
Using our Product Stakeholder Orientation document as the source of truth, create a reusable graph-based research prompt named `COMPETITOR-RESEARCH-GRAPH-PROMPT.md`.

The graph prompt should coordinate a thorough competitor analysis and convert the findings into product, positioning, pricing, and feature recommendations.

Include research nodes for:

1. **Product and Market Context**

   * Extract our target users, jobs to be done, pain points, business goals, constraints, current positioning, and success criteria from the stakeholder document.
   * Identify any missing information or assumptions that could affect the analysis.

2. **Competitor Discovery**

   * Identify direct, indirect, emerging, and substitute competitors.
   * Explain why each competitor belongs in the analysis.
   * Prioritize the competitors that pose the greatest threat or offer the most useful strategic lessons.

3. **Competitor Matrix**
   Compare competitors across:

   * Target market
   * Core use cases
   * Major features
   * Differentiators
   * Positioning
   * Pricing and packaging
   * Free trials, freemium plans, discounts, guarantees, and other offers
   * Customer acquisition channels
   * Strengths
   * Weaknesses
   * Customer complaints and unmet needs
   * Evidence sources and confidence level

4. **Audience and Persona Reverse Engineering**

   * Infer the demographics, psychographics, firmographics, roles, needs, anxieties, motivations, and jobs to be done of each competitor’s target customers.
   * Analyze how each competitor speaks to these audiences through its homepage, landing pages, advertisements, onboarding, sales materials, and pricing pages.
   * Clearly label inferred findings separately from verified facts.

5. **Messaging and Sales Strategy**

   * Analyze each competitor’s promises, value propositions, headlines, emotional appeals, proof points, objection handling, calls to action, and sales funnel.
   * Identify which audience segment each message appears designed to persuade.
   * Determine whether the competitor primarily sells through price, convenience, performance, trust, status, specialization, simplicity, or another advantage.

6. **Pricing Sensitivity and Offer Analysis**

   * Compare price points, pricing models, tiers, feature gates, contract terms, discounts, trials, guarantees, bonuses, bundles, and upsells.
   * Estimate the pricing sensitivity of each customer segment using available evidence.
   * Identify what customers appear willing to pay more for and what causes resistance.
   * Do not present unsupported pricing assumptions as facts.

7. **Reviews and Market Sentiment**

   * Analyze customer reviews, community discussions, support complaints, comparison articles, and other credible sources.
   * Identify recurring praise, frustrations, switching triggers, abandoned use cases, and unmet expectations.
   * Distinguish isolated anecdotes from repeated patterns.

8. **Strategic Gaps and Opportunities**

   * Identify underserved personas, unmet jobs to be done, weak competitor experiences, missing features, pricing gaps, and positioning opportunities.
   * Separate opportunities into:

     * Ways to beat competitors directly
     * Ways to differentiate instead of competing feature-for-feature
     * Opportunities to serve a narrower or overlooked segment
     * Messaging, packaging, or pricing changes that do not require major product development
     * Larger product or business-model pivots

9. **Strategic Recommendation**

   * Recommend whether we should compete directly, differentiate, focus on a niche, reposition, change pricing or packaging, or pursue a larger pivot.
   * Explain why the recommendation fits our stakeholder goals, resources, users, and constraints.
   * Include the risks, tradeoffs, assumptions, and evidence behind the recommendation.
   * Avoid recommending a major pivot when a smaller change in positioning, packaging, workflow, or feature emphasis could achieve the same result.

10. **Feature Opportunities**

    * Produce a consolidated list of features suggested by the competitor research, customer gaps, and recommended strategy.
    * Include defensive features, differentiating features, table-stakes features, and experimental bets.
    * Tie every proposed feature to a specific user need, competitor weakness, or strategic opportunity.

11. **Force-Ranked Feature Roadmap**
    Rank all feature opportunities from highest to lowest priority. Do not allow ties.

    For each feature, provide:

    * Rank
    * Feature
    * Target persona
    * User problem solved
    * Strategic rationale
    * Expected user value
    * Expected business value
    * Competitive impact
    * Estimated effort
    * Dependencies
    * Risks
    * Evidence strength
    * Recommended timing: Now, Next, Later, or Reject

    Score each feature using a consistent model that accounts for:

    * User reward
    * Business reward
    * Strategic differentiation
    * Reach
    * Confidence
    * Engineering and operational effort
    * Ongoing maintenance cost

    Explain the scoring formula, show the component scores, and use the final score to establish the force-ranked order. Flag any low-effort/high-reward quick wins and high-effort features whose expected value does not justify their cost.

## Graph requirements

Structure the workflow as a directed research graph with:

* Clearly named nodes and responsibilities
* Inputs and outputs for every node
* Dependencies between nodes
* Parallel research branches where appropriate
* Synthesis and validation nodes
* Feedback loops for weak, missing, or contradictory evidence
* Stop conditions so research does not continue indefinitely
* A final decision node that produces the strategic recommendation and force-ranked roadmap

Include a Mermaid diagram of the complete workflow, followed by detailed instructions for every node.

## Research standards

* Use current, credible, and directly relevant sources.
* Cite every important factual claim with a direct source link.
* Record the date each source was accessed.
* Prefer competitor-owned sources for features and pricing, while using independent reviews and customer discussions for sentiment and pain points.
* Separate verified facts, reasonable inferences, and open questions.
* Note conflicting evidence instead of silently choosing one version.
* Never invent pricing, personas, customer behavior, market share, or product capabilities.
* Include confidence ratings for consequential findings.
* Return to earlier research nodes when evidence is insufficient or contradictory.

## Final outputs defined by the graph

The completed research workflow should produce:

1. Executive summary
2. Prioritized competitor landscape
3. Detailed competitor matrix
4. Audience and persona analysis
5. Messaging and positioning comparison
6. Pricing-sensitivity and offer analysis
7. Customer sentiment and unmet-needs analysis
8. Strategic gaps and opportunities
9. Recommended competitive or differentiation strategy
10. Force-ranked feature roadmap
11. Quick wins, strategic bets, and rejected ideas
12. Risks, assumptions, confidence levels, and unresolved questions
13. Source list with direct links

The graph prompt must be detailed enough that another AI agent can execute it without needing additional instructions.
```

AI's thinking process:
![[Pasted image 20260904051400.png]]

Then switching to a platform that can perform online research, eg. ChatGPT-5.6 Sol on Extra High, paste the generated graph prompt there INCLUDING a section that code fences the product orientation document, and end it with a divider followed by `GOALS: Double check if the graph prompt could be improved, then improve it, and finally - run the graph prompt`. Save the response as a report you can read or share with stakeholders and decision makers.

AI's thinking process:
![[Pasted image 20260904053340.png]]