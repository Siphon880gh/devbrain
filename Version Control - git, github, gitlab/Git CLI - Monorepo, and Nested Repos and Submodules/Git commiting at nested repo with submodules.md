Git commit each nested repo/submodule individually and then git commit the root repo.

The root repo can easily be committed with a message like "Updated submodule pointers"

The key is to keep submodules clean and not dirty when running `git status` at root.