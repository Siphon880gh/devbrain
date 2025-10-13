
## The Final Thesis

Here's puppeteer chrome extension visiting every workflow link on https://n8n.io/creators/n8n-team/.

![[puppeteer-visiting-links.gif]]

The for-loop in the above screen recording is not the complete scraping code. But we will be implementing that later. Currently, that's outside of your abilities. Small baby steps first.

---

And typically what would be done after a successful scrape with Puppeteer IDE:

After the scraping is successful, you get a large array of objects you can copy into VS Code. In particular - scraped from their website by puppeteer visiting each link is an array of objects representing each page:
![[Pasted image 20250701005017.png]]

Optional - Then optionally we enrich on a separate script to make a browsable search engine of their workflows:
![[Pasted image 20250701005105.png]]

Optional - The json is condensed down and the actual workflow json are saved as files:
![[Pasted image 20250701005132.png]]

Optional - So you can create a browsable experience:
- No more clicking "Load more" to view more results like on n8n page
- Can search by name, integration, and category unlike the n8n page
![[Pasted image 20250701005231.png]]

The above optional milestones is really going beyond scraping, and towards enriching the scraped data and making it useable/visualized, which are often tasks coupled with scraping activities. Those enrichment and browsing code are at https://github.com/Siphon880gh/n8n-templates/tree/main/n8n-partners, if you're curious.

---

## Action

First goal is get all link href's to the workflow templates:
![[Pasted image 20250701074922.png]]

-→ each one of them you get their links:

Developing the Puppeteer IDE script:
```
const listHandles = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]');  
let ahrefs = [];  
  
if (listHandles.length) {  
  const list = listHandles[0]; // get the actual element handle  
  
  const linkHandles = await list.$$('a'); // get all <a> elements inside it  
  
  for (const link of linkHandles) {  
    const href = await link.evaluate(el => el.href);  
    ahrefs.push(href);  
  }  
} else {  
  console.error('No element found for the XPath');  
}  
  
console.log(ahrefs)
```

Hint: Remember how to get the full X path in a previous tutorial? You're getting the path of the div that contains all the workflow links (`<a>` tags).

Hint:
![[Pasted image 20250701080323.png]]

Go ahead and execute the puppeteer ide code:
![[Pasted image 20250701075032.png]]

So that console shows each of the workflow's ahref:
![[Pasted image 20250701075214.png]]

^ Notice it's an array of all the workflow's ahref's. Then conceptually we could have puppetteer run "goto" on each of those links then scrape for that data on that webpage (click the button to copy workflow JSON to clipboard), but first we must figure out the puppeteer code to execute for each page

---

Lets open one of the links, for example:
https://n8n.io/workflows/1828-create-or-update-mautic-contact-on-a-new-calendly-event/

On the individual page, execute this puppeteer script:
- The X full path is to the orange Use button
```
const buttons = await page.$x("/html/body/div[1]/section/div/div[2]/div/div[1]/div/div/button");  
  
if (buttons.length) {  
  const useButton = buttons[0];  
  await useButton.click();  
  
  // Wait for modal content to be visible and ready  
  const copyButton = await page.waitForSelector(".modal-content > .grid > div", {  
    visible: true,  
    timeout: 5000, // increase if needed  
  });  
  
  if (copyButton) {  
    await copyButton.click();  
  
    // Optional delay to allow clipboard API to populate  
    await page.waitForTimeout(500);  
  
    const copiedText = await page.evaluate(() => navigator.clipboard.readText());  
    console.log("Copied text:", copiedText);  
  } else {  
    console.error("Copy button not found.");  
  }  
} else {  
  console.error("Use button not found.");  
}
```


The orange Use button:
![[Pasted image 20250701075426.png]]

Note on the first run, a popup will ask:
![[Pasted image 20250701075437.png]]

Just have to allow once. May have to run the script for that page again because the time it takes for you to press Allow, it will have messed the opportunity to copy the contents from clicking the copy button. On future runs as long as on the same website, doesnt matter the page, it'll copy successfully

Console tab sees the pasted contents consoled out:
![[Pasted image 20250701075454.png]]

---

Then that means you can now work on the full script that gets all the ahrefs from the listing of workflows, then use puppeteers' goto method to go to each link, and at each page, copy the string. Instead of outputting the workflow json, you save to a structure like this:
```
[  
  {  
    href: "https://n8n.io/workflows/1828-create-or-update-mautic-contact-on-a-new-calendly-event/",  
    workflowJson: "...."  
  }  
...  
]
```


Recall the orange Use button that we had Full XPathed to in order to click it, to open the modal, then click the Copy to clipboard button at the modal?
![[Pasted image 20250701075426.png]]

It was just a good practice to figure out Puppeteer IDE. However it actually wasn't needed. The workflow json that we want to copy for that n8n workflow is actually already embed in the HTML:
![[Pasted image 20250701075619.png]]

^ The workflow JSON is inside the tag `<n8n-demo>`'s attribute workflow= . And that tag is inside the w-8/12 (if you're on large screen) fraction of the page!
https://n8n.io/workflows/1828-create-or-update-mautic-contact-on-a-new-calendly-event/

---

Return to the main page that lists all the workflows:
https://n8n.io/creators/n8n-team/

Recall that the puppeteer ide script to console log all ahrefs was:
```
const listHandles = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]');  
let ahrefs = [];  
  
if (listHandles.length) {  
  const list = listHandles[0]; // get the actual element handle  
  
  const linkHandles = await list.$$('a'); // get all <a> elements inside it  
  
  for (const link of linkHandles) {  
    const href = await link.evaluate(el => el.href);  
    ahrefs.push(href);  
  }  
} else {  
  console.error('No element found for the XPath');  
}  
  
console.log(ahrefs)
```

