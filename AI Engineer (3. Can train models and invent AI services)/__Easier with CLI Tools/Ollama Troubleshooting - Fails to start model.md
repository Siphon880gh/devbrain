
## Replicate the bug:
Notice ollama is at the top right status menu on Mac so it is "ON"

Let's run a virtual girlfriend model we found on HuggingFace. Because we don't have a local copy, it starts downloading:
![[Pasted image 20250207035022.png]]

Right when it finishes downloading then tries to run the model - it fails:
![[Pasted image 20250207035054.png]]

The error reads:
```
Error: Post "[http://127.0.0.1:11434/api/show](http://127.0.0.1:11434/api/show)": dial tcp 127.0.0.1:11434: connect: connection refused
```

Despite it having been "downloaded", the next time you run, it'll download again, and this is because it was an abort/error so the download flushes.

---

## Approaches


**Before any of the approaches:**
Pull first before running
```
ollama pull ALIENTELLIGENCE/sarahv2
```

That way, it doesn't need to keep redownloading and aborting/flushing the download if it fails to run.


APPROACH 1
Did you just installed Ollama? Restart your computer


APPROACH 2
Check ollama running:
```
lsof -i :11434
```

APPROACH 3
Close any ollama background services (no more ollama at the top right menu status bar, and none at CMD+ALT+Delete).

Run `OLLAMA_LOG_LEVEL=debug ollama serve`

Then right after, run the Ollama background tool (SHIFT+Space on Mac → Ollama)

IS IT?:
Is it not having background service available (Ollama icon at the status menu strip at the top right)? Not necessarily. The background service will be started up if you ran `ollama run MODEL` and the background service is not up yet.

---

## Success

Success looks like:
![[Pasted image 20250207035533.png]]

![[Pasted image 20250207035700.png]]