**Q:** how clearbit connects to the GTM tag? Also talk about briefly how to integrate Leadfeeder, Albacross
**A**:
> Great follow-up — here’s a **clear breakdown of how Clearbit Reveal connects to GTM**, along with brief integration notes for **Leadfeeder** and **Albacross**:
> ---
> 
> ## 🔗 How Clearbit Reveal Connects to GTM
> 
> Clearbit Reveal connects to your site **through a JavaScript snippet**, which you load using GTM. Here’s how it works behind the scenes:
> 
> ### ✅ Step-by-Step Flow:
> 
> 1. **GTM fires the Custom HTML tag** containing Clearbit’s script.
> 2. The script:
>     - Sets your public API key: `window.clearbit = { key: 'pk_XXXX' }`
>     - Loads the Clearbit `reveal.js` file from their CDN   
> 3. On page load, the script captures the **visitor’s IP address**.
> 4. Clearbit’s backend performs an **IP-to-company lookup**.
> 5. The matched company info is returned **as a JavaScript object**, which can be accessed via browser dev tools or programmatically (e.g. for personalization).
> 6. The data is also sent to your **Clearbit Reveal dashboard**, where you can view companies that visited.

> > There is **no need for backend integration** unless you want to enrich server-side or push data into your CRM.
> ---
> 
> ## 🔌 Clearbit Reveal GTM Summary
> 
> - ✅ Custom HTML tag
> - ✅ Add your public key to `window.clearbit`
> - ✅ Loads external `reveal.js` file
> - 🔄 Automatically handles IP lookup & enrichment
> - 🧠 Optional: Read visitor data from `window.clearbit.company` or via their webhook/API
> ---
> 
> ## 🔄 How to Integrate Other Tools via GTM
> 
> ### 🔹 **Leadfeeder**
> 
> 1. Sign up at [Leadfeeder.com](https://www.leadfeeder.com/)
> 2. Copy your personal tracking script (includes your unique ID).
>     
>     ```html
>     <script type="text/javascript" src="https://lftracker.leadfeeder.com/lftracker_v1_YOUR_ID.js"></script>
>     ```
>     
> 3. In GTM:
>     - Tag Type: **Custom HTML**
>     - Trigger: **All Pages**
> 4. No need to set API keys or config objects. Leadfeeder handles tracking and identification passively.
> 5. Login to Leadfeeder to view visitors, filtered by company and engagement level.
> ---
> 
> ### 🔹 **Albacross**
> 
> 6. Create an account at [Albacross.com](https://albacross.com/)
>     
> 7. Get your **tracking script**, e.g.:
>     
> ```html
>     <script>
>       (function(a,l,b,c,r,s){
>         a.AlbacrossTrackingObject=r;
>         a[r]=a[r]||function(){(a[r].q=a[r].q||[]).push(arguments)};
>         s=l.createElement(b);s.async=1;s.src=c;
>         x=l.getElementsByTagName(b)[0];x.parentNode.insertBefore(s,x)
>       })(window,document,"script","https://serve.albacross.com/track.js","_alc");
>     
>       _alc("setAccount", "YOUR_ACCOUNT_ID");
>       _alc("trackPageView");
>     </script>
>   ```
>     
> 8. In GTM:
>     - Create **Custom HTML tag
>     - Trigger on **All Pages**
> 9. Albacross will collect visitor IPs and display identified companies in your dashboard.
>     
> 10. You can set up **Slack or email alerts**, and export leads.
> ---
> 
> ## ✅ Quick Comparison
> 
> |Platform|Needs Public Key?|Script Type|Setup in GTM|CRM Integrations|
> |---|---|---|---|---|
> |Clearbit Reveal|✅ Yes|`window.clearbit` + hosted script|Custom HTML|✅ Yes (Salesforce, HubSpot, Zapier)|
> |Leadfeeder|❌ No|Direct hosted script|Custom HTML|✅ Yes (HubSpot, Pipedrive, Zapier)|
> |Albacross|✅ Yes (Account ID)|Wrapper function + hosted script|Custom HTML|✅ Yes (Slack, Zapier, CRMs)|
> 
> ---
> 
> Let me know if you’d like sample **event listeners to extract the data into GTM Data Layer**, or use cases like **triggering popups only for target accounts.**


----

**Q2:**
```
Lets move the focus away from Clearbit and redistribute the focus equally on all three services
```