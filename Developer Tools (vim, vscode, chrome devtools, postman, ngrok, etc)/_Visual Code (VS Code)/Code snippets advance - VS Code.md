# Code snippets advanced

## Placeholders
Placeholders are tabstops with values, like ${1:foo}. The placeholder text will be inserted and selected such that it can be easily changed. Placeholders can be nested, like ${1:another ${2:placeholder}}

## Choice
Placeholders can have choices as values. The syntax is a comma-separated enumeration of values, enclosed with the pipe-character, for example ${1|one,two,three|}. When the snippet is inserted and the placeholder selected, choices will prompt the user to pick one of the values.