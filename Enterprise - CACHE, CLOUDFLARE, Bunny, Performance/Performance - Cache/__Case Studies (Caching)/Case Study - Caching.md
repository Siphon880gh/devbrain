Before this became a caching problem, it was a bot problem.

Botnets started scraping my website and pushed my VPS CPU to 100%. That slowed down the rest of my site and eventually got my hosting account suspended.

I added protections to block as much bot traffic as possible. But even after that, the remaining bots still pushed CPU usage up to around 20%. That made me wonder: what happens if I get this same level of traffic from real users in the future?

That is when I realized the bots were not the only problem. They exposed a weakness in my app. My coding notes app was bottlenecking the CPU because I did not have an efficient caching strategy.

The full story, including the compression and caching strategies near the end, is here:  
[[Case Study - Anti-Scraping and Protecting CPU Spikes]]