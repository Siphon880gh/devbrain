Change all string into literals in Regular Expression

function escapeRegExp(string) {
  return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
}

Source:
https://stackoverflow.com/questions/3446170/escape-string-for-use-in-javascript-regex