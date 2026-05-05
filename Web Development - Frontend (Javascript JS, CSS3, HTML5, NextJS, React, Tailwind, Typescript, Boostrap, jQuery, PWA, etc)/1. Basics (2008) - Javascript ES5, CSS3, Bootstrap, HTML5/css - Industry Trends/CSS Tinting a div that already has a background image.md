
```
.div {
  background-image: url('image.jpg'); 
    position: relative;
}


.div:before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 255, 0.5); /* blue overlay */
}
```

Key points: position of div must be relative, then a pseudoelement:before will be absolute