Some containers require specific architecture, for example there being arm64 images (for Mac M1, M2), because of it using system level tools, etc

Or depend on libraries that are compiled for specific processor architectures, such as x86_64 for typical Intel/AMD CPUs or arm64 for Apple M1/M2 chips and other ARM-based processors. The architecture determines how code executes at the hardware level, so images built for x86_64 may not run properly on arm64 systems and vice versa.

Usually error is not obvious.