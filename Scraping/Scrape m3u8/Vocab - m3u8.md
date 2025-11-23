Q: HLS stream (.m3u8)? why is it called m3u8? why is it called hls?

A: 
## What “HLS” means

**HLS = HTTP Live Streaming.**

- **HTTP**: delivered over plain web requests (CDNs, caches, etc.).
    
- **Live**: designed for live + VOD by chopping video into tiny pieces.
    
- **Streaming**: player fetches a playlist, then pulls segments in order.
    

## What “.m3u8” means

**m3u8 = “M3U (UTF-8)” playlist.**

- **M3U** is an old playlist format (originally for audio).
    

- Back in the late ’90s (Winamp/Nullsoft era), playlists were just text files that pointed to **MP3** files or **URLs** for streams. They used the `.m3u` extension and folks abbreviated it as **M3U = MP3 + URL**.
    

- A `.m3u8` file is just a text playlist that lists media segment URLs with HLS tags.
    

-  The UTF-8 variant was named **`.m3u8`** (“M3U in UTF-8”).  
    
- **8** = encoded in **UTF-8**.
    

## How they relate

- **HLS** is the _protocol/spec_.
    
- **.m3u8** is the _playlist file_ HLS uses (master & media playlists).
    
- Segments are typically `.ts` (MPEG-TS) or `.m4s` (CMAF/fragmented MP4).
    

## Tiny example (media playlist)

#EXTM3U  
#EXT-X-TARGETDURATION:6  
#EXT-X-VERSION:7  
#EXT-X-MEDIA-SEQUENCE:120  
#EXTINF:6.0,  
segment120.ts  
#EXTINF:6.0,  
segment121.ts  
#EXTINF:6.0,  
segment122.ts

## Mnemonic / Quick memory trick

- **HLS** → think “**H**TTP **L**ive **S**treaming.”
- **m3u8** → “**M3U, UTF-8**” → “M3U-eight.”

In m3u8, each technology piece is identified by their first letter and their only number (so mp3-> m3 and utf8 -> u8)