
- Do we have IPMI (Intelligent Platform Management Interface) to perform tasks like recovery on my end?
- I could also create VM inside the dedicated server so I can restart or reinstall the VPS itself when things fail.

- Can the CPU handle hardware virtualization? If it can handle virtualization, can it support the type of hardware virtualization: KVM. The reason I ask is because hardware virtualization is faster than OS virtualization and KVM is the faster hardware virtualization versus other types of hardware virtualizations. If your server doesn’t support it, will the other way of virtualizing VM be a significant performance hit?

- Is your dedicated server technically a hypervisor (or virtualized) rather than a MaaS solution*. If your server is a hypervisor/virtualized, can we enable nested virtualization so I can virtualize VMs? Would there be a significant performance hit with nested virtualized VMs?

---

\*Virtualized vs MaaS

| Feature                  | Hypervisor-Based Solution                                                       | MaaS Solution                                                                         |
| ------------------------ | ------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------- |
| **Definition**           | Software that creates and manages virtual machines on a single physical server. | Provisioning system that automates the deployment and management of physical servers. |
| **Performance**          | Some overhead due to virtualization                                             | Maximum performance (bare-metal)                                                      |
| **Flexibility**          | High flexibility with VM management                                             | Flexible physical server management                                                   |
| **Resource Utilization** | Efficient through VMs                                                           | Potential underutilization if not fully used                                          |
| **Scalability**          | Easy to scale with more VMs                                                     | Scales by adding more physical servers                                                |
| **Complexity**           | Complex at scale with many VMs                                                  | Simplifies physical server management                                                 |
| **Use Cases**            | Multiple isolated apps/services, testing                                        | High-performance computing, big data                                                  |

---

\* How to find out if their dedicated server is virtualized

Running `lscpu` can provide some insights into whether a dedicated server is virtualized or a physical dedicated machine, though it's not always definitive. Here are some indicators you can look for in the output of `lscpu`:

1. **Hypervisor Vendor**: If you see entries like `Hypervisor vendor: KVM` or `Hypervisor vendor: VMware`, it indicates that the server is virtualized.

2. **Flags**: Look for virtualization-related CPU flags. Common flags for virtualization include:
   - `vmx` for Intel Virtualization Technology (VT-x)
   - `svm` for AMD Virtualization (AMD-V)

   If you see flags like `hypervisor` or `kvm` in the list, it suggests a virtualized environment.

3. **CPU Model Name**: Sometimes the CPU model name might give you a hint. For example, some cloud providers or virtualized environments might use specific CPU model names that include the hypervisor name.

Here’s an example output of `lscpu` on a virtualized machine:

```
Architecture:                    x86_64
CPU op-mode(s):                  32-bit, 64-bit
Byte Order:                      Little Endian
CPU(s):                          4
On-line CPU(s) list:             0-3
Thread(s) per core:              1
Core(s) per socket:              4
Socket(s):                       1
NUMA node(s):                    1
Vendor ID:                       GenuineIntel
CPU family:                      6
Model:                           85
Model name:                      Intel(R) Xeon(R) CPU @ 2.30GHz
Stepping:                        4
CPU MHz:                         2299.998
BogoMIPS:                        4599.99
Hypervisor vendor:               KVM
Virtualization type:             full
L1d cache:                       128 KiB
L1i cache:                       128 KiB
L2 cache:                        1 MiB
L3 cache:                        8 MiB
NUMA node0 CPU(s):               0-3
Flags:                           fpu vme de pse tsc msr pae mce cx8 apic sep mtrr pge mca cmov pat pse36 clflush mmx fxsr sse sse2 ss ht sys ...
```

In this output, the `Hypervisor vendor: KVM` line clearly indicates that the server is virtualized using KVM.

If the output does not include a hypervisor vendor or virtualization flags, it might suggest that the server is a physical dedicated machine. However, absence of these indicators is not always conclusive proof, as some virtualization environments might not expose these details.

If you need more definitive evidence, you might also consider checking other system information tools like `dmidecode`, `dmesg`, or virtualization-specific directories in `/sys` or `/proc`.

---

\* So what to do? Or continue with the provider?
You could look for an ACTUAL dedicated machine with another provider if performance hit becomes an issue or nested virtualization cannot be supported. Nested virtualization: Since the server is already virtualized, you are virtualizing some more when adding VMs, hence is nested.