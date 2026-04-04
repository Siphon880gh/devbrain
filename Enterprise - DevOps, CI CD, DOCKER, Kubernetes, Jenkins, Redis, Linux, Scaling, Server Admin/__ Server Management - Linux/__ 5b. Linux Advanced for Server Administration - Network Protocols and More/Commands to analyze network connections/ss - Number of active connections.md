Count active HTTPS connections

```
sudo ss -Htan state established sport = :443 | wc -l
```

- wc is word count

This tells you only one connection visiting your https at the moment:
![[Pasted image 20260328022602.png]]
