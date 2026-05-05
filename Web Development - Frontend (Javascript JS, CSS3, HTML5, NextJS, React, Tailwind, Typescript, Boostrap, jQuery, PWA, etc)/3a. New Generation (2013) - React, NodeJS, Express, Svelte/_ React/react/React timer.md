
**Level 1**

Add a timer that switches mode between true and false every second:
```
 const [mode, setMode] = useState(false)  
  
  useEffect(()=>{  
    setTimeout(()=>{  
      setMode(!mode)  
    }, 1000)  
  }, [mode])
```

**Level 2**
Add state variable that initially is the integer 0, then increment it every second. Further challenge: Format that text to HH:MM:SS.


```
import { useState, useEffect } from "react";

export default function TimerComponent() {
  const [secondsElapsed, setSecondsElapsed] = useState(0);

  useEffect(() => {
    const interval = setInterval(() => {
      setSecondsElapsed((prevSeconds) => prevSeconds + 1);
    }, 1000);

    return () => clearInterval(interval); // Cleanup on unmount
  }, []);

  const formatTime = (seconds) => {
    const hours = Math.floor(seconds / 3600)
      .toString()
      .padStart(2, "0");
    const minutes = Math.floor((seconds % 3600) / 60)
      .toString()
      .padStart(2, "0");
    const secs = (seconds % 60).toString().padStart(2, "0");
    return `${hours}:${minutes}:${secs}`;
  };

  return (
    <div>
      <p>Time Elapsed: {formatTime(secondsElapsed)}</p>
    </div>
  );
}

```