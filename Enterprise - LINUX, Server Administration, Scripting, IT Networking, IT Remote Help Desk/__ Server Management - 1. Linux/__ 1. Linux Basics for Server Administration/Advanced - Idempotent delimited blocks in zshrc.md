When you add a bundle of aliases or functions to `~/.zshrc`, wrap it in unique markers so you can find it later and so a second run does not paste the same block twice.

```zsh
# >>> Codex convenience shortcuts >>>
alias cx='codex'
# ...
# <<< Codex convenience shortcuts <<<
```

Rules:

- The block must stay compatible with an otherwise empty or heavily customized `.zshrc`.
- If an older block with the same markers already exists, replace that block. Do not append another copy.
- Running the same setup again must not duplicate aliases, functions, or keys.

This is the same idea as keeping Git sugar aliases in one labeled section. See [[Git Sugar Aliases - Small Tweaks That Make Git on the Command Line Better]].
