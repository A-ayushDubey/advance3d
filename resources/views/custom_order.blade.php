@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/loaders/STLLoader.js"></script>

<script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/controls/OrbitControls.js"></script>
<style>

/* ===== HERO GRID BACKGROUND ===== */
.custom-hero {
    background: radial-gradient(circle, #0a0a0a, #000);
    position: relative;
    overflow: hidden;
    padding: 100px 20px;
    color: white;
}

.custom-hero::before {
    content: "";
    position: absolute;
    width: 200%;
    height: 200%;
    background-image: linear-gradient(45deg, #0d6efd22 1px, transparent 1px);
    background-size: 40px 40px;
    animation: moveGrid 20s linear infinite;
}

@keyframes moveGrid {
    0% { transform: translate(0,0); }
    100% { transform: translate(-100px,-100px); }
}

/* ===== PROCESS ===== */
.workflow {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.step {
    text-align: center;
    width: 22%;
}

.node {
    width: 70px;
    height: 70px;
    background: #111;
    border: 2px solid #0d6efd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin: auto;
    transition: 0.3s;
}

.step:hover .node {
    background: #0d6efd;
    transform: scale(1.1);
}

.connector {
    height: 3px;
    flex: 1;
    background: linear-gradient(to right, #0d6efd, #00d4ff);
}

@media (max-width:768px){
    .workflow {
        flex-direction: column;
        gap: 25px;
    }
    .connector {
        width: 3px;
        height: 40px;
    }
    .step {
        width: 100%;
    }
}
/* ===== HEX GRID ===== */
.showcase-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap: 15px;
}

.show-item {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
}

.show-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.4s;
}

.overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: linear-gradient(transparent, black);
    padding: 15px;
    opacity: 0;
    transition: 0.3s;
}

.show-item:hover img {
    transform: scale(1.1);
}

.show-item:hover .overlay {
    opacity: 1;
}

/* ===== FORM ===== */
/* .drop-zone {
    border: 2px dashed #0d6efd;
    padding: 40px;
    text-align: center;
    border-radius: 15px;
    cursor: pointer;
    background: linear-gradient(145deg, #0d0d0d, #141414);
    color: #aaa;
    transition: all 0.3s ease;
} */


/* .drop-zone:hover {
    background: #1a1a1a;
    border-color: #00d4ff;
    transform: scale(1.02);
} */

.drop-zone {
    border: 2px dashed rgba(13,110,253,0.5);
    padding: 40px;
    text-align: center;
    border-radius: 16px;
    cursor: pointer;

    /* background: linear-gradient(145deg, #0d0d0d, #050505); */
    /* background: #2f3030; */
    /* color: #fff; */

    transition: 0.3s;
}

.drop-zone:hover {
    border-color: #0d6efd;
    /* background: #111; */
    transform: scale(1.02);
}
.drop-zone.dragging {
    border-color: #00d4ff;
    background: #111;
    transform: scale(1.02);
}


/* .custom-form {
    max-width: 80%;
    margin: auto;
    background: #111;
    padding: 25px;
    border-radius: 15px;
    color: #fff;
} */
.custom-form {
    max-width: 1200px;
    margin: 40px auto;
    padding: 30px;
    border-radius: 20px;

    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(12px);

    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 20px 50px rgba(0,0,0,0.6);
}
.custom-form h5 {
    font-weight: 600;
    letter-spacing: 0.5px;
    /* color: #fff; */
}

/* 🔥 STICKY 3D PREVIEW */
.preview-panel {
    /* position: sticky; */
    top: 100px;
}

/* CARD STYLE */
.glass-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 15px;
    backdrop-filter: blur(10px);
}
.viewer-box {
    height: 400px;
    border-radius: 15px;
    overflow: hidden;
    background: radial-gradient(circle at center, #111, #000);
    border: 1px solid #222;
}
#viewer {
    border-radius: 16px;
    border: 6px solid red;
    overflow: hidden;
    border: 1px solid #222;
    box-shadow: inset 0 0 20px #000;
}

/* .custom-form input,
.custom-form select,
.custom-form textarea {
    background: #1a1a1a;
    border: 1px solid #333;
    color: #fff;
} */
/* Inputs */
.custom-form input,
.custom-form select {
    /* background: #2f3030; */
    border: 1px solid #222;
    /* color: #fff; */
    border-radius: 10px;
    padding: 10px;
    transition: 0.3s;
}

.custom-form input:focus,
.custom-form select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 10px #0d6efd55;
}

