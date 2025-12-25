Learn the basics of LM Studio while transcribing an audio recording. On Mac, we will purposely fail and learn to recover using a fallback. This is an important skill to know how to try fallback methods since local AI usually doesn't work well on Mac regardless if it's Msty or LMStudio.

Note: If you dont have an audio recording, open Voice Memos on your iPhone and record a small snippet (Maybe something like: “The quick brown fox jumps over the lazy dog”), then airdrop the audio to your computer.

---

Note`ffmpeg` is required because **Whisper (and most audio processing libraries)** rely on it to decode audio files — especially compressed formats like `.m4a`, `.mp3`, or `.aac`. If need to install on mac: `brew install ffmpeg`

---

![[Pasted image 20251225013035.png]]

Lets try aiming for audio file to transcription Whisper model which is open source. There re various sizes:

Tiny → base → small → medium → large

On a M1 MacBook Pro (16GB RAM, ~40GB free storage) 
      a. “Small” model is sufficient for personal notes and short recordings.    
      b. “Small” model can transcribe ~5 minutes of audio in under 5 minutes on this setup.  

The Whisper small model is about 250-300 MB.


---

Orientation to searching models:

Consider Most Likes or Most Downloads (Best Matches isn’t very good as of Dec 2025):
![[Pasted image 20251225013119.png]]

![[Pasted image 20251225013130.png]]

GGUF models are LLMs stored in highly efficient, single-file binary format designed for fast loading and running on consumer hardware, especially CPUs, by using quantization (reducing precision to save memory). Developed for the GGML framework.
- If you see GGML in the wild, it’s an older version of GGUF. The newer version GGUF incorporates additional data about the model.

MLX are models optimized for Mac chips like M1/M2/M3 but it’s not a guaranteed. You can still download a MLX on your Mac that fails to load into LM Studio when you reach the chat interface, OR it doesn’t even allow you to download at Model Search:

Here’s me not being able to download a MLX model at Model Search, even though I’m on a MacBook Pro M1 chip:

![[Pasted image 20251225013150.png]]

---

Here’s a model that can download into LM Studio:
![[Pasted image 20251225013225.png]]

Download at the bottom right button:
![[Pasted image 20251225013238.png]]

When it finished download, it asks to Load Model. Make sure to load it:
![[Pasted image 20251225013311.png]]

But at Chat Interface, it failed to load!
![[Pasted image 20251225013327.png]]

It won’t load into Chat Interface. The model is still on your computer though. This is a good time to review how to delete models downloaded on LM Studio:
![[Pasted image 20251225013346.png]]

  As for getting it to work -  don’t worry, just keep looking for another model. But if you want to cut to the chase, Whisper works in the terminal if you’re willing to run the model directly. **INSTRUCTIONS FOR THAT ARE AT:** [[Transcribe audio file to text in terminal (Whisper small)]]

---

**Staff picks appear as purple. Usually it’s under Most Downloads. The Staff picks are really what’s recommended likely to work on your computer.**

![[Pasted image 20251225013407.png]]

---

There could be a model you found on Github you want to try. Let’s use Voice transcription Whisper small as an example

Or on LM Studio you found a model you want to try that **SHOULD WORK** but wont download the LM Studio. There are instructions how to use:
![[Pasted image 20251225013434.png]]

The problem with this particular model is the instructions are outdated. It works just fine on MacBook Pro M1

The correct instructions are:
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
  