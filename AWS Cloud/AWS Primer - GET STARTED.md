
Some services used in online websites with AWS:
- DynamoDB
- S3 cloud storage that's scalable
- EC2 elastic containers that can run from Docker image, can host a web server, etc. You're not forced to load from a docker file. The os are loaded from a docker file. This is all under Containers service section.
- ECS will handle autoscaling of EC2 instances. However you can decide to run only EC2 without ECS, therefore no autoscaling of more server instances. That is under Compute service section.
- ECR is registry that lets you push docker into and to load from for ECS. It's under Containers service section.
  https://medium.com/@smihahawan/build-and-push-docker-image-to-aws-ecr-part-2-e208f343e570

---

## ECS cluster of EC2 - Here are some key points about ECS:

- **Docker Compatibility**: ECS is fully compatible with Docker, allowing you to use standard Docker CLI commands to push, pull, and manage images.
    
- **Orchestration and Scheduling**: ECS provides built-in orchestration and scheduling capabilities, allowing you to run and maintain a specified number of instances of a task definition simultaneously in an ECS cluster.
    
- **Elasticity**: ECS automatically scales your application up or down based on your specifications.
    
- **Integration**: ECS is deeply integrated with other AWS services, such as Amazon Route 53, AWS Identity and Access Management (IAM), and Amazon CloudWatch, providing a rich ecosystem for deploying and managing containerized applications.
  
- **SSH**: SSH terminal access is possible if you had enabled. But any manual changes (such as file modifications, software installations, or settings adjustments) you've made to an EC2 instance will not automatically propagate to the new instances created as part of the autoscaling process.
	- Reworded: When ECS autoscales, the new EC2 instances that are launched are based on the instance configuration defined in your ECS service's launch configuration or launch template, not directly on any manual changes you've made to existing EC2 instances via SSH. This means that any manual changes (such as file modifications, software installations, or settings adjustments) you've made to an EC2 instance will not automatically propagate to the new instances created as part of the autoscaling process.
    

To host a web server or any application on ECS, you would package your application in a Docker container, push it to a registry like ECR, and then use ECS to deploy and manage your containers either on EC2 instances or with Fargate.


---

## EC2 Compute
If you choose to run EC2 instance without ECS:
- That's considered a compute service. This is similar to buying a VPS from traditional hosting
- There will be no autoscaling. You may need Kubernetes if the traffic gets to that point.
- Great for small apps with low traffic
- Can allow for SSH in


---

Signup
https://signin.aws.amazon.com/

Log back in:
https://console.aws.amazon.com/console/home?nc2=h_ct&src=header-signin

---

Where is EC2?
Services -> Containers -> Elastic Container Service

EC2 vs Fargate
Fargate - serverless. dont need to know about the hardware or os
https://www.youtube.com/watch?v=DVrGXjjkpig
![](kokZ6ka.png)