/* Labels */
.custom-form label {
    font-size: 15px;
    color: #aaa;
    margin-bottom: 4px;
}

/* ===== PRICE BAR ===== */
/* .price-bar {
    height: 10px;
    background: #222;
    border-radius: 10px;
    overflow: hidden;
} */
.price-box {
    background: #0d0d0d;
    border-radius: 12px;
    padding: 15px;
    border: 1px solid #222;
}
.price-card {
    /* background: #0a0a0a; */
    /* background: #2f3030; */
    border-radius: 16px;
    padding: 20px;
    border: 1px solid ;
}

.price-card h2 {
    font-size: 32px;
    font-weight: bold;
}
.col-md-6 {
    transition: 0.3s;
}

.col-md-6:hover {
    transform: translateY(-5px);
}
.divider {
    border-top: 1px solid #222;
    margin: 15px 0;
}
.btn {
    border-radius: 12px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-outline-info:hover {
    background: #0dcaf0;
    color: #000;
}

.btn-outline-warning:hover {
    background: #ffc107;
    color: #000;
}

.btn-success {
    background: linear-gradient(135deg, #00ff87, #00c9ff);
    border: none;
    color: #000;
    font-weight: 600;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,255,135,0.2);
}

.btn:hover {
    transform: translateY(-2px);
}

.price-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(to right, #0d6efd, #00d4ff);
}

/* MOBILE */
@media (max-width:768px){
    .process-line {
        flex-direction: column;
        gap: 20px;
    }
}
</style>

<!-- HERO -->
<section class="custom-hero text-center">
    <h1>🚀 Turn Your Idea Into Reality</h1>
    <p>Upload your design & get high-quality prints</p>
</section>

<!-- PROCESS -->
<section class="py-5 text-white position-relative" style="background:#000;">
    <div class="container text-center">

        <h2 class="fw-bold mb-5">⚙️ How It Works</h2>

        <div class="workflow">

            <div class="step">
                <div class="node">📤</div>
                <h6>Upload Design</h6>
                <p>STL / Image / Idea</p>
            </div>

            <div class="connector"></div>

            <div class="step">
                <div class="node">🧠</div>
                <h6>We Analyze</h6>
                <p>Size, material, cost</p>
            </div>

            <div class="connector"></div>

            <div class="step">
                <div class="node">🖨️</div>
                <h6>3D Printing</h6>
                <p>High precision build</p>
            </div>

            <div class="connector"></div>

            <div class="step">
                <div class="node">📦</div>
                <h6>Delivery</h6>
                <p>Safe packaging</p>
            </div>

        </div>

    </div>
</section>

<!-- SHOWCASE -->
<section class="py-5 text-white" style="background:#050505;">
    <div class="container text-center">

        <h2 class="fw-bold mb-5">🧊 3D Showcase</h2>

        <div class="showcase-grid">

            <div class="show-item">
                <img src="https://makerworld.bblmw.com/makerworld/model/US785629d640df37/design/2025-11-18_fc807149f6f17.webp">
                <div class="overlay">
                    <h6>Dragon Model</h6>
                    <p>High detail PLA</p>
                </div>
            </div>

            <div class="show-item">
                <img src="https://makerworld.bblmw.com/makerworld/model/US2bcdfcd556d945/design/2024-01-08_e7cb2c5edc4fa8.jpeg">
                <div class="overlay">
                    <h6>Prototype Part</h6>
                    <p>ABS Material</p>
                </div>
            </div>

            <div class="show-item">
                <img src="https://makerworld.bblmw.com/makerworld/model/USe1c9fcb2ca73e1/design/2024-08-13_e879dacdf6e89.jpg">
                <div class="overlay">
                    <h6>Mini Figure</h6>
                    <p>Resin Print</p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- PRICE ESTIMATOR -->
<div class="container mt-5 text-center">
    <h3>💰 Live Estimate</h3>

    <div class="price-bar mt-3 mb-2">
        <div id="priceFill" class="price-fill"></div>
    </div>

    <h2>₹<span id="priceDisplay">0</span></h2>
    <p>Time: <span id="timeDisplay">0</span> hrs</p>
</div>

<!-- FORM -->
<form action="{{ route('custom.order.store') }}" method="POST" enctype="multipart/form-data" class="custom-form mt-4">
@csrf

<div class="row g-5 align-items-start">

    <!-- ================= LEFT SIDE ================= -->
    <div class="col-md-6 preview-panel">
    <div class="glass-card">

        <h5 class="mb-3">📤 Upload & Preview</h5>
        <hr style="border-color:#222;">
        <!-- DRAG & DROP -->
        <div id="dropZone" class="drop-zone mb-3">
            <p>Drag & Drop STL / Image here or click to upload</p>
            <input type="file" id="fileInput" name="file" hidden>
        </div>

        <!-- FILE PREVIEW -->
        <div id="filePreview" class="text-center text-muted mb-3"></div>

        <!-- 3D VIEWER -->
         <div id="viewer" class="viewer-box mb-3"></div>
        <!-- <div id="viewer" style="height:350px; background:#000;" class="mb-3 rounded"></div> -->

        <!-- VIEW CONTROLS -->
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <button type="button" id="toggleGridBtn" class="btn btn-sm btn-outline-secondary">
                🧱 Grid ON
            </button>
            <!-- <button type="button" id="autoRotateBtn" class="btn btn-sm btn-outline-info">
                🔄 Auto Rotate
            </button> -->

            <button type="button" id="resetViewBtn" class="btn btn-sm btn-outline-warning">
                🧲 Reset View
            </button>

            <div class=" small d-flex align-items-center">
                📏 <span id="modelSize">-</span> 
            </div>
        </div>
        
    </div>
</div>

    <!-- ================= RIGHT SIDE ================= -->
    <div class="col-md-6">
        <div class="glass-card">
            
            <h5 class="mb-3">⚙️ Configure Print</h5>
            <hr style="border-color:#222;">

        <div class="row g-3">

            <!-- NOZZLE -->
            <div class="col-md-6">
                <label>Nozzle Size</label>
                <select id="nozzle" class="form-control">
                    <option value="1">0.2mm (High Detail)</option>
                    <option value="1.2">0.4mm (Standard)</option>
                    <option value="1.5">0.6mm (Fast)</option>
                </select>
            </div>

            <!-- MATERIAL -->
            <div class="col-md-6">
                <label>Material</label>
                <select id="material" class="form-control">
                    <option value="1">PLA</option>
                    <option value="1.3">ABS</option>
                    <option value="1.6">Resin</option>
                </select>
            </div>

            <!-- INFILL -->
            <div class="col-md-6">
                <label>Infill</label>
                <select id="infill" class="form-control">
                    <option value="1">20%</option>
                    <option value="1.3">50%</option>
                    <option value="1.6">80%</option>
                </select>
            </div>

            <!-- FINISH -->
            <div class="col-md-6">
                <label>Finish</label>
                <select id="finish" class="form-control">
                    <option value="0">Raw</option>
                    <option value="80">Sanded</option>
                    <option value="150">Painted</option>
                </select>
            </div>

            <!-- COLOR -->
            <div class="col-md-6">
                <label>Color</label>
                <input type="color" id="color" class="form-control form-control-color w-100">
            </div>

            <!-- QUANTITY -->
            <div class="col-md-6">
                <label>Quantity</label>
                <input type="number" id="quantity" value="1" class="form-control">
            </div>

        </div>

        <!-- PRICE -->
        <div class="price-card text-center mt-4">
            <!-- <h2>₹<span id="priceDisplay">0</span></h2> -->
            <!-- <p>Estimated time: <span id="timeDisplay">0</span> hrs</p> -->

            <div class="price-bar mt-3">
                <!-- <div id="priceFill" class="price-fill"></div> -->
            </div>
        </div>

        <!-- PROGRESS BAR -->
        <div class="price-bar mt-2">
            <div id="priceFill" class="price-fill"></div>
        </div>

        <!-- SUBMIT -->
        <button id="whatsappBtn" class="btn btn-success w-100 mt-4">
            Send on WhatsApp
        </button>

    </div>
</div>

</div>

</form>

<script>
document.addEventListener("DOMContentLoaded", function () {
    
    /* =========================================================
       GLOBALS
    ========================================================= */
    let scene, camera, renderer, controls, currentMesh, gridHelper;
    // let gridVisible = true;
    // let autoRotate = false;
    window.modelSize = 50;

    const fileInput = document.getElementById("fileInput");
    const dropZone = document.getElementById("dropZone");
    const preview = document.getElementById("filePreview");
    const viewer = document.getElementById("viewer");


     /* =========================================================
       PRICE CALCULATION (FIXED)
    ========================================================= */
    function calculatePrice() {

        const COST_PER_GRAM = 4;
        const COST_PER_HOUR = 2;

        let nozzle = parseFloat(document.getElementById("nozzle").value);
        let material = parseFloat(document.getElementById("material").value);
        let infill = parseFloat(document.getElementById("infill").value);
        let finish = parseFloat(document.getElementById("finish").value);
        let qty = parseInt(document.getElementById("quantity").value) || 1;

        let size = window.modelSize || 50;

        // 🔥 Weight estimation
        let weight = (size * size * 0.002) * infill;

        // ⏱ Print time
        let printTime = (size * 0.1) / nozzle;

        // 💰 Costs
        let materialCost = weight * COST_PER_GRAM;
        let timeCost = printTime * COST_PER_HOUR;

        let materialCostAdjusted = materialCost + material;

        let colorCost = document.getElementById("color").value ? 20 : 0;

        let total =
            materialCostAdjusted +
            timeCost +
            finish +
            colorCost;

        let final = Math.round(total * qty);

        // UI update
        document.getElementById("priceDisplay").innerText = final;
        document.getElementById("timeDisplay").innerText = printTime.toFixed(1);

        let percent = Math.min(final / 5000 * 100, 100);
        document.getElementById("priceFill").style.width = percent + "%";
    }

    // ✅ FIX: attach listeners (IMPORTANT)
    document.querySelectorAll("#nozzle,#material,#infill,#finish,#quantity,#color")
        .forEach(el => el.addEventListener("input", calculatePrice));

    /* =========================================================
       FILE PREVIEW
    ========================================================= */
    function showPreview(file) {

        preview.innerHTML = "";
        if (!file) return;

        let name = document.createElement("p");
        name.innerText = "📁 " + file.name;
        preview.appendChild(name);

        if (file.type.startsWith("image/")) {
            let img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = "150px";
            img.style.borderRadius = "10px";
            preview.appendChild(img);
        }

        if (file.name.toLowerCase().endsWith(".stl")) {
            let msg = document.createElement("p");
            msg.innerText = "🧊 STL loaded in viewer";
            preview.appendChild(msg);
        }
    }

    /* =========================================================
       DRAG & DROP (FINAL FIX 🔥)
    ========================================================= */

    // Prevent browser opening file
    ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Highlight
    dropZone.addEventListener("dragenter", () => {
        dropZone.classList.add("dragging");
    });

    dropZone.addEventListener("dragover", () => {
        dropZone.classList.add("dragging");
    });

    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("dragging");
    });

    // DROP ✅
    dropZone.addEventListener("drop", (e) => {
        dropZone.classList.remove("dragging");

        const file = e.dataTransfer.files[0];
        if (!file) return;

        showPreview(file);
        handleFile(file);
    });

    // Click upload
    dropZone.addEventListener("click", () => fileInput.click());

    // Manual file select
    fileInput.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        showPreview(file);
        handleFile(file);
    });

    /* =========================================================
       3D VIEWER
    ========================================================= */
    function initViewer() {

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera(
            60,
            viewer.clientWidth / viewer.clientHeight,
            0.1,
            2000
        );

        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(viewer.clientWidth, viewer.clientHeight);
        renderer.setClearColor(0x0a0a0a);

        viewer.innerHTML = "";
        viewer.appendChild(renderer.domElement);

        // camera.position.set(160, 80, 120);

        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.enableZoom = true;
        controls.dampingFactor = 0.05;
        controls.enablePan = false;
        controls.target.set(0, 0, 0);
        
            /* ===== LIGHTING ===== */
        scene.add(new THREE.AmbientLight(0xffffff, 0.6));

        let light = new THREE.DirectionalLight(0xffffff, 1);
        light.position.set(100, 100, 100);
        scene.add(light);

        /* ===== GRID ===== */
        gridHelper = new THREE.GridHelper(200, 20, 0x444444, 0x222222);
        gridHelper.position.set(0, 0, 0);
        scene.add(gridHelper);
        
        /* ===== INITIAL CAMERA ===== */
        camera.position.set(150, 100, 150);
        camera.lookAt(0, 0, 0);
    }

    /* =========================================================
       STL LOADER
    ========================================================= */
    function handleFile(file) {

        if (!file.name.toLowerCase().endsWith(".stl")) return;

        const loader = new THREE.STLLoader();
        const reader = new FileReader();

        reader.onload = function (e) {
            try {

                const geometry = loader.parse(e.target.result);
                geometry.computeBoundingBox();

                let sizeVec = new THREE.Vector3();
                geometry.boundingBox.getSize(sizeVec);

                    // ✅ 👉 PASTE HERE
                    let x = sizeVec.x.toFixed(1);
                    let y = sizeVec.y.toFixed(1);
                    let z = sizeVec.z.toFixed(1);

                    document.getElementById("modelSize").innerText = `${x} × ${y} × ${z}`;

                    // Approx volume (basic estimation)
                    let volume = sizeVec.x * sizeVec.y * sizeVec.z;

                    // PLA density approx
                    let density = 0.00124;

                    // infill factor (you can later link with dropdown)
                    let infillFactor = 0.2;

                    // estimated weight
                    let weight = volume * density * infillFactor;

                    document.getElementById("modelSize").innerText += ` | ⚖️ ${weight.toFixed(1)}g`;

                window.modelSize = Math.max(sizeVec.x, sizeVec.y, sizeVec.z);

                /* ===== MATERIAL ===== */
                const material = new THREE.MeshPhysicalMaterial({
                    color: 0x00d4ff,
                    metalness: 0.2,
                    roughness: 0.4,
                    clearcoat: 0.3
                });

                let mesh = new THREE.Mesh(geometry, material);

                if (currentMesh) scene.remove(currentMesh);
                scene.add(mesh);
                currentMesh = mesh;

                /* ===== TRANSFORM (CRITICAL ORDER 🔥) ===== */

                // 1. Fix orientation
                
                mesh.rotation.x = -Math.PI / 2;

                // 2. Scale
                let scale = 80 / window.modelSize;
                mesh.scale.set(scale, scale, scale);

                // 3. Center to origin
                const box = new THREE.Box3().setFromObject(mesh);
                const center = new THREE.Vector3();
                box.getCenter(center);
                mesh.position.sub(center);

                // 4. Drop to grid
                const newBox = new THREE.Box3().setFromObject(mesh);
                mesh.position.y -= newBox.min.y;

                // 5. Camera fit
                const size = newBox.getSize(new THREE.Vector3()).length();
                const distance = size * 1.5;

                camera.position.set(distance, distance, distance);
                camera.lookAt(0, 0, 0);

                controls.target.set(0, 0, 0);
                controls.minDistance = distance * 0.5;
                controls.maxDistance = distance * 3;
                controls.update();

            } catch (err) {
                console.error(err);
                alert("❌ STL load failed");
            }
        };

        reader.readAsArrayBuffer(file);
    }



    /* =========================================================
       ANIMATION
    ========================================================= */
    function animate() {
        requestAnimationFrame(animate);

        if (controls) controls.update();


        renderer.render(scene, camera);
    }

    /* =========================================================
       BUTTONS
    ========================================================= */
    document.getElementById("toggleGridBtn").addEventListener("click", function () {
        if (!gridHelper) return;
        gridHelper.visible = !gridHelper.visible;
        this.innerText = gridHelper.visible ? "🧱 Grid ON" : "🚫 Grid OFF";
    });
    // Auto rotate
    // document.getElementById("autoRotateBtn").addEventListener("click", function () {
    //     autoRotate = !autoRotate;
    //     this.classList.toggle("btn-success");
    // });

    // Reset view
    document.getElementById("resetViewBtn").addEventListener("click", function () {
        // if (!currentMesh) return;

        if (!currentMesh) return;
            const box = new THREE.Box3().setFromObject(currentMesh);
            const center = new THREE.Vector3();
            box.getCenter(center);
            controls.target.copy(center);

            const size = box.getSize(new THREE.Vector3()).length();
            const distance = size * 1.5;

            camera.position.set(
                center.x + distance,
                center.y + distance,
                center.z + distance
            );

            controls.update();
    });

    // Color change
    document.getElementById("color").addEventListener("input", function () {
        if (!currentMesh) return;
        currentMesh.material.color.set(this.value);
    });

    /* =========================================================
       INIT
    ========================================================= */
    initViewer();
    animate();
    calculatePrice();

    window.addEventListener("resize", () => {
        camera.aspect = viewer.clientWidth / viewer.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(viewer.clientWidth, viewer.clientHeight);
    });

    /* =========================================================
       WHATSAPP
    ========================================================= */
    document.getElementById("whatsappBtn").addEventListener("click", function (e) {
        e.preventDefault();

        let price = document.getElementById("priceDisplay").innerText;
        let qty = document.getElementById("quantity").value;

        let msg = `Hello, I want a 3D print\nPrice: ₹${price}\nQuantity: ${qty}`;

        window.open(
            "https://wa.me/91YOURNUMBER?text=" + encodeURIComponent(msg),
            "_blank"
        );
    });

});

</script>

@endsection