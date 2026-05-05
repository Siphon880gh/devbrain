
Value of a list if it is in index:

Say we have a list of strings called subtitles. We have index 4 which we aren't sure the subtitles list is long enough and it'd be out of bounds
```
subtitles[index] if index < len(subtitles) else None
```

It directly expresses your intent: "Get the item at this index if the index is within bounds, else return None."