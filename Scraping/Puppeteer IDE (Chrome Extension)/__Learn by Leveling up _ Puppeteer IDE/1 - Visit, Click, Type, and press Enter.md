
Goal: Learn puppeteer on how to open a webpage, how to click an element, type into search field, and pressing enter on that search field

---


Install Puppeteer IDE chrome extension:
[https://chromewebstore.google.com/detail/puppeteer-ide/ilehdekjacappgghkgmmlbhgbnlkgoid?hl=en-US](https://chromewebstore.google.com/detail/puppeteer-ide/ilehdekjacappgghkgmmlbhgbnlkgoid?hl=en-US)

Open Wikipedia in Chrome: http://wikipedia.org/

Open DevTools (CMD+OPT+J) and switch to the new tab "Puppeteer IDE"

> Dont see "Puppeteer IDE"? May be hidden in the double right arrow:
> ![[Pasted image 20250701062915.png]]
>
> ![[Pasted image 20250701062932.png]]


Input this in then hit "Execute"-

1 of 2 - Input this:
```
await page.goto('https://wikipedia.org')  
  
const englishButton = await page.waitForSelector('#js-link-box-en > strong')  
await englishButton.click()  
  
const searchBox = await page.waitForSelector('#searchInput')  
await searchBox.type('telephone')  
  
await page.keyboard.press('Enter')  
await page.close()
```

2 of 2 - Then click Execute at the left:
![[Pasted image 20250701063452.png]]

Initially looking like:
![[Pasted image 20250701062948.png]]

The webpage changes:
![[Pasted image 20250701063110.png]]


But then it's not done! Blink and you'll miss it. It's typing "telephone" into the searchbar:
![[Pasted image 20250701063244.png]]

Then the final page looks like:
![[Pasted image 20250701063322.png]]

### Retrospection

Puppeteer goes to wikipedia.org (regardless if you're on it already)

It waits for a particular element to exist, by its selector. 

Once it emerges into existence, puppeteer imitates a user clicking the link, which opens to some article.

But next, it imitates typing in the word "telephone", then pressing Enter into the search input.

And that's why the page changes one more time, to the Wikipedia article on Telephone.