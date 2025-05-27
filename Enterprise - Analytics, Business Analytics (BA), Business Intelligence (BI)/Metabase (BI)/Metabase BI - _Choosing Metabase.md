Let's say our app creates videos using AI. My fellow co-founders want access to view customer data and their videos. We also need to show there's users and activity to potential investors to secure investments.

Although I have the capability, I prefer not to build a custom reporting webpage because it would require much development time, or our company does not have more budget for development. 

This dashboard is to be shared / accessed by non-technical team members and stakeholders, so tools like Atlas and MongoDB Compass are unsuitable, as we want to avoid accidental data modification. 

We aim for a free or low-cost solution, ruling out tools like Grafana (with MongoDB connectors).

**Free Read-Only Solution Options**

1. **Metabase**: Available as both a managed service (14-day free trial) and open-source version ([GitHub Repository](https://github.com/metabase/metabase/tree/master)).
2. **Redash**: Open-source solution for Linux environments ([GitHub Repository](https://github.com/getredash/setup)).

Redash requires a lot of setup and takes a bit of tweaking to make it work and we have tight deadlines. I would like to set up very quickly:

- Final choice: Metabase


---

Metabase can do live tables and dashboards. A peak into what it can do:
[https://www.metabase.com/docs/latest/](https://www.metabase.com/docs/latest/)

![[Pasted image 20250418201428.png]]

Metabase can perform churn and retention analysis:
[https://www.metabase.com/events/preventing-churn-with-retention-analysis-in-metabase](https://www.metabase.com/events/preventing-churn-with-retention-analysis-in-metabase)

---

The databases that Metabase can work with as a BI tool are: MySQL, Mongo, etc:
![](x6QRZ8V.png)
