If you poke around deep enough, you may notice a reference to Duckling

**Duckling** in Botpress is a natural language processing (NLP) module that extracts structured data from text — especially useful for recognizing **dates, times, numbers, durations, and more**. (e.g., for understanding "next Friday" or "two weeks from now").

Botpress V12 uses the Duckling that's on Botpress' remote server. If you visited `https://duckling.botpress.io/`, you'll get a text response "quack!"

Botpress official Dockerfile pulling from `botpress/server` would include duckling locally in contrast to using the remote Duckling service. 
- FYI: But that container is for x86_64 and is glitchy and slow on arm64. If you're on a Mac with M1/M2/etc Apple Silicon chip and you're testing locally before deploying in production, then ARM64 applies to you.


---


Duckling parses **entities** in user input, such as:

|User Input|Duckling Output (Entity Type)|
|---|---|
|"next Tuesday"|`time`|
|"in two hours"|`duration`|
|"I need it by 5pm"|`time`|
|"three hundred dollars"|`amount-of-money`|
|"7 miles"|`distance`|
|"twice a day"|`frequency`|
|"between 2 and 5 PM"|`interval`|

---

### 🔧 How It Works in Botpress

1. **Botpress receives user input**
2. It routes text to Duckling via HTTP (usually `localhost:8000`)
3. Duckling returns structured JSON like:
    
    ```json
    {
      "dim": "time",
      "value": {
        "value": "2025-05-17T17:00:00.000-07:00",
        "grain": "hour",
        "type": "value"
      },
      "body": "5pm",
      "start": 16,
      "end": 19
    }
    ```
    
4. Botpress uses this in flows, slots, or conditions (e.g., "Schedule a meeting at [time]")
    
---

### 🛠 Duckling Is Useful When:

- Building bots that schedule things (appointments, reminders)
- Handling quantities or numeric input
- Extracting clean data for use in logic or backend calls
    

---

### 🌐 Running Duckling

Duckling is a separate service written in Haskell. You can:
- Run it as a subprocess inside the same container (like your Dockerfile tries)
- Or run it as an external microservice (`http://localhost:8000/parse`)