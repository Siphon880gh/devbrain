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

---

To adjust the speed and size of your GIF, you can modify the `-delay` value and `scale` in the `ffmpeg` command. Here’s a modified version:

1. **Slow it down** by increasing the `-delay` value in the `convert` command (higher values will make it slower).
2. **Make it larger** by adjusting the `scale` filter in the `ffmpeg` command.

Here’s an example command with adjustments:

```bash
ffmpeg -i z.mov -vf scale=640:-1 -r 10 -f image2pipe -vcodec ppm - | convert -delay 10 -loop 0 gif:- | convert -layers Optimize demo.gif
```

### Explanation:
- **`scale=640:-1`**: This will resize the video to 640 pixels wide, with the height scaled to maintain aspect ratio. Adjust `640` to your desired width.
- **`-delay 10`**: This value slows down the frame rate. Increase the value to make it slower (e.g., `-delay 20` for slower animation).

This should create a slower, larger GIF. Let me know if you need more customization!

---

To increase the quality of a GIF created with `ffmpeg`, you can:

1. **Increase the Frame Rate**: Increase the frames per second (`fps`), but keep in mind this can make the file size larger.
2. **Use a Higher Resolution**: Ensure the `scale` filter uses a higher resolution.
3. **Use the `-q:v` Option**: This option sets the video quality (lower values are higher quality for GIF encoding).

Here’s an example command:

```bash
ffmpeg -i z.mov -vf "scale=800:-1, fps=15" -q:v 2 demo.gif
```

### Explanation:
- **`scale=800:-1`**: Sets a larger width (800 pixels in this case) to improve the resolution of the GIF.
- **`fps=15`**: Sets the frame rate to 15 fps, giving smoother motion (you can adjust this value based on your preference and file size limits).
- **`-q:v 2`**: Sets high quality (values range from 2 to 31, where 2 is the best quality for GIF output in `ffmpeg`).

For finer quality control, using ImageMagick with specific dithering and color optimization options can also help. Here's a combined example with `ffmpeg` and `convert`:

```bash
ffmpeg -i z.mov -vf scale=800:-1 -r 15 frames/frame_%04d.png
convert -delay 6 -loop 0 frames/frame_*.png -dither FloydSteinberg -colors 256 -layers Optimize demo.gif
rm frames/frame_*.png
```

This approach uses `-dither FloydSteinberg` and limits colors to `256` to maintain high quality without excessive file size.