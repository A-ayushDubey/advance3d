@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/loaders/STLLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/controls/OrbitControls.js"></script>

<style>

/* =====================================================
   AD-VANCE 3D — CUSTOM PRINT ORDER
   modern / minimal restyle
   Tokens reused from layout.blade.php; fallbacks included.
===================================================== */

.custom-page{ --r: 4px; }

/* ===== HERO ===== */

.custom-hero{
    background: var(--bg, #FAFAF8);
    border-bottom: 1px solid var(--hairline, #E8E6E0);
    position: relative;
    overflow: hidden;
    padding: 90px 20px 70px;
    text-align: center;
}
body.dark-mode .custom-hero{
    background: var(--bg-dark, #0F0F0F);
    border-bottom-color: var(--hairline-dark, #2C2C29);
}

.custom-hero .eyebrow{
    font-family: var(--font-mono, monospace);
    font-size: 12.5px;
    color: var(--accent, #FF5A1F);
    letter-spacing: 0.04em;
    margin-bottom: 16px;
}

.custom-hero h1{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: clamp(28px, 4.5vw, 42px);
    letter-spacing: -0.02em;
    color: var(--ink, #1A1A1A);
    margin-bottom: 12px;
}
body.dark-mode .custom-hero h1{ color: var(--ink-dark, #F2F1ED); }

.custom-hero p{
    color: var(--ink-soft, #6B6B65);
    font-size: 15px;
}
body.dark-mode .custom-hero p{ color: var(--ink-soft-dark, #9B9A92); }

/* ===== PROCESS ===== */

.process-section{
    padding: 70px 0;
    background: var(--bg-raised, #fff);
    border-bottom: 1px solid var(--hairline, #E8E6E0);
}
body.dark-mode .process-section{
    background: var(--bg-raised-dark, #1A1A19);
    border-bottom-color: var(--hairline-dark, #2C2C29);
}

.process-section h2{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .process-section h2{ color: var(--ink-dark, #F2F1ED); }

.workflow{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-top: 40px;
}

.step{
    text-align: center;
    width: 22%;
}

.step h6{
    font-weight: 600;
    font-size: 14.5px;
    color: var(--ink, #1A1A1A);
    margin: 14px 0 4px;
}
body.dark-mode .step h6{ color: var(--ink-dark, #F2F1ED); }

.step p{
    font-size: 12.5px;
    color: var(--ink-soft, #6B6B65);
    margin: 0;
}
body.dark-mode .step p{ color: var(--ink-soft-dark, #9B9A92); }

.node{
    width: 60px;
    height: 60px;
    background: var(--bg, #FAFAF8);
    border: 1.5px solid var(--ink, #1A1A1A);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--accent, #FF5A1F);
    margin: auto;
    transition: 0.25s ease;
}
body.dark-mode .node{
    background: var(--bg-dark, #0F0F0F);
    border-color: var(--ink-dark, #F2F1ED);
}

.step:hover .node{
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
    transform: scale(1.08);
}
body.dark-mode .step:hover .node{
    background: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

.connector{
    height: 1px;
    flex: 1;
    background: var(--hairline, #E8E6E0);
    margin: 0 10px;
    align-self: center;
    margin-top: -30px;
}
body.dark-mode .connector{ background: var(--hairline-dark, #2C2C29); }

@media (max-width:768px){
    .workflow{ flex-direction: column; gap: 25px; }
    .connector{ width: 1px; height: 30px; margin-top: 0; }
    .step{ width: 100%; }
}

/* ===== SHOWCASE ===== */

.showcase-section{
    padding: 70px 0;
}

.showcase-section h2{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .showcase-section h2{ color: var(--ink-dark, #F2F1ED); }

.showcase-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap: 14px;
    margin-top: 40px;
}

.show-item{
    position: relative;
    overflow: hidden;
    border-radius: 6px;
    border: 1px solid var(--hairline, #E8E6E0);
    aspect-ratio: 1/1;
}
body.dark-mode .show-item{ border-color: var(--hairline-dark, #2C2C29); }

.show-item img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.4s;
}

.overlay{
    position: absolute;
    bottom: 0;
    width: 100%;
    background: linear-gradient(to top, rgba(15,15,15,0.88), transparent);
    padding: 16px;
    opacity: 0;
    transition: 0.3s;
}

.overlay h6{
    color: #fff;
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 14px;
    margin: 0 0 2px;
}
.overlay p{
    color: #D8D6CF;
    font-size: 12px;
    margin: 0;
}

.show-item:hover img{ transform: scale(1.08); }
.show-item:hover .overlay{ opacity: 1; }

/* ===== PRICE ESTIMATOR (TOP) ===== */

.estimate-block{
    text-align: center;
    padding: 40px 0 10px;
}

.estimate-block h3{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 16px;
    color: var(--ink, #1A1A1A);
    margin-bottom: 16px;
}
body.dark-mode .estimate-block h3{ color: var(--ink-dark, #F2F1ED); }

.price-bar{
    height: 6px;
    background: var(--hairline, #E8E6E0);
    border-radius: 10px;
    overflow: hidden;
    max-width: 360px;
    margin: 0 auto 16px;
}
body.dark-mode .price-bar{ background: var(--hairline-dark, #2C2C29); }

.price-fill{
    height: 100%;
    width: 0%;
    background: var(--accent, #FF5A1F);
    transition: width 0.3s ease;
}

.estimate-block h2{
    font-family: var(--font-mono, monospace);
    font-weight: 500;
    font-size: 2.2rem;
    color: var(--ink, #1A1A1A);
    margin: 0;
}
body.dark-mode .estimate-block h2{ color: var(--ink-dark, #F2F1ED); }

.estimate-block p{
    color: var(--ink-soft, #6B6B65);
    font-size: 13.5px;
}
body.dark-mode .estimate-block p{ color: var(--ink-soft-dark, #9B9A92); }

.estimate-waiting{
    color: var(--ink-soft, #6B6B65);
    font-size: 13.5px;
    font-style: italic;
}
body.dark-mode .estimate-waiting{ color: var(--ink-soft-dark, #9B9A92); }

/* ===== FORM ===== */

.custom-form{
    max-width: 1100px;
    margin: 30px auto 60px;
    padding: 30px;
    border-radius: 8px;
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
}
body.dark-mode .custom-form{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.custom-form h5{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 15px;
    color: var(--ink, #1A1A1A);
    display: flex;
    align-items: center;
    gap: 8px;
}
body.dark-mode .custom-form h5{ color: var(--ink-dark, #F2F1ED); }

.custom-form hr{
    border-color: var(--hairline, #E8E6E0);
    opacity: 1;
}
body.dark-mode .custom-form hr{ border-color: var(--hairline-dark, #2C2C29); }

/* DROP ZONE */

.drop-zone{
    border: 1.5px dashed var(--hairline, #E8E6E0);
    padding: 36px 20px;
    text-align: center;
    border-radius: var(--r);
    cursor: pointer;
    color: var(--ink-soft, #6B6B65);
    font-size: 13.5px;
    transition: 0.2s ease;
}
.drop-zone i{
    font-size: 26px;
    color: var(--accent, #FF5A1F);
    display: block;
    margin-bottom: 10px;
}
.drop-zone:hover{
    border-color: var(--accent, #FF5A1F);
    background: var(--accent-50, #FFF1EA);
}
.drop-zone.dragging{
    border-color: var(--accent, #FF5A1F);
    background: var(--accent-50, #FFF1EA);
    transform: scale(1.01);
}
body.dark-mode .drop-zone{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-soft-dark, #9B9A92);
}
body.dark-mode .drop-zone:hover,
body.dark-mode .drop-zone.dragging{
    background: var(--accent-50-dark, #2A1A12);
}

#filePreview{
    font-size: 13px;
    color: var(--ink-soft, #6B6B65);
}
body.dark-mode #filePreview{ color: var(--ink-soft-dark, #9B9A92); }
#filePreview img{
    border-radius: var(--r);
    border: 1px solid var(--hairline, #E8E6E0);
}
body.dark-mode #filePreview img{ border-color: var(--hairline-dark, #2C2C29); }

/* VIEWER */

.preview-panel{ top: 100px; }

.glass-card{
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 6px;
    padding: 18px;
}
body.dark-mode .glass-card{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.viewer-box{
    height: 380px;
    border-radius: var(--r);
    overflow: hidden;
    background: var(--accent-50, #FFF1EA);
    border: 1px solid var(--hairline, #E8E6E0);
    position: relative;
}
body.dark-mode .viewer-box{
    background: #050505;
    border-color: var(--hairline-dark, #2C2C29);
}

#viewer{
    width: 100%;
    height: 100%;
}

.viewer-empty{
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: var(--ink-soft, #6B6B65);
    font-size: 13px;
    pointer-events: none;
}
.viewer-empty i{
    font-size: 28px;
    color: var(--accent, #FF5A1F);
    opacity: 0.6;
}
body.dark-mode .viewer-empty{ color: var(--ink-soft-dark, #9B9A92); }

/* VIEW CONTROLS */

.viewer-controls{
    opacity: 0.4;
    pointer-events: none;
    transition: opacity 0.2s ease;
}
.viewer-controls.active{
    opacity: 1;
    pointer-events: auto;
}

.btn-viewer{
    border: 1px solid var(--hairline, #E8E6E0);
    background: transparent;
    color: var(--ink, #1A1A1A);
    font-size: 12.5px;
    font-weight: 600;
    padding: 7px 13px;
    border-radius: var(--r);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: 0.2s ease;
}
.btn-viewer:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}
body.dark-mode .btn-viewer{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

.model-size-tag{
    font-family: var(--font-mono, monospace);
    font-size: 12px;
    color: var(--ink-soft, #6B6B65);
    display: flex;
    align-items: center;
    gap: 6px;
}
body.dark-mode .model-size-tag{ color: var(--ink-soft-dark, #9B9A92); }

/* FORM FIELDS */

.custom-form label{
    font-size: 12.5px;
    font-weight: 600;
    color: var(--ink, #1A1A1A);
    margin-bottom: 6px;
    display: block;
}
body.dark-mode .custom-form label{ color: var(--ink-dark, #F2F1ED); }

.custom-form input,
.custom-form select{
    border: 1px solid var(--hairline, #E8E6E0);
    color: var(--ink, #1A1A1A);
    background: var(--bg-raised, #fff);
    border-radius: var(--r);
    padding: 10px 12px;
    font-size: 13.5px;
    width: 100%;
    transition: 0.2s ease;
}

.custom-form input:focus,
.custom-form select:focus{
    border-color: var(--accent, #FF5A1F);
    box-shadow: 0 0 0 3px var(--accent-50, #FFF1EA);
    outline: none;
}
body.dark-mode .custom-form input,
body.dark-mode .custom-form select{
    background: var(--bg-dark, #0F0F0F);
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

/* PRICE CARD */

.price-card{
    background: var(--accent-50, #FFF1EA);
    border-radius: 6px;
    padding: 20px;
    border: 1px solid var(--hairline, #E8E6E0);
}
body.dark-mode .price-card{
    background: var(--accent-50-dark, #2A1A12);
    border-color: var(--hairline-dark, #2C2C29);
}

.divider{
    border-top: 1px solid var(--hairline, #E8E6E0);
    margin: 15px 0;
}
body.dark-mode .divider{ border-top-color: var(--hairline-dark, #2C2C29); }

/* BUTTONS */

.btn-whatsapp-order{
    border-radius: var(--r);
    font-weight: 600;
    font-size: 14.5px;
    background: transparent;
    border: 1px solid #1E7E34;
    color: #1E7E34;
    padding: 13px 20px;
    width: 100%;
    transition: 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-whatsapp-order:hover{
    background: #1E7E34;
    color: #fff;
}
body.dark-mode .btn-whatsapp-order{
    border-color: #7FD99A;
    color: #7FD99A;
}
body.dark-mode .btn-whatsapp-order:hover{
    background: #1E7E34;
    color: #fff;
}

.col-md-6{ transition: 0.2s ease; }

</style>

<div class="custom-page">

<!-- HERO -->
<section class="custom-hero">
    <div class="eyebrow">Custom 3D printing</div>
    <h1>Turn your idea into reality</h1>
    <p>Upload your design &amp; get an instant price estimate</p>
</section>

<!-- PROCESS -->
<section class="process-section">
    <div class="container text-center">

        <h2 class="fw-bold">How it works</h2>

        <div class="workflow">

            <div class="step">
                <div class="node"><i class="bi bi-cloud-upload"></i></div>
                <h6>Upload Design</h6>
                <p>STL / Image / Idea</p>
            </div>

            <div class="connector"></div>

            <div class="step">
                <div class="node"><i class="bi bi-cpu"></i></div>
                <h6>We Analyze</h6>
                <p>Size, material, cost</p>
            </div>

            <div class="connector"></div>

            <div class="step">
                <div class="node"><i class="bi bi-printer"></i></div>
                <h6>3D Printing</h6>
                <p>High precision build</p>
            </div>

            <div class="connector"></div>

            <div class="step">
                <div class="node"><i class="bi bi-box-seam"></i></div>
                <h6>Delivery</h6>
                <p>Safe packaging</p>
            </div>

        </div>

    </div>
</section>

<!-- SHOWCASE -->
<section class="showcase-section">
    <div class="container text-center">

        <h2 class="fw-bold">3D Showcase</h2>

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
<div class="container estimate-block">
    <h3>Live Estimate</h3>

    <div class="price-bar">
        <div id="priceFill" class="price-fill"></div>
    </div>

    <div id="estimateReady" style="display:none;">
        <h2>₹<span id="priceDisplay">0</span></h2>
        <p>Estimated print time: <span id="timeDisplay">0</span> hrs · <span id="weightDisplay">0</span>g</p>
    </div>

    <p id="estimateWaiting" class="estimate-waiting">Upload an STL file below to see a live price estimate based on the model's actual size and volume.</p>
</div>

<!-- FORM -->
<form action="{{ route('custom.order.store') }}" method="POST" enctype="multipart/form-data" class="custom-form">
@csrf

<div class="row g-5 align-items-start">

    <!-- ================= LEFT SIDE ================= -->
    <div class="col-md-6 preview-panel">
    <div class="glass-card">

        <h5 class="mb-3"><i class="bi bi-cloud-upload"></i> Upload &amp; Preview</h5>
        <hr>

        <!-- DRAG & DROP -->
        <div id="dropZone" class="drop-zone mb-3">
            <i class="bi bi-cloud-arrow-up"></i>
            <p class="mb-0">Drag &amp; drop an STL file here, or click to upload</p>
            <input type="file" id="fileInput" name="file" hidden accept=".stl">
        </div>

        <!-- FILE PREVIEW -->
        <div id="filePreview" class="text-center mb-3"></div>

        <!-- 3D VIEWER -->
        <div class="viewer-box mb-3">
            <div id="viewer"></div>
            <div id="viewerEmpty" class="viewer-empty">
                <i class="bi bi-box"></i>
                <span>No model loaded yet</span>
            </div>
        </div>

        <!-- VIEW CONTROLS -->
        <div id="viewerControls" class="viewer-controls d-flex flex-wrap gap-2 justify-content-center align-items-center">
            <button type="button" id="toggleGridBtn" class="btn-viewer">
                <i class="bi bi-grid-3x3"></i> Grid On
            </button>

            <button type="button" id="resetViewBtn" class="btn-viewer">
                <i class="bi bi-arrow-counterclockwise"></i> Reset View
            </button>

            <div class="model-size-tag">
                <i class="bi bi-rulers"></i> <span id="modelSize">—</span>
            </div>
        </div>

    </div>
    </div>

    <!-- ================= RIGHT SIDE ================= -->
    <div class="col-md-6">
        <div class="glass-card">

            <h5 class="mb-3"><i class="bi bi-sliders"></i> Configure Print</h5>
            <hr>

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
                    <option value="0.2">20%</option>
                    <option value="0.5">50%</option>
                    <option value="0.8">80%</option>
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
                <input type="number" id="quantity" value="1" min="1" class="form-control">
            </div>

        </div>

        <!-- PRICE CARD -->
        <div class="price-card text-center mt-4">
            <div id="priceCardReady" style="display:none;">
                <h2 class="mb-1">₹<span id="priceDisplayCard">0</span></h2>
                <p class="mb-0">Estimated time: <span id="timeDisplayCard">0</span> hrs</p>
            </div>
            <p id="priceCardWaiting" class="estimate-waiting mb-0">Upload a model to calculate price</p>
        </div>

        <div class="divider"></div>

        <!-- SUBMIT -->
        <button id="whatsappBtn" type="button" class="btn-whatsapp-order">
            <i class="bi bi-whatsapp"></i> Send on WhatsApp
        </button>

    </div>
    </div>

</div>

</form>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* =========================================================
       GLOBALS
    ========================================================= */
    let scene, camera, renderer, controls, currentMesh, gridHelper;

    // Real geometry-derived values — populated only once a model
    // is actually loaded. Pricing now reads from these instead of
    // a guessed single-dimension estimate.
    window.modelLoaded = false;
    window.modelSize = 0;       // largest bounding-box dimension
    window.modelVolume = 0;     // real bounding-box volume (mm^3 approx)

    const fileInput = document.getElementById("fileInput");
    const dropZone = document.getElementById("dropZone");
    const preview = document.getElementById("filePreview");
    const viewer = document.getElementById("viewer");
    const viewerEmpty = document.getElementById("viewerEmpty");
    const viewerControls = document.getElementById("viewerControls");

    /* =========================================================
       PRICE CALCULATION — now driven by the real STL volume
       (window.modelVolume), not a guessed single-dimension value.
       Falls back to doing nothing until a model is loaded.
    ========================================================= */
    function calculatePrice() {

        if (!window.modelLoaded) return;

        const COST_PER_GRAM = 4;
        const COST_PER_HOUR = 2;
        const PLA_DENSITY = 0.00124; // g/mm^3, approx

        let nozzle = parseFloat(document.getElementById("nozzle").value);
        let material = parseFloat(document.getElementById("material").value);
        let infill = parseFloat(document.getElementById("infill").value); // now 0.2 / 0.5 / 0.8
        let finish = parseFloat(document.getElementById("finish").value);
        let qty = parseInt(document.getElementById("quantity").value) || 1;

        let size = window.modelSize || 50;
        let volume = window.modelVolume || (size * size * size * 0.15); // fallback if volume unavailable

        // Real weight estimate from actual model volume
        let weight = volume * PLA_DENSITY * infill;

        // Print time — still tied to largest dimension, which is a
        // reasonable proxy for time without a full slicer
        let printTime = (size * 0.1) / nozzle;

        let materialCost = weight * COST_PER_GRAM;
        let timeCost = printTime * COST_PER_HOUR;
        let materialCostAdjusted = materialCost + material;
        let colorCost = document.getElementById("color").value ? 20 : 0;

        let total = materialCostAdjusted + timeCost + finish + colorCost;
        let final = Math.round(total * qty);

        // UI update — both the top estimator and the price card
        // (previously two duplicate #priceFill IDs existed; now
        // there is exactly one progress bar and two text targets)
        document.getElementById("priceDisplay").innerText = final;
        document.getElementById("timeDisplay").innerText = printTime.toFixed(1);
        document.getElementById("weightDisplay").innerText = weight.toFixed(1);
        document.getElementById("priceDisplayCard").innerText = final;
        document.getElementById("timeDisplayCard").innerText = printTime.toFixed(1);

        let percent = Math.min(final / 5000 * 100, 100);
        document.getElementById("priceFill").style.width = percent + "%";
    }

    document.querySelectorAll("#nozzle,#material,#infill,#finish,#quantity,#color")
        .forEach(el => el.addEventListener("input", calculatePrice));

    /* =========================================================
       SHOW ESTIMATOR / VIEWER CONTROLS ONCE A MODEL IS LOADED
    ========================================================= */
    function activateEstimator() {
        document.getElementById("estimateWaiting").style.display = "none";
        document.getElementById("estimateReady").style.display = "block";
        document.getElementById("priceCardWaiting").style.display = "none";
        document.getElementById("priceCardReady").style.display = "block";
        viewerControls.classList.add("active");
        viewerEmpty.style.display = "none";
    }

    /* =========================================================
       FILE PREVIEW
    ========================================================= */
    function showPreview(file) {

        preview.innerHTML = "";
        if (!file) return;

        let name = document.createElement("p");
        name.innerHTML = `<i class="bi bi-file-earmark"></i> ${file.name}`;
        preview.appendChild(name);

        if (file.type.startsWith("image/")) {
            let img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = "150px";
            preview.appendChild(img);
        }

        if (file.name.toLowerCase().endsWith(".stl")) {
            let msg = document.createElement("p");
            msg.innerHTML = '<i class="bi bi-box"></i> STL loaded in viewer';
            preview.appendChild(msg);
        }
    }

    /* =========================================================
       DRAG & DROP
    ========================================================= */

    ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    dropZone.addEventListener("dragenter", () => dropZone.classList.add("dragging"));
    dropZone.addEventListener("dragover", () => dropZone.classList.add("dragging"));
    dropZone.addEventListener("dragleave", () => dropZone.classList.remove("dragging"));

    dropZone.addEventListener("drop", (e) => {
        dropZone.classList.remove("dragging");

        const file = e.dataTransfer.files[0];
        if (!file) return;

        showPreview(file);
        handleFile(file);
    });

    dropZone.addEventListener("click", () => fileInput.click());

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

        renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(viewer.clientWidth, viewer.clientHeight);
        renderer.setClearColor(0x000000, 0);

        viewer.innerHTML = "";
        viewer.appendChild(renderer.domElement);

        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.enableZoom = true;
        controls.dampingFactor = 0.05;
        controls.enablePan = false;
        controls.target.set(0, 0, 0);

        scene.add(new THREE.AmbientLight(0xffffff, 0.7));

        let light = new THREE.DirectionalLight(0xffffff, 1);
        light.position.set(100, 100, 100);
        scene.add(light);

        gridHelper = new THREE.GridHelper(200, 20, 0xcccccc, 0xe0e0e0);
        gridHelper.position.set(0, 0, 0);
        scene.add(gridHelper);

        camera.position.set(150, 100, 150);
        camera.lookAt(0, 0, 0);
    }

    /* =========================================================
       STL LOADER — now also computes and stores real volume
       for accurate pricing (window.modelVolume)
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

                let x = sizeVec.x.toFixed(1);
                let y = sizeVec.y.toFixed(1);
                let z = sizeVec.z.toFixed(1);

                document.getElementById("modelSize").innerText = `${x} × ${y} × ${z} mm`;

                // Real bounding-box volume — this is what pricing
                // now uses, instead of a guessed single-dimension value
                let volume = sizeVec.x * sizeVec.y * sizeVec.z;

                window.modelSize = Math.max(sizeVec.x, sizeVec.y, sizeVec.z);
                window.modelVolume = volume;
                window.modelLoaded = true;

                /* ===== MATERIAL ===== */
                const material = new THREE.MeshPhysicalMaterial({
                    color: 0xff5a1f,
                    metalness: 0.15,
                    roughness: 0.45,
                    clearcoat: 0.25
                });

                let mesh = new THREE.Mesh(geometry, material);

                if (currentMesh) scene.remove(currentMesh);
                scene.add(mesh);
                currentMesh = mesh;

                /* ===== TRANSFORM ===== */
                mesh.rotation.x = -Math.PI / 2;

                let scale = 80 / window.modelSize;
                mesh.scale.set(scale, scale, scale);

                const box = new THREE.Box3().setFromObject(mesh);
                const center = new THREE.Vector3();
                box.getCenter(center);
                mesh.position.sub(center);

                const newBox = new THREE.Box3().setFromObject(mesh);
                mesh.position.y -= newBox.min.y;

                const sizeForCam = newBox.getSize(new THREE.Vector3()).length();
                const distance = sizeForCam * 1.5;

                camera.position.set(distance, distance, distance);
                camera.lookAt(0, 0, 0);

                controls.target.set(0, 0, 0);
                controls.minDistance = distance * 0.5;
                controls.maxDistance = distance * 3;
                controls.update();

                activateEstimator();
                calculatePrice();

            } catch (err) {
                console.error(err);
                alert("STL load failed — please check the file and try again.");
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
        if (renderer) renderer.render(scene, camera);
    }

    /* =========================================================
       BUTTONS
    ========================================================= */
    document.getElementById("toggleGridBtn").addEventListener("click", function () {
        if (!gridHelper) return;
        gridHelper.visible = !gridHelper.visible;
        this.innerHTML = gridHelper.visible
            ? '<i class="bi bi-grid-3x3"></i> Grid On'
            : '<i class="bi bi-grid-3x3"></i> Grid Off';
    });

    document.getElementById("resetViewBtn").addEventListener("click", function () {
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

    document.getElementById("color").addEventListener("input", function () {
        if (!currentMesh) return;
        currentMesh.material.color.set(this.value);
    });

    /* =========================================================
       INIT
    ========================================================= */
    initViewer();
    animate();
    // NOTE: calculatePrice() no longer runs at page load — it now
    // only runs once a real model is loaded (see handleFile above
    // and activateEstimator), so the page no longer shows a price
    // for a phantom model before anything is uploaded.

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

        if (!window.modelLoaded) {
            alert("Please upload an STL file first so we can give you an accurate quote.");
            return;
        }

        let price = document.getElementById("priceDisplay").innerText;
        let qty = document.getElementById("quantity").value;
        let size = document.getElementById("modelSize").innerText;

        let msg = `Hello, I want a custom 3D print\nModel size: ${size}\nPrice: ₹${price}\nQuantity: ${qty}`;

        window.open(
            "https://wa.me/918827502969?text=" + encodeURIComponent(msg),
            "_blank"
        );
    });

});
</script>

@endsection