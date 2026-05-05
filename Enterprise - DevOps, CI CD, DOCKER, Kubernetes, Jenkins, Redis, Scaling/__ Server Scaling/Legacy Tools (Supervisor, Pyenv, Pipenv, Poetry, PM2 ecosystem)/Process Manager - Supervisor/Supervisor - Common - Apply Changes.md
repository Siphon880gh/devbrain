
While fixing supervisor conf or supervisor app conf files. How to tell supervisor to re-read the config files for new changes?

- 1. Re-read config files (finds new changes but doesn't apply yet): `supervisorctl reread`
- 2. Apply changes (add/remove programs): `supervisorctl update`