iPad Safari can exhibit more aggressive caching behavior than iPhone Safari or Desktop/Laptop Safari so far into 12/24. 

Apple does not make it easy for its users to control level of caching because Apple takes a company knows best approach. (Steve Jobs - "People don't know what they want until you show it to them. That's why I never rely on market research.). It's so extreme that server level (nginx or Apache) cache control headers or php cache control headers could get ignored on iPad Safari

Examples of their philosophy includes ignoring css that make the scrollbar visible. Apple aesthetics demand that the scrollbar is never visible unless during user scrolling.

Even more exemplified is that throughout a decade, iPad Safari not consistently honor cache control headers, and it's all the rage with web developers. It’s obvious Apple prefers caching on iPad, even if at the expense of companies’ web apps breaking (And it's to the benefit of Apple's pockets too because they want to encourage people to use Apple native apps instead anyways over js heavy web apps that don't pay yearly fees to Apple). If curious, see decade discusssions that go a decade long with developers being annoyed with the super persistent cache that doesn't listen to their server or php cache control headers:
- [https://stackoverflow.com/questions/48693693/macos-safari-caching-response-while-headers-specify-no-caching](https://stackoverflow.com/questions/48693693/macos-safari-caching-response-while-headers-specify-no-caching)  
-   [https://stackoverflow.com/questions/3602887/why-doesnt-safari-honor-my-cache-control-directive](https://stackoverflow.com/questions/3602887/why-doesnt-safari-honor-my-cache-control-directive)  

Apple wants the strongest caching on iPad - here's their rationale:

- iPads often have more RAM and storage, allowing them to cache more aggressively compared to iPhones. And iPads, with their larger screens, encourage multiple tabs and multitasking, and Safari can aggressively cache resources to make tab switching faster.
- On iPhones, limited memory can cause tabs to reload more frequently and clear  cache sooner. iPhone are also on the go with low expectations for a stable internet connection, so it's been the practice to code in phone optimized resources on the page (especially images) so the caching is not as aggressive on iPhone Safari.
- Desktop/Laptop Safari doesn't as aggressively cache as iPad or iPhone Safari because it's usually on good internet connection at an office or Internet cafe instead of on the go or on a car ride like iPad. Also, websites are usually developed on desktop/laptop where the developer needs to see updates right away so they know their code works. So Apple prioritized fresh assets over caching on Desktop/Laptop
  
To mitigate iPad Safari aggressively caching, refer to:
[[iPad Safari aggressively caches - 2. How to mitigate]]