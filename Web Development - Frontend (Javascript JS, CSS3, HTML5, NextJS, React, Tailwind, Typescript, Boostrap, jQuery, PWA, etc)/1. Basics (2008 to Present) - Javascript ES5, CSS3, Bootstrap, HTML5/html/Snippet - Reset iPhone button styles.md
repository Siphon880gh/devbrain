Stop iPhone safari making buttons rounded with:
```
.override-ios-button-round-style-to-rectangular {
    -webkit-appearance: none !important;
    -webkit-border-radius: 0 !important;
    border-radius: 0 !important;
    height: 2.5rem;
}
```

Notice webkit appearance might make checkboxes or radio buttons disappear, so we are using classes instead. So you'd have to add that class to your buttons.

Otherwise, you can select for all inputs with this selector if you do not care about disappearing checkboxes or radio buttons:
`
textarea,
button,
input[type]
`