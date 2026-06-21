@extends('layouts.app')

@section('content')

<div class="container py-5 admin-panel">

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <span class="admin-mark"></span>
        <div>
            <h2 class="fw-bold mb-0 admin-title">Edit Product</h2>
            <small class="admin-subtitle">{{ $product->name }}</small>
        </div>
    </div>

    <a href="/admin/products" class="btn-admin-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="admin-card form-card">

<form action="/admin/products/update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
@csrf

<!-- NAME -->
<div class="field-group">
<label>Product Name</label>
<input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
</div>

<!-- PRICE -->
<div class="field-group">
<label>Price</label>
<input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
</div>

<!-- CATEGORY -->
<div class="field-group">
<label>Category</label>
<input type="text" name="category" class="form-control" value="{{ $product->category }}" required>
</div>

<!-- STOCK -->
<div class="field-group">
<label>Stock</label>
<input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
</div>

<!-- DESCRIPTION -->
<div class="field-group">
<label>Description</label>
<textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
</div>

<div class="section-divider"></div>

<!-- ================= IMAGE MANAGER ================= -->

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="section-title mb-0">Image Manager</h5>

    <button type="button" class="btn-danger-outline" onclick="deleteSelected()">
        <i class="bi bi-trash3"></i> Delete Selected
    </button>
</div>

<p class="image-hint"><i class="bi bi-info-circle"></i> Drag to reorder · Click an image to set it as the main photo</p>

<div class="row g-3" id="imageContainer">

@foreach($product->images as $img)
<div class="col-md-3 image-item" data-id="{{ $img->id }}">

    <div class="image-box">

        <!-- CHECKBOX -->
        <input type="checkbox" class="select-img">

        <!-- IMAGE -->
        <img src="/product_images/{{ $img->image }}"
             onclick="setMainImage({{ $img->id }}, this)"
             class="img-preview {{ $product->image == $img->image ? 'main-active' : '' }}">

        <!-- DELETE BUTTON -->
        <button type="button"
                class="delete-btn"
                onclick="deleteImage({{ $img->id }}, this)"
                aria-label="Delete image">
            <i class="bi bi-x"></i>
        </button>

        <!-- MAIN LABEL -->
        @if($product->image == $img->image)
            <span class="main-badge">Main</span>
        @endif

    </div>

</div>
@endforeach

</div>

<!-- ADD NEW -->
<div class="mt-4">
<label class="field-label-standalone">Add More Images</label>
<label class="image-drop">
    <i class="bi bi-cloud-upload"></i>
    <span>Click to select images</span>
    <input type="file" name="images[]" multiple accept="image/*" onchange="previewImages(event)">
</label>
</div>

<!-- PREVIEW -->
<div class="row mt-3" id="previewContainer"></div>

<button class="btn-admin-primary w-100 mt-4">
    <i class="bi bi-check2-circle"></i> Update Product
</button>

</form>

</div>

</div>


<!-- ================= STYLES ================= -->

<style>

/* =====================================================
   AD-VANCE 3D — EDIT PRODUCT
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

.btn-admin-secondary{
    background: transparent;
    color: var(--ink, #1A1A1A);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    font-weight: 600;
    font-size: 13.5px;
    padding: 10px 18px;
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

/* FORM CARD */

