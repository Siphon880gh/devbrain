Stuck on Installing gRPC-Core (1.28.2) when installing cocoa pods

I resolved it by deleting all the cache related to gRPC at /Users/<user>/Library/Caches/CocoaPods/Pods/Release/ and ../Specs/Release/, and running pod install again.

Also: It is dowing grpc core and it's submodule and it will take time. The file size is greater than or around 1 GB. So sit back and relax. If you would like to learn more then you can read my article about the same problem and the solution.

Also: pod install --verbose
Because you'll at least see what's going on