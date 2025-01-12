
This tutorial will take a movie file or an audio file and convert it into a SRT subtitle file (complete with timemarks) or TXT text file. Note you can perform this on a movie file but you need to first extract the audio, and we can use ffmpeg for this pyrpose.

This requires:
```
pip install openai-whisper torch
```

If you have a movie file, you need to have ffmpeg installed. Depending on system:
```
brew install ffmpeg
```

Go to appropriate section:

## Have Movie file

Extract audio from movie file using ffmpeg. Adjust the file extensions as needed:
```
ffmpeg -i input.mp4 -q:a 0 -map a sample.mp3
```

## Have Audio file

Good to move to next section

---

## Run Whisper to get SRT file or Txt file

Make sure the audio file is in the same folder as this python script.

Adjust INPUT_AUDIO to your extracted or input audio filename. 

Adjust your CPU/GPU settings as necessary (CUDA for NVIDIA, etc)

This script is coded to write a SRT subtitle file. If you want a text file with no time marks, set `word_timestamps` to `False`, and pass `"txt"` instead of `"srt"` at calling `get_writer`.

When the script runs successfully, it'll create a .srt or .txt file to the output directory. 

```
import os
import whisper
from whisper.utils import get_writer
from chosen_model_parameters import MODEL, DEVICE

# _ADJUST relative input audio, desired output directory, and desired output basename with file extension 1 of 2
INPUT_AUDIO="input.mp3"
OUTPUT_DIR="./"
OUTPUT_FILENAME_W_EXT="output.srt"

try:
    print("Load Whisper model:", )
    whisper_model = whisper.load_model(MODEL, device=DEVICE)  # For CPU processing
    # Detailed timestamps for when each word was spoken in the audio to help DaVinci timeline with syncing
    print(f"Read {INPUT_AUDIO} and create the subtitle file {OUTPUT_DIR}{OUTPUT_FILENAME_W_EXT}")
    transcription_result = whisper_model.transcribe(audio=INPUT_AUDIO, initial_prompt="prompt", word_timestamps=True)

    # _ADJUST 2 of 2: max_line_count and max_line_width
    # Word formatting options
    # highlight_words: Underline each word as it is spoken in srt and vtt
    # More options at: https://github.com/openai/whisper/blob/main/whisper/transcribe.py
    
    # 1/15 = 0-1 secs per subtitle screen
    # 2/15 = 1 secs per subtitle screen
    # 3/15 = 1-2 secs per subtitle screen
    # 1/30 = 1-2 secs per subtitle screen # /30 is reasonable for Text+ with OpenSans Size .09
    # 2/30 = 2-3 secs per subtitle screen # /35 is widest for Text+ with OpenSans Size .09
    # 3/30 = 3-4 secs per subtitle screen
    # 1/40 = 1-2 secs per subtitle screen
    # 2/40 = 3-4 secs per subtitle screen
    # 3/40 = 6 secs per subtitle screen
    # 1/45 = 1-2 secs per subtitle screen
    # 2/45 = 3-4 secs per subtitle screen
    # 3/45 = 6 secs per subtitle screen
    # 1/50 = 2 secs per subtitle screen
    # 2/50 = 4 secs per subtitle screen
    # 3/50 = 6-7 secs per subtitle screen
    # 1/55 = 2-3 secs per subtitle screen
    # 2/55 = 4-5 secs per subtitle screen
    # 3/55 = 7-8 secs per subtitle screen
    # 1/60 = 2-3 secs per subtitle screen
    # 2/60 = 6-7 secs per subtitle screen
    # 3/60 = 10-13 secs per subtitle screen
    # 1/65 = 3-4 secs per subtitle screen
    # 2/65 = 7-9 secs per subtitle screen
    # 3/65 = 11-13 secs per subtitle screen
    word_formatting = {
        "highlight_words": False,
        "max_line_count": 1,
        "max_line_width": 30
    }

    write_to_dir = get_writer("srt", os.path.dirname(OUTPUT_DIR))
    write_to_dir(transcription_result, os.path.basename(OUTPUT_FILENAME_W_EXT), word_formatting)

except Exception as e:
    print("Error transcribing audio:", e)
else:
    print(f"\nTranscription completed. Check the output file: {OUTPUT_DIR}{OUTPUT_FILENAME_W_EXT}")

```


Also make sure to have `chosen_model_parameters.py` to help choose the proper device (cpu or cuda for nvidia, etc):
```

import torch
from dep_constants import tiny_model, base_model, small_model, medium_model, large_model, large_v2_model

# print("mps available? ", torch.backends.mps.is_available()) #mps is not powerful enough but under development as of 9/2024
# print("mps is built? ", torch.backends.mps.is_built())
# print("mps is built? ", torch.cuda.is_available())
algo_device = "cuda" if torch.cuda.is_available() else "cpu"


# _ CHOOSE AS APPROPRIATE
MODEL = base_model

DEVICE = algo_device # override with a string "cuda", "cpu", etc, or let the script decide for you
```
## Where to go from here

A .SRT file looks like:
```
1
00:00:00,000 --> 00:00:02,500
Welcome to the Example Subtitle File!

2
00:00:03,000 --> 00:00:06,000
This is a demonstration of SRT subtitles.

3
00:00:07,000 --> 00:00:10,500
You can use SRT files to add subtitles to your videos.
```

If you need the SRT file but in the future you might need pure text, you can have ChatGPT remove the SRT formatting. Just ask (and if too long, you can feed it into ChatGPT in pieces):
```
Below is my SRT file. Please remove all SRT formatting. I do not need the timemarks
```

With either the SRT file or the TXT file, you can ask questions against the text with ChatGPT or NotebookLM as a prompt engineer. Or if you want to practice as an AI Engineer, you can have a text file input and perform RAG querying with PrivateGPT (Refer to [[RAG augment PDFs, txts, csv to LLM with PrivateGPT]]).