.admin-card.form-card{
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 6px;
    padding: 28px;
}
body.dark-mode .admin-card.form-card{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.field-group{
    margin-bottom: 16px;
}

.field-group label,
.field-label-standalone{
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--ink, #1A1A1A);
    margin-bottom: 6px;
}
body.dark-mode .field-group label,
body.dark-mode .field-label-standalone{
    color: var(--ink-dark, #F2F1ED);
}

.form-control{
    border: 1px solid var(--hairline, #E8E6E0) !important;
    border-radius: var(--r) !important;
    font-size: 14px;
    padding: 10px 12px;
    background: var(--bg-raised, #fff);
    color: var(--ink, #1A1A1A);
    width: 100%;
    transition: border-color 0.2s ease;
}
.form-control:focus{
    outline: none;
    border-color: var(--accent, #FF5A1F) !important;
    box-shadow: 0 0 0 3px var(--accent-50, #FFF1EA) !important;
}
body.dark-mode .form-control{
    background: var(--bg-dark, #0F0F0F);
    border-color: var(--hairline-dark, #2C2C29) !important;
    color: var(--ink-dark, #F2F1ED);
}

.section-divider{
    height: 1px;
    background: var(--hairline, #E8E6E0);
    margin: 28px 0 22px;
}
body.dark-mode .section-divider{
    background: var(--hairline-dark, #2C2C29);
}

.section-title{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 16px;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .section-title{ color: var(--ink-dark, #F2F1ED); }

.image-hint{
    font-size: 12.5px;
    color: var(--ink-soft, #6B6B65);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}
body.dark-mode .image-hint{ color: var(--ink-soft-dark, #9B9A92); }

.btn-danger-outline{
    background: transparent;
    border: 1px solid var(--hairline, #E8E6E0);
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
.btn-danger-outline:hover{
    border-color: #B3261E;
    color: #B3261E;
}
body.dark-mode .btn-danger-outline{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

/* IMAGE BOX */

.image-box{
    position: relative;
    background: var(--accent-50, #FFF1EA);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    padding: 10px;
    overflow: hidden;
    transition: 0.25s ease;
}

.image-box:hover{
    transform: translateY(-4px);
    border-color: var(--accent, #FF5A1F);
    box-shadow: 0 14px 30px rgba(0,0,0,0.1);
}

body.dark-mode .image-box{
    background: var(--accent-50-dark, #2A1A12);
    border-color: var(--hairline-dark, #2C2C29);
}

.img-preview{
    width: 100%;
    height: 150px;
    object-fit: contain;
    cursor: pointer;
    transition: 0.25s ease;
    border-radius: 3px;
}

/* MAIN IMAGE */
.main-active{
    outline: 2px solid var(--accent, #FF5A1F);
    outline-offset: 2px;
}

/* BADGE */
.main-badge{
    position: absolute;
    top: 8px;
    left: 8px;
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
    font-family: var(--font-mono, monospace);
    font-size: 10px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 3px 8px;
    border-radius: 2px;
}
body.dark-mode .main-badge{
    background: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

/* CHECKBOX */
.select-img{
    position: absolute;
    top: 8px;
    right: 8px;
    transform: scale(1.15);
    accent-color: var(--accent, #FF5A1F);
}

/* DELETE BUTTON */
.delete-btn{
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: var(--bg-raised, #fff);
    color: var(--ink, #1A1A1A);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 50%;
    width: 26px;
    height: 26px;
    font-size: 13px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}
.delete-btn:hover{
    border-color: #B3261E;
    color: #B3261E;
}
body.dark-mode .delete-btn{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

/* IMAGE DROP ZONE (matches the bulk-upload page) */

.image-drop{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 1.5px dashed var(--hairline, #E8E6E0);
    border-radius: var(--r);
    padding: 24px 16px;
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

/* PREVIEW (newly added images, before submit) */

#previewContainer img{
    border-radius: var(--r);
    border: 1px solid var(--hairline, #E8E6E0);
    box-shadow: none !important;
}
body.dark-mode #previewContainer img{
    border-color: var(--hairline-dark, #2C2C29);
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

</style>

<!-- ================= SCRIPTS ================= -->

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>

// DRAG DROP SORT
new Sortable(document.getElementById('imageContainer'), {
    animation:150,
    onEnd: function(){

        let order = [];

        document.querySelectorAll('.image-item').forEach((el, index)=>{
            order.push({
                id: el.dataset.id,
                position: index
            });
        });

        fetch('/admin/update-image-order', {
            method:'POST',
            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}',
                'Content-Type':'application/json'
            },
            body: JSON.stringify({order:order})
        });

    }
});

// SET MAIN IMAGE
function setMainImage(id, element){

    fetch(`/admin/set-main-image/${id}`,{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.success){
            document.querySelectorAll('.img-preview').forEach(img=>{
                img.classList.remove('main-active');
            });
            element.classList.add('main-active');
        }
    });

}

// IMAGE PREVIEW
function previewImages(event){

    let container = document.getElementById('previewContainer');
    container.innerHTML = "";

    Array.from(event.target.files).forEach(file => {

        let reader = new FileReader();

        reader.onload = function(e){
            container.innerHTML += `
                <div class="col-md-3 mb-2">
                    <img src="${e.target.result}" class="img-fluid rounded shadow">
                </div>
            `;
        }

        reader.readAsDataURL(file);
    });

}

// DELETE SINGLE
function deleteImage(id, element){

    if(!confirm("Delete this image?")) return;

    fetch(`/admin/delete-image/${id}`,{
        method:'DELETE',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            element.closest('.image-item').remove();
        }
    });

}

// BULK DELETE
function deleteSelected(){

    let ids = [];

    document.querySelectorAll('.image-item').forEach(item=>{
        if(item.querySelector('.select-img').checked){
            ids.push(item.dataset.id);
        }
    });

    if(ids.length === 0){
        alert("Select images first");
        return;
    }

    fetch('/admin/delete-multiple-images',{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Content-Type':'application/json'
        },
        body: JSON.stringify({ids:ids})
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.success){
            location.reload();
        }
    });

}

</script>

@endsection