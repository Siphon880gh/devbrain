Merge conflicts during a rebase can pop up in any commit you pick—even ones outside the range you actually want to squash/fixup/reword/edit. To avoid this, limit the commits you’re rebasing at once.

For example, say you run:

```text
pick a1b2c3d Initial commit
pick d4e5f6g Add README
pick h7i8j9k Implement feature X
pick k1l2m3n Fix edge-case in parser
pick o4p5q6r Add unit tests
pick s7t8u9v Update docs
pick w0x1y2z Clean up formatting
pick 3a4b5c6 Optimize performance
pick 7d8e9f0 Merge latest from main
pick g1h2i3j Hotfix typo
pick 932jksa Fix typos
```

…and you only meant to modify the last two commits:

```text
pick g1h2i3j Hotfix typo
fixup 932jksa Fix typos
```

If you’d scoped your interactive rebase to just those (for example, `git rebase -i HEAD~2`), you’d never hit the conflicts coming from an earlier commit—like this one:

```text
pick k1l2m3n Fix edge-case in parser
```

Narrowing your rebase window to exactly the commits you care about keeps unrelated conflicts from cropping up.