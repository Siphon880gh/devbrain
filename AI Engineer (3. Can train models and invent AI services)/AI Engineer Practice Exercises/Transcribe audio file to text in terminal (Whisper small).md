Let’s do Voice transcription Whisper small

Note`ffmpeg` is required because **Whisper (and most audio processing libraries)** rely on it to decode audio files — especially compressed formats like `.m4a`, `.mp3`, or `.aac`. If need to install on mac: `brew install ffmpeg`

Run the following:
```
git clone http://github.com/ml-explore/mlx-examples.git  
cd mlx-examples/whisper/mlx_whisper  
cd ..  
echo -e 'import whisper\nmodel = whisper.load_model("small")\nresult = model.transcribe("INPUT.m4a")\nprint(result["text"])' > test.py
```

Now you can edit [test.py](https://test.py "https://test.py") maybe with `vi test.py` :
```
import whisper  
model = whisper.load_model("small")  
result = model.transcribe("INPUT.m4a")  
print(result["text"])
```

>[!note] requirements.txt (FYI, they are):
> mlx>=0.11
> numba
> numpy
> torch
> tqdm
> more-itertools
> tiktoken
> huggingface_hub
> scipy
>

Adjust the filename to the audio file. Make sure to drop the audio file into the same folder where [test.py](https://test.py "https://test.py") is since we are running it all relatively in the same folder.

Now to begin the transcription from the audio into text, run:
(it may appear to hang and that’s it working)
![[Pasted image 20251225013543.png]]

A few things to note. It knows where to place periods because this is an AI model. I had said New Line, New Line as if it were an iphone on-screen keyboard transcription. Just ignore that. If it seems gibberish, these are my fleeting thoughts on how to have AI analyze a codebase, then jumped to mind map app  

If fail to run, try `python`  or `python3` . And try downloading the model via LM Studio (Install LM Studio if haven’t). Search for the model in LM Studio:
- If on Mac:
  ![[Pasted image 20251225013609.png]]
  ^ Yes the Use with mlx instructions are outdated compared to our instructions.
  