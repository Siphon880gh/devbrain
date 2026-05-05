
```

transitions = {
    0: (1, "cross_dissolve"),
    1: (2, "cross_dissolve")
}

i = 0
assert i in transitions, "i in transitions - should be True"

i = 0
assert i in transitions and transitions[i][1]=="cross_dissolve", " transitions[i][1]==\"cross_dissolve\" - should be True"

j = i-1
assert (i-1 in transitions)==False, "i in transitions - should be False"
```

^ You can find if a key exists like 0 or 1 from 0: or 1:. Then you can access "cross_dissolve" with a `transitions[0][1]`.