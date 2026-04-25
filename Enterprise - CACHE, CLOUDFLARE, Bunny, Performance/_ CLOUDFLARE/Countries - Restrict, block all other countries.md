Note This assumes a website/business in United States. Adapt your instructions as appropriately. 

---

When you need to block other countries

- You may want to restrict all other countries if you have high bot scans. For example:
	![[Pasted image 20260415180328.png]]

	^ This shows in 24 hours I have over 10k hits for a personal non-branded website
	At the bottom right it shows almost 90k bot scans/attacks blocked and it's only April 15th, 2026.

---

Block all other countries vs block specific countries over time
- If your business or prospects are in the US, and you don't have to focus on the other countries.
- If your business or prospects involve non-US countries, then instead of banning all countries outside the US, you may have to ban each country. In that case, start with a few obvious countries (you know them), and periodically check your country traffic breakdown for suspicious hits ([[Countries - View Country Traffic Breakdown]]), adding new countries to the ban rules. You’ll still see attack traffic coming from Western countries, largely because it’s easy for attackers to spin up cloud servers or route through VPNs to bypass geographic blocks and bans.

---

With your domain selected: Security -> Security rules -> Create Rule -> Custom Rules
![[Pasted image 20260415182549.png]]

Create rule: Country does not equal United States
![[Pasted image 20260415182632.png]]

Then Deploy:
![[Pasted image 20260415183239.png]]

Here's the Security rules dashboard after deploying the rule:
![[Pasted image 20260415183312.png]]