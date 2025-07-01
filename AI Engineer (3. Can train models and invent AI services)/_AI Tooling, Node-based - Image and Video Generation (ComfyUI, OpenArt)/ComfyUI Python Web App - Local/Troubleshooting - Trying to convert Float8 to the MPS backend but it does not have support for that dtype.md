
Got this error?
`Trying to convert Float8... to the MPS backend but it does not have support for that dtype.`
![[Pasted image 20250701015259.png]]

Are you on the **Mac App**?
Tough luck, you should've installed the python web app or run one of the cloud options. If you install the python web app, then you will run into the same problem because this is a Mac issue, then you may come back to this tutorial to continue forward on how to fix

---

Run main.py with MPS fallback to cpu for pytorch operations and use memory optimization split cross attention for performance if it can (some workflows could make it work for CPU/MPS, but it definitely works on GPU CUDA) and explicitly force cpu processing.
```
PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --force-fp16 --use-split-cross-attention --cpu
```

---

## In Details

#### ✅ `PYTORCH_ENABLE_MPS_FALLBACK=1`

- This enables fallback to CPU if a PyTorch operation isn't supported on **MPS (Apple’s GPU backend)**.
    - It **does not** _force_ MPS. It only helps _if_ you're already using MPS and hit an unsupported PyTorch operation.
    
---

#### ✅ `--force-fp16`

- This flag forces use of **float16 precision**, often for performance.
- On CPU or MPS, this may be ignored or lead to limited benefit depending on support.

---

#### ✅ `--use-split-cross-attention`

- Forces **split attention mechanism**, which is a memory optimization.
- Works mostly with GPU (CUDA), but some workflows try to make it work for CPU/MPS.

---

#### ❌ `--cpu`

- This explicitly **forces CPU usage**, disabling GPU (MPS or CUDA) entirely.
- This means: **you're not using MPS at all** — everything runs on CPU.

---

### ✅ If You Want to Use MPS:

You'd drop `--cpu`, and instead do something like:

```bash
PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --force-fp16 --use-split-cross-attention
```

…but actual MPS use depends on:

- Whether your PyTorch is compiled with MPS support (macOS + PyTorch >= 1.12)
- Whether the models/nodes you use support MPS
- Whether your system has Apple Silicon or a compatible GPU