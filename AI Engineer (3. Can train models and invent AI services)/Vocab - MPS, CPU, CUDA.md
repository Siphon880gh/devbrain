
In the context of:

### 💡 Apple Silicon GPU Overview (M1/M2/M3)

|Chip|Integrated GPU|GPU Cores|FP32 Performance|
|---|---|---|---|
|M1|Yes|7 or 8|Up to 2.6 TFLOPS|
|M2|Yes|8 or 10|Higher than M1|
|M3|Yes|10+|Even faster, includes hardware ray tracing|

Unlike discrete GPUs (e.g., NVIDIA or AMD), Apple’s GPUs are **integrated** directly into the system-on-chip (SoC), sharing memory and bandwidth with the CPU using a **unified memory architecture**.

Instead of using **CUDA** (NVIDIA’s GPU computing platform), Apple GPUs rely on **Metal**, Apple’s proprietary graphics and compute framework.

PyTorch interacts with Apple GPUs through the **MPS (Metal Performance Shaders)** backend. This is Apple's alternative to CUDA, enabling GPU acceleration on macOS. However, **MPS is still less mature and less optimized** compared to CUDA, meaning certain models and operations may be slower or unsupported.

On macOS, if a model or operation is not supported by MPS, PyTorch may fall back to **CPU** execution—slower, and not always compatible.