We will rewrite that with a timeout and an easier code structure to adapt to scraping each individual page in a for-loop:
```
const listHandles = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]');  
let ahrefs = [];  
  
if (listHandles.length) {  
  const list = listHandles[0]; // get the actual element handle  
  
  const linkHandles = await list.$$('a'); // get all <a> elements inside it  
  
  for (const link of linkHandles) {  
    const href = await link.evaluate(el => el.href);  
    ahrefs.push(href);  
  }  
} else {  
  console.error('No element found for the XPath');  
}  
  
console.log(ahrefs)  
  
for(var i=0; i<ahrefs.length; i++) {  
  var ahref = ahrefs[i];  
  await page.goto(ahref);  
  await page.waitForTimeout(1000);  
   
}
```

Executing the script, it seems to open each link every 1 second. So it plays out like this:
![[puppeteer-visiting-links.gif]]


---

## Further preparation

Now another thing - notice it's just 10 links! It's because of manual lazy loading! You have to scroll all the way down to the page

Keep scrolling down and pressing Load More until it becomes 90 out of 90
![[Pasted image 20250701080051.png]]

Then eventually loading 90 out of 90:
![[Pasted image 20250701080109.png]]

Perfect. Now lets start scraping the individual pages and enriching a mega data structure--

The data structure could be:
```
[  
 {  
  href,  
  filename, // figured out from href which has slugified filename  
  integration: "",  
  category: "",  
  json // this is what we scrape and store into  
 }  
]
```

---

## Action, For Real This Time

The puppeteer script is now:
- again you run this inside puppetter ide devtools tab at [https://n8n.io/creators/n8n-team/](https://n8n.io/creators/n8n-team/). It'll collect the links from the list of workflows and then visits each page individually to scrape and enrich a large array
```
const listHandles = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]');  
let ahrefs = [];  
  
if (listHandles.length) {  
  const list = listHandles[0]; // get the actual element handle  
  
  const linkHandles = await list.$$('a'); // get all <a> elements inside it  
  
  for (const link of linkHandles) {  
    const href = await link.evaluate(el => el.href);  
    ahrefs.push(href);  
  }  
} else {  
  console.error('No element found for the XPath');  
}  
  
console.log(ahrefs);  
const ahrefsLength = ahrefs.length;  
  
for(var i=0; i<ahrefs.length; i++) {  
    var ahref = ahrefs[i];  
    await page.goto(ahref);  
  
    const workflowJsonTag = await page.waitForSelector("n8n-demo") // Yes the webpage has a custom HTML Tag that stored the workflow json `<n8n-demo workflow="josn...">`  
  
    const json = await workflowJsonTag.evaluate(el => el.getAttribute("workflow")); // get the value of the 'workflow' attribute  
      
    // The data structure  
    if(ahref.endsWith("/")) {  
        ahref = ahref.substr(0, ahref.length-1)  
    }  
    // href already defined at this point  
    var filename = ahref.split("/").pop();  
    var integration = ""; // will be filled by a post script outside of web browser. looks at filename that has words hyphenated for keyword for integration   
    var category = ""; // will be filled by a post script outside of web browser. it looks up the integration word in order to look up the category in another file def_categories.json  
    // json already filled by puppeteer at this point. The post script will get rid of the json field and save to json file of the same filename, in order to make parsing a smaller json file on demand possible.  
    ahrefs[i] = {  
        href: ahref,  
        filename,  
        integration,  
        category,  
        json  
    } // ahrefs array being modified  
  
   console.log(`At ${i} of ${ahrefsLength}.`);  
   console.log(ahrefs);  
   await page.waitForTimeout(3000); // dont get banned!  
}
```

Lets now scrape (by hitting Execute in the puppeteer ide panel)! 

You will see if you change to console tab, that there is an array of links that are slowly transforming into an array of objects. Notice that's because of the above `ahrefs[i] = { href: ahref, filename, integration, category, json }` where the ahrefs were originally strings of links.
- Note in this screenshot, there are 10 links/objects. You should have 90!
  ![[Pasted image 20250701080704.png]]

Your output should be something similar to:
```
[  
  {  
    "href": "https://n8n.io/workflows/1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks",  
    "filename": "1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks",  
    "integration": "",  
    "category": "",  
    "json": "..." // Very long workflow JSON definition  
  },  
  {  
    "href": "https://n8n.io/workflows/1807-sync-zendesk-tickets-to-pipedrive-contact-owners",   
    "filename": "1807-sync-zendesk-tickets-to-pipedrive-contact-owners",  
    "integration": "",  
    "category": "",  
    "json": "..." // Very long workflow JSON definition    
  },  
  // ... more workflows  
]
```


Then you're done! Yes integration and category are empty. This is part of a bigger project where I create a browsing interface that lets people download the workflow templates as well as easily view them for copying and pasting into their n8n instance. How that looks from a partial scrape (not all 90 workflows but only 10):
![[Pasted image 20250701080245.png]]

If you want to continue enriching category and integration fields that are empty right now, refer to my repo of absolutely all n8n workflow templates at [https://github.com/Siphon880gh/n8n-templates](https://github.com/Siphon880gh/n8n-templates) and go to the n8n-official collection's Readme for enrichment script instructions.

However puppeteer tutorial is over and puppeteer does not do data enrichment, although it's often paired in a pipeline to gain data then enrich it for your particular business use.