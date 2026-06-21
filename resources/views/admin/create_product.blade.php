@extends('layouts.app')

@section('content')

<div class="container py-5 admin-panel">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <span class="admin-mark"></span>
        <div>
            <h2 class="fw-bold mb-0 admin-title">Add Multiple Products</h2>
            <small class="admin-subtitle">Bulk upload — fill out one or more product blocks below</small>
        </div>
    </div>
</div>

{{-- SUCCESS / ERROR --}}
@if(session('success'))
<div class="admin-alert success">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="admin-alert error">
    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="admin-alert error">
    @foreach($errors->all() as $error)
        <div><i class="bi bi-exclamation-circle"></i> {{ $error }}</div>
    @endforeach
</div>
@endif


<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="bulkForm">
@csrf

<div id="productWrapper">

    <!-- ================= PRODUCT BLOCK ================= -->
    <div class="product-box" data-index="0">

        <div class="product-box-head">
            <span class="product-box-tag">Product 1</span>
        </div>

        <div class="product-box-body">

            <div class="field-row">
                <input type="text" name="products[0][name]" class="form-control" placeholder="Product Name" required>
                <input type="number" name="products[0][price]" class="form-control" placeholder="Price (₹)" required>
            </div>

            <div class="field-row">
                <input type="text" name="products[0][category]" class="form-control" placeholder="Category" required>
                <input type="number" name="products[0][stock]" class="form-control" placeholder="Stock" required>
            </div>

            <textarea name="products[0][description]" class="form-control" placeholder="Description" rows="3"></textarea>

            <!-- IMAGE INPUT -->
            <label class="image-drop">
                <i class="bi bi-cloud-upload"></i>
                <span>Click to select images</span>
                <input type="file" class="image-input" multiple accept="image/*" onchange="handleFiles(event, 0)">
            </label>

            <!-- PREVIEW -->
            <div class="preview-container" id="preview-0"></div>

        </div>

    </div>

</div>

<!-- ADD PRODUCT -->
<button type="button" class="btn-admin-secondary mb-3" onclick="addProduct()">
    <i class="bi bi-plus-lg"></i> Add Another Product
</button>

<!-- SUBMIT -->
<button class="btn-admin-primary w-100 submit-btn" id="submitBtn">
    <i class="bi bi-rocket-takeoff"></i> Upload <span id="productCountLabel">1 Product</span>
</button>

</form>

</div>


<!-- ================= STYLES ================= -->
<style>

/* =====================================================
   AD-VANCE 3D — BULK PRODUCT UPLOAD
   modern / minimal restyle
   Tokens reused from layout.blade.php; fallbacks included.
===================================================== */

.admin-panel{ --r: 4px; }

