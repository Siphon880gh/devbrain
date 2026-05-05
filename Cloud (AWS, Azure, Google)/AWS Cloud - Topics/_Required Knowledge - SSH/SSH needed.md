
SSH keys is how one machine can allow another machine access. When you're SSHing from your computer into your Amazon EC2 instance to make more advance configuration, you need the proper SSH keys to prove who you are (that your machine is authorized).

You need to know how to generate SSH pairs (private key for your connecting computer, public key for your AWS), because when launching an EC2, you should specify SSH. 

Where to create SSH from AWS? When creating an EC2 instance, you have the option to select a previous pair or create a new pair. It'll carry over as a choice to future EC2 instances.

Refer to [[OpenSSH SSH Keys - Primer and Fundamental]] found under DevOps -> Servers - Unix

