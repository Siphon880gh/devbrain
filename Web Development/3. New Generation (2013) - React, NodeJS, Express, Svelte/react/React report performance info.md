
Purpose: React Analytics of website performance
Status:Tested

https://create-react-app.dev/docs/measuring-performance/

```
import reportWebVitals from './reportWebVitals';
...

  useEffect(()=>{
    reportWebVitals(console.log);
  });
```


Returns something like:
```

{"name":"TTFB","value":36.3999999910593,"delta":36.3999999910593,"entries":[{"name":"http://localhost:3000/view/zDemo/Unsupported/Facebook%20Reel%20Demonstration.txt","entryType":"navigation","startTime":0,"duration":1203.3999999910593,"initiatorType":"navigation","nextHopProtocol":"http/1.1","renderBlockingStatus":"non-blocking","workerStart":0,"redirectStart":0,"redirectEnd":0,"fetchStart":4.5999999940395355,"domainLookupStart":4.5999999940395355,"domainLookupEnd":4.5999999940395355,"connectStart":4.5999999940395355,"secureConnectionStart":0,"connectEnd":4.5999999940395355,"requestStart":16.5,"responseStart":36.3999999910593,"firstInterimResponseStart":0,"responseEnd":36.79999999701977,"transferSize":1223,"encodedBodySize":923,"decodedBodySize":1843,"responseStatus":200,"serverTiming":[],"unloadEventStart":50.3999999910593,"unloadEventEnd":50.3999999910593,"domInteractive":181.5,"domContentLoadedEventStart":292.8999999910593,"domContentLoadedEventEnd":293,"domComplete":1200.699999988079,"loadEventStart":1201.5,"loadEventEnd":1203.3999999910593,"type":"reload","redirectCount":0,"activationStart":0}],"id":"v2-1692659297510-9319364648958"}
```

The file reportWbeVitals is created automatically by create-react-app

---
Used vite instead of create-react-app? 


Status: Untested
Here are a few ways to implement reportWebVitals or similar performance tracking in a Vite project:

- Use the `@vitejs/plugin-react` plugin, which will automatically inject reportWebVitals for you. Just install the plugin and it will handle setting up reporting.

- Manually import reportWebVitals and call it in your app:

```js
import { reportWebVitals } from 'react-app-rewired'

reportWebVitals(console.log)
```

- Use the react-web-vitals npm package. Install it, import the hook, and call it in your App component:

```js
import { useWebVitalsReport } from 'react-web-vitals'

function App() {
  useWebVitalsReport()

  return < /> 
}
```

- For custom metrics tracking, you can use the @vueuse/head plugin. This allows tracking pageviews, events etc and supports plugins like Google Analytics, Mixpanel etc.

- For low-level metrics, use the Navigation Timing API and User Timing API. You can create a small wrapper to track and report these.

The key is that Vite itself is unopinionated about metrics tracking. So you have to manually integrate the solution you prefer. The above plugins make it easy to add perf tracking to your Vite project.