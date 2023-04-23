Screen recording converted to GIF then placed on README.md. That is much better than static screenshots.

There are many approaches. The one approach I find the best so far is QuickTime -> Cloud Convert

A. QuickTime -> Cloud Convert
 1. Record the screen with QuickTime Player.
 2. Convert the video file to GIF at https://cloudconvert.com/mp4-to-gif

If you link the `![image](/assets/***.gif)` and it doesn't show, you may have passed the allowed filesize by Github which is 10mb as of 8/2020.

B. QuickTime -> FFmpeg
 1. Record the screen with QuickTime Player.
 2. Convert the video file to gif using FFmpeg. This example uses `video.mov` converts it as `demo.gif`:
```
ffmpeg -i video.mov -vf scale=320:-1 -r 10 -f image2pipe -vcodec ppm - | convert -delay .75 -loop 0 - gif:- | convert -layers Optimize - demo.gif
```

Notice the scale is small. The -1 makes sure to keep aspect ratio. I also set delay to .75 to increase the speed of the screen recording, further reducing file size. You can google these options.

If your gif surpassed the 10mb limit on Github:
1. Record shorter video clip and/or record part of the screen rather than full screen.
2. Export to the lowest resolution possible at the Export option in QuickTime Player.
3. Convert the video to gif using ffmpeg while playing with different options. An option can be speeding up the GIF which will shorten its duration. Another option can be lowering the scale.
4. Use online tools like https://www.iloveimg.com/compress-image/compress-gif and iloveimg's crop and resize tools.
5. If the above fails, you can play around with imagemagick with things such as speeding up the gif.
