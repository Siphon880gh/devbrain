Checked php log:

```
[24-Apr-2026 00:10:53 UTC] PHP Warning:  Undefined array key "root_dir" in /home/wengindustries/htdocs/wengindustries.com/app/app/quizzes/Medical - Respiratory/Lung Sounds.php on line 55
[24-Apr-2026 00:10:53 UTC] PHP Warning:  require_once(/vendor/autoload.php): Failed to open stream: No such file or directory in /home/wengindustries/htdocs/wengindustries.com/app/app/quizzes/Medical - Respiratory/Lung Sounds.php on line 55
[24-Apr-2026 00:10:53 UTC] PHP Fatal error:  Uncaught Error: Failed opening required '/vendor/autoload.php' (include_path='.:/usr/share/php') in /home/wengindustries/htdocs/wengindustries.com/app/app/quizzes/Medical - Respiratory/Lung Sounds.php:55
```

These can cause a CPU spikes as visitors try to load your php website. Furthermore, your website may blank out.

**Solution:**
Open that directory in the SSH terminal, delete `vendor/` folder, and run `composer install` as non root.