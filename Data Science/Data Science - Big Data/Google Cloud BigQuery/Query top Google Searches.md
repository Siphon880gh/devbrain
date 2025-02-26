
At the BigQuery console (https://console.cloud.google.com/bigquery), you can simply click "Compose A New Query" without opening any specific dataset

![](Oh1GpA2.png)



Last 2 weeks:
```
-- This query shows a list of the daily top Google Search terms.

SELECT

refresh_date AS Day,

term AS Top_Term,

-- These search terms are in the top 25 in the US each day.

rank,

FROM `bigquery-public-data.google_trends.top_terms`

WHERE

rank = 1

-- Choose only the top term each day.

AND refresh_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 2 WEEK)

-- Filter to the last 2 weeks.

GROUP BY Day, Top_Term, rank

ORDER BY Day DESC

-- Show the days in reverse chronological order.
```


Last 4 weeks:
```
-- This query shows a list of the daily top Google Search terms.

SELECT

refresh_date AS Day,

term AS Top_Term,

-- These search terms are in the top 25 in the US each day.

rank,

FROM `bigquery-public-data.google_trends.top_terms`

WHERE

rank = 1

-- Choose only the top term each day.

AND refresh_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 4 WEEK)

-- Filter to the last 4 weeks.

GROUP BY Day, Top_Term, rank

ORDER BY Day DESC

-- Show the days in reverse chronological order.

```