.admin-mark{
    width: 38px; height: 38px;
    border-radius: 8px;
    background: var(--ink, #1A1A1A);
    position: relative;
    flex-shrink: 0;
}
.admin-mark::before{
    content: "";
    position: absolute;
    inset: 9px;
    border: 1.5px solid var(--accent, #FF5A1F);
    border-radius: 3px;
}
body.dark-mode .admin-mark{ background: var(--ink-dark, #F2F1ED); }

.admin-title{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    letter-spacing: -0.01em;
    color: var(--ink, #1A1A1A);
    font-size: 1.5rem;
}
body.dark-mode .admin-title{ color: var(--ink-dark, #F2F1ED); }

.admin-subtitle{
    color: var(--ink-soft, #6B6B65);
    font-size: 13px;
}
body.dark-mode .admin-subtitle{ color: var(--ink-soft-dark, #9B9A92); }

/* ALERTS */

.admin-alert{
    border-radius: var(--r);
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 16px;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.admin-alert.success{
    background: #E6F4EA;
    color: #1E7E34;
    border: 1px solid #1E7E34;
}
.admin-alert.error{
    background: rgba(179,38,30,0.08);
    color: #B3261E;
    border: 1px solid #B3261E;
}
.admin-alert div{
    display: flex;
    align-items: center;
    gap: 8px;
}
body.dark-mode .admin-alert.success{ background: rgba(30,126,52,0.15); color: #7FD99A; }
body.dark-mode .admin-alert.error{ background: rgba(179,38,30,0.15); color: #FF8A80; }

/* PRODUCT BLOCK */

.product-box{
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 18px;
    transition: 0.2s ease;
}
.product-box:hover{
    border-color: var(--accent, #FF5A1F);
}
body.dark-mode .product-box{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.product-box-head{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    border-bottom: 1px solid var(--hairline, #E8E6E0);
    background: var(--bg, #FAFAF8);
}
body.dark-mode .product-box-head{
    border-bottom-color: var(--hairline-dark, #2C2C29);
    background: var(--bg-dark, #0F0F0F);
}

.product-box-tag{
    font-family: var(--font-mono, monospace);
    font-size: 12px;
    font-weight: 500;
    color: var(--ink, #1A1A1A);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
body.dark-mode .product-box-tag{ color: var(--ink-dark, #F2F1ED); }

.remove-block-btn{
    background: transparent;
    border: 1px solid var(--hairline, #E8E6E0);
    color: var(--ink-soft, #6B6B65);
    font-size: 12px;
    font-weight: 600;
    padding: 5px 11px;
    border-radius: 3px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: 0.2s ease;
}
.remove-block-btn:hover{
    border-color: #B3261E;
    color: #B3261E;
}
body.dark-mode .remove-block-btn{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-soft-dark, #9B9A92);
}

.product-box-body{
    padding: 20px;
}

.field-row{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}
@media (max-width: 576px){
    .field-row{ grid-template-columns: 1fr; }
}

.form-control{
    border: 1px solid var(--hairline, #E8E6E0) !important;
    border-radius: var(--r) !important;
    font-size: 14px;
    padding: 10px 12px;
    background: var(--bg-raised, #fff);
    color: var(--ink, #1A1A1A);
    margin-bottom: 12px;
    width: 100%;
    transition: border-color 0.2s ease;
}
.form-control:focus{
    outline: none;
    border-color: var(--accent, #FF5A1F) !important;
    box-shadow: 0 0 0 3px var(--accent-50, #FFF1EA) !important;
}
.field-row .form-control{ margin-bottom: 0; }
body.dark-mode .form-control{
    background: var(--bg-dark, #0F0F0F);
    border-color: var(--hairline-dark, #2C2C29) !important;
    color: var(--ink-dark, #F2F1ED);
}

/* IMAGE DROP ZONE */

.image-drop{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 1.5px dashed var(--hairline, #E8E6E0);
    border-radius: var(--r);
    padding: 28px 16px;
    cursor: pointer;
    transition: 0.2s ease;
    color: var(--ink-soft, #6B6B65);
    font-size: 13.5px;
}
.image-drop:hover{
    border-color: var(--accent, #FF5A1F);
    background: var(--accent-50, #FFF1EA);
    color: var(--accent-ink, #7A2B0E);
}
.image-drop i{
    font-size: 22px;
}
.image-drop input[type="file"]{
    display: none;
}
body.dark-mode .image-drop{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-soft-dark, #9B9A92);
}
body.dark-mode .image-drop:hover{
    background: var(--accent-50-dark, #2A1A12);
    color: var(--ink-dark, #F2F1ED);
}

/* PREVIEW */

.preview-container{
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 14px;
}

.preview-tile{
    position: relative;
    width: 90px;
    height: 90px;
    border-radius: var(--r);
    overflow: hidden;
    border: 1px solid var(--hairline, #E8E6E0);
    background: var(--accent-50, #FFF1EA);
}
body.dark-mode .preview-tile{
    border-color: var(--hairline-dark, #2C2C29);
    background: var(--accent-50-dark, #2A1A12);
}

.preview-tile img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-remove{
    position: absolute;
    top: 4px;
    right: 4px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: rgba(15,15,15,0.75);
    color: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    cursor: pointer;
    transition: background 0.2s ease;
}
.preview-remove:hover{
    background: #B3261E;
}

/* BUTTONS */

.btn-admin-primary{
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
    border: 1px solid var(--ink, #1A1A1A);
    border-radius: var(--r);
    font-weight: 600;
    font-size: 14px;
    padding: 13px 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: 0.2s ease;
}
.btn-admin-primary:hover{
    background: var(--accent, #FF5A1F);
    border-color: var(--accent, #FF5A1F);
}
body.dark-mode .btn-admin-primary{
    background: var(--ink-dark, #F2F1ED);
    border-color: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

.btn-admin-secondary{
    background: transparent;
    color: var(--ink, #1A1A1A);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    font-weight: 600;
    font-size: 13.5px;
    padding: 11px 18px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: 0.2s ease;
}
.btn-admin-secondary:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}
body.dark-mode .btn-admin-secondary{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

</style>


<!-- ================= SCRIPT ================= -->

<script>

let blockIndex = 1;

// store File objects per block index, since a native file input's
// FileList can't be mutated directly — this lets us support
// removing a single image from the preview before submit
let fileStore = { 0: [] };

// ADD PRODUCT BLOCK
function addProduct(){

    let i = blockIndex;

    let html = `
    <div class="product-box" data-index="${i}">

        <div class="product-box-head">
            <span class="product-box-tag">Product ${i + 1}</span>
            <button type="button" class="remove-block-btn" onclick="removeBlock(this, ${i})">
                <i class="bi bi-x-lg"></i> Remove
            </button>
        </div>

        <div class="product-box-body">

            <div class="field-row">
                <input type="text" name="products[${i}][name]" class="form-control" placeholder="Product Name" required>
                <input type="number" name="products[${i}][price]" class="form-control" placeholder="Price (₹)" required>
            </div>

            <div class="field-row">
                <input type="text" name="products[${i}][category]" class="form-control" placeholder="Category" required>
                <input type="number" name="products[${i}][stock]" class="form-control" placeholder="Stock" required>
            </div>

            <textarea name="products[${i}][description]" class="form-control" placeholder="Description" rows="3"></textarea>

            <label class="image-drop">
                <i class="bi bi-cloud-upload"></i>
                <span>Click to select images</span>
                <input type="file" class="image-input" multiple accept="image/*" onchange="handleFiles(event, ${i})">
            </label>

            <div class="preview-container" id="preview-${i}"></div>

        </div>

    </div>
    `;

    document.getElementById('productWrapper').insertAdjacentHTML('beforeend', html);

    fileStore[i] = [];
    blockIndex++;

    updateProductCount();
}

// REMOVE A WHOLE PRODUCT BLOCK (with confirmation — prevents
// accidentally losing a fully filled-out block on a stray click)
function removeBlock(btn, i){
    if(!confirm('Remove this product block? Any data entered in it will be lost.')) return;

    btn.closest('.product-box').remove();
    delete fileStore[i];
    updateProductCount();
}

// HANDLE FILE SELECTION — adds newly picked files to this block's
// store (rather than replacing it), then re-renders previews and
// syncs the actual <input type="file"> via DataTransfer so the
// form still submits the right files.
function handleFiles(event, i){

    let newFiles = Array.from(event.target.files);

    if(!fileStore[i]) fileStore[i] = [];
    fileStore[i] = fileStore[i].concat(newFiles);

    renderPreviews(i);
    syncInput(i, event.target);
}

// REMOVE A SINGLE IMAGE FROM A BLOCK'S PREVIEW
function removeImage(i, fileIndex){
    fileStore[i].splice(fileIndex, 1);
    renderPreviews(i);

    let input = document.querySelector(`.product-box[data-index="${i}"] .image-input`);
    syncInput(i, input);
}

// REBUILD THE INPUT'S FileList FROM fileStore SO THE RIGHT
// FILES ACTUALLY GET SUBMITTED WITH THE FORM
function syncInput(i, inputEl){
    let dt = new DataTransfer();
    fileStore[i].forEach(file => dt.items.add(file));
    inputEl.files = dt.files;
    inputEl.name = `products[${i}][images][]`;
}

// RENDER PREVIEW THUMBNAILS FOR A BLOCK
function renderPreviews(i){

    let container = document.getElementById('preview-' + i);
    container.innerHTML = "";

    fileStore[i].forEach((file, fileIndex) => {

        let reader = new FileReader();

        reader.onload = function(e){
            container.insertAdjacentHTML('beforeend', `
                <div class="preview-tile">
                    <img src="${e.target.result}">
                    <button type="button" class="preview-remove" onclick="removeImage(${i}, ${fileIndex})" aria-label="Remove image">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            `);
        }

        reader.readAsDataURL(file);
    });
}

// LIVE PRODUCT COUNT ON SUBMIT BUTTON
function updateProductCount(){
    let count = document.querySelectorAll('.product-box').length;
    let label = document.getElementById('productCountLabel');
    label.innerText = count + (count === 1 ? ' Product' : ' Products');
}

</script>

@endsection