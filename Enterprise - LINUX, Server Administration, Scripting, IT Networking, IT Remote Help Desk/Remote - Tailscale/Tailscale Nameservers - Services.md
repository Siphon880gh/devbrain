Requirement: You must have setup [[Tailscale Nameservers (Mac)]] so that the basic methods of setting up hostnames and base urls work

Here we will use Tailscale's services that allow you to host nodejs, python, databases etc among the tailscale network using identifiable url's (not IP with ports) much like subdomains or reverse proxies:

- app1.tailXXX.ts.net
- app2.tailXXX.ts.net
- db.tailXXX.ts.net
- etc

Setup the services to the desired port (for example a NodeJS app that's currently running at port 3000):
![[Pasted image 20260422002538.png]]

Copy URL. Try to visit in the web browser. It will fail (and hence Hosts will remain 0 because no Host able to connect to the service yet)
![[Pasted image 20260422002913.png]]

---

Make sure use service name that you created from the Services tab. The service name goes after "-service=svc:"
```
tailscale serve --service=svc:test --http=80 http://127.0.0.1:3000
```

![[Pasted image 20260422015607.png]]

Approval:
![[Pasted image 20260422020521.png]]

![[Pasted image 20260422020630.png]]

If you want to double check, the Access Controls JSON Editor should have these lines (or some variation of them):
```
"tagOwners": {"tag:owner":["USER@gmail.com"]},
"autoApprovers": {"services:" {"svc:SERVICE_NAME": ["tag:owner"]}}
```
OR
```
"tagOwners": {"tag:owner":["USER@gmail.com"]},
"autoApprovers": {"services:" {"svc:SERVICE_NAME": ["USER@gmail.com"]}}
```
OR
```
"tagOwners": {"tag:owner":["USER@gmail.com"]},
"autoApprovers": {
"services:" 
{
	"svc:SERVICE_NAME_1": ["tag:owner"], 
	"svc:SERVICE_NAME_2": ["tag:owner"], 
	"svc:SERVICE_NAME_3": ["tag:owner"]}
}
}
```

Let's visit the proposed URL (See at previous screenshot breadcrumb `All Services/test.tail844572.ts.net`) Success is:
![[Pasted image 20260422020455.png]]


### Troubleshooting
`tailscale serve -service=svc:yourservice-https=443 http://127.0.0.1:3000`
service hosts must be tagged nodes

![[Pasted image 20260422020436.png]]

The machine that hosts the service needs a tag that shows ownership:
![[Pasted image 20260422021104.png]]
So tag your machine at the Machines tab with an ownership tag.
![[Pasted image 20260422020729.png]]

Don't have an ownership tag? Create one at **Access Controls -> Tags**
And select the owner when making the tag.

One additional step:
General access rules should be permissive. Add a very permissive rule.

The next step:
Allow auto approving of services: Access controls -> Auto approvers:
![[Pasted image 20260422040450.png]]
^ Notice the Service column svc:test is NOT a tag. It's just a shorthand saying the service name under Service column

There's an ownership tag called test and a service called test. They do not need to be the same name though.

?
Do we add a tag of tag owner under Service?

Correlates to Access controls -> JSON editor, noting `tagOwners` and `autoApprovers`:
![[Pasted image 20260422020829.png]]

---

Troubleshooting

Use verbose mode on curl and you might see a 403, then it's likely an access controls issue OR the process itself (ollama etc). Ollama doesnt work well with tailscale btw
- Regarding Ollama: Ollama is the component with explicit documented requirements about the proxied `Host` header. Put a tiny local reverse proxy in front of Ollama that rewrites the `Host` header, then point Tailscale Serve at that proxy. If you have nginx: `proxy_set_header Host localhost:11434;`