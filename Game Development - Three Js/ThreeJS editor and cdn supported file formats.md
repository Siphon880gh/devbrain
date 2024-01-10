
Can import into editor (https://threejs.org/editor/):
![](https://i.imgur.com/XIbQ7ym.png)

Can import into webpage with three js cdn - NOT EXHAUSTIVE
Three.js supports a variety of formats for 3D models, each with its specific loader. Here's a list of common formats and their corresponding loaders in Three.js:

1. **FBX Format:**
   - Loader: `FBXLoader`
   - Usage:
     ```html
     <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/loaders/FBXLoader.js"></script>
     ```
     ```javascript
     const loader = new THREE.FBXLoader();
     loader.load('path/to/your/model.fbx', function(object) {
         scene.add(object);
     });
     ```

2. **glTF (GL Transmission Format):**
   - Loader: `GLTFLoader`
   - Usage:
     ```html
     <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/loaders/GLTFLoader.js"></script>
     ```
     ```javascript
     const loader = new THREE.GLTFLoader();
     loader.load('path/to/your/model.gltf', function(gltf) {
         scene.add(gltf.scene);
     });
     ```

3. **OBJ Format:**
   - Loader: `OBJLoader`
   - Usage:
     ```html
     <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/loaders/OBJLoader.js"></script>
     ```
     ```javascript
     const loader = new THREE.OBJLoader();
     loader.load('path/to/your/model.obj', function(object) {
         scene.add(object);
     });
     ```

4. **Collada (DAE Format):**
   - Loader: `ColladaLoader`
   - Usage:
     ```html
     <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/loaders/ColladaLoader.js"></script>
     ```
     ```javascript
     const loader = new THREE.ColladaLoader();
     loader.load('path/to/your/model.dae', function(collada) {
         scene.add(collada.scene);
     });
     ```

5. **STL Format (for 3D printing):**
   - Loader: `STLLoader`
   - Usage:
     ```html
     <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/loaders/STLLoader.js"></script>
     ```
     ```javascript
     const loader = new THREE.STLLoader();
     loader.load('path/to/your/model.stl', function(geometry) {
         const material = new THREE.MeshBasicMaterial({ color: 0x00ff00 });
         const mesh = new THREE.Mesh(geometry, material);
         scene.add(mesh);
     });
     ```

6. **PLY Format (Polygon File Format):**
   - Loader: `PLYLoader`
   - Usage:
     ```html
     <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/loaders/PLYLoader.js"></script>
     ```
     ```javascript
     const loader = new THREE.PLYLoader();
     loader.load('path/to/your/model.ply', function(geometry) {
         const material = new THREE.MeshStandardMaterial({ color: 0x0055ff });
         const mesh = new THREE.Mesh(geometry, material);
         scene.add(mesh);
     });
     ```

These are some of the most commonly used loaders in Three.js. Always ensure that you use the correct loader for the format of your model. Additionally, consider the size and complexity of the model, as large or highly detailed models can significantly affect performance and loading times. For the latest information and more detailed documentation, refer to the [Three.js documentation](https://threejs.org/docs/).
