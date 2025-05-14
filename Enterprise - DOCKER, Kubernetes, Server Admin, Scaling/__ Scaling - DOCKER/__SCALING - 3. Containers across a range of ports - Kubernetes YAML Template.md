**Where we are**: Docker containers spin up to the next available port number and spin down automatically -> So I am adding Kubernetes

Required reading: [[__SCALING - 2. Containers across a range of ports - Auto-Orchestration]]

---

Here’s a **minimal Kubernetes YAML setup** to deploy your Docker container image with load balancing and autoscaling. This will include:

1. **Deployment**: Runs multiple instances (replicas) of your container 
2. **Service**: Exposes your app to the network  
3. **Horizontal Pod Autoscaler (HPA)**: Scales pods up/down based on CPU usage

---

## ✅ 1. Deployment (your app)

```yaml
# deployment.yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: my-app
spec:
  replicas: 2  # Starting number of pods
  selector:
    matchLabels:
      app: my-app
  template:
    metadata:
      labels:
        app: my-app
    spec:
      containers:
      - name: my-app
        image: your-dockerhub-username/your-image-name:latest
        ports:
        - containerPort: 3000
        resources:
          requests:
            cpu: "100m"
          limits:
            cpu: "500m"
```

> 🔁 Replace `your-dockerhub-username/your-image-name:latest` with your actual image.

---

## ✅ 2. Service (exposes your pods to the outside)

```yaml
# service.yaml
apiVersion: v1
kind: Service
metadata:
  name: my-app-service
spec:
  type: LoadBalancer  # or use ClusterIP + Ingress for internal routing
  selector:
    app: my-app
  ports:
  - protocol: TCP
    port: 80        # External port
    targetPort: 3000  # Internal container port
```

> ✅ Kubernetes will load balance between all pods using this service.

---

## ✅ 3. Autoscaler (CPU-based)

```yaml
# hpa.yaml
apiVersion: autoscaling/v2
kind: HorizontalPodAutoscaler
metadata:
  name: my-app-hpa
spec:
  scaleTargetRef:
    apiVersion: apps/v1
    kind: Deployment
    name: my-app
  minReplicas: 2
  maxReplicas: 10
  metrics:
  - type: Resource
    resource:
      name: cpu
      target:
        type: Utilization
        averageUtilization: 50  # Scale if CPU > 50%
```

---

## 🚀 Apply All Resources

Once your cluster is ready and `kubectl` is configured:

```bash
kubectl apply -f deployment.yaml
kubectl apply -f service.yaml
kubectl apply -f hpa.yaml
```

---

## 🛠 What's Next: Ingress for Domain Routing (if you have a domain name)

If you want `myapp.example.com` routed to this service, you'll have to work on an Ingress config and TLS with cert-manager.

Let's continue to [[__SCALING - 4. Containers across a range of ports - Ingres Controller]]

