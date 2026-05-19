
Substitute text with:
- The original string is in two places, and the substituting string is in one place:
```
grep -rlZ --exclude-dir=.git --exclude-dir=node_modules --binary-files=without-match -- 'domain.com:27017' . \
  | xargs -0 -r perl -pi -e 's/\Qdomain.com:27017\E/127.0.0.1:27017/g'
```
