Do not allow free storage size to drop to like 2GB. Your git repos on the computer that are also synced up will corrupt. Git will stop working, giving either these errors:
- [[Git commands frozen]]
- [[Git error - could not write index]]
- [[Git error - short read while indexing]]

After freeing up storage space, your sync service (Apple Cloud, Google Drive, Microsoft OneDrive) will sync up and finish, but it will fail to correctly sync in .git despite passes. You'd have to follow the above troubleshooting documents to fix your computer repos.