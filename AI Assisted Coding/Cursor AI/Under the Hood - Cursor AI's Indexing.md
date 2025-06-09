When working with large projects or collaborating across teams, keeping your codebase synced and your AI context up-to-date can be a challenge—especially without wasting bandwidth or slowing down your machine. Cursor solves this with a smart codebase indexing system powered by Merkle trees.

## Why Indexing Matters

Cursor uses an intelligent syncing mechanism to avoid uploading your entire codebase repeatedly. Instead, it tracks file changes efficiently and only syncs what’s necessary. This enables:

- Faster performance during development
    
- Reduced data transfer
    
- More responsive AI suggestions with up-to-date context
    

## How It Works

Here’s how the codebase indexing feature operates when enabled:

1. **Initial Scan**  
    Cursor scans the folder you open and computes a **Merkle tree**—a hierarchical structure made of cryptographic hashes—for all files.
    
2. **Ignore Rules**  
    Files and directories listed in `.gitignore` or `.cursorignore` are excluded, ensuring only relevant project files are tracked.
    
3. **Sync to Server**  
    The generated Merkle tree is then synced to the server, allowing Cursor to understand the structure and contents of your codebase without uploading everything.
    
4. **Incremental Updates**  
    Every 10 minutes, Cursor checks for hash mismatches to detect what has changed. Only the modified files are re-uploaded—keeping things efficient and fast.
    

## The Benefits

This Merkle tree–based system offers major advantages:

- **Performance**: Only changed files are uploaded, so the system remains fast even for large projects.
    
- **Security**: Hashed indexing helps reduce raw file transmission.
    
- **Accuracy**: The AI can offer better completions, search results, and context-aware actions based on your actual working directory.
    

## Conclusion

By using Merkle trees and selective syncing, Cursor keeps your workspace lean, fast, and up-to-date—without overwhelming your network or sacrificing accuracy. This behind-the-scenes optimization is one of the key reasons Cursor can offer intelligent developer support at scale.