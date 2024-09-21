
You may notice on the second line of an EDL:

```
TITLE: generated
FCM: NON-DROP FRAME
```

Drop Frame (DF) and Non-Drop Frame (NDF) are timecode formats used in video editing and are particularly relevant for broadcast standards based on NTSC (29.97 fps).

- **Non-Drop Frame (NDF)**: Timecode counts frames sequentially without skipping any numbers. However, because NTSC video runs at 29.97 fps instead of a true 30 fps, NDF timecode will gradually drift out of sync with real time. Over the course of an hour, NDF timecode will be about 3.6 seconds ahead of actual time.

- **Drop Frame (DF)**: To keep the timecode synchronized with real time, DF skips (or "drops") two frame numbers every minute, except for every tenth minute. This correction ensures that the timecode matches the actual clock time over long durations.

In **EDLs (Edit Decision Lists)**, which store timecode-based edit instructions, the choice between DF and NDF is crucial for maintaining accurate timing, especially for broadcast where synchronization with real-world time is essential.