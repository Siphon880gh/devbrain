
If new to Pytorch, it isn't recommended to go directly into it. Instead, you should look into using Whisper which relies on Pytorch.

You'll see Pytorch can select the algorithm to work with your processor (CUDA, etc), then loads in the LLM model, then takes in your inputs and instructions, then spits out your output, simply put.

