Run main.py with MPS fallback to cpu for pytorch operations and use memory optimization split cross attention for performance if it can (some workflows could make it work for CPU/MPS, but it definitely works on GPU CUDA) and whether you explicitly force cpu processing.

Explicitly forcing cpu processing:
```
PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --force-fp16 --use-split-cross-attention --cpu
```

Try NOT explicitly forcing cpu processing, so it uses MPS:
```
PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --force-fp16 --use-split-cross-attention --cpu
```

Recall that MPS:

**MPS is Apple’s GPU backend** for accelerating machine learning workloads using **Apple Silicon GPUs** (e.g., M1, M2, M3). Recall that the Apple chip M1/M2/M3 is actually a CPU with an integrated GPU, although it's not a discrete GPU like NVIDIA or AMD.