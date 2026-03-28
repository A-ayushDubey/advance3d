@extends('layouts.app')

@section('content')

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Edit Product</h2>

    <a href="/admin/products" class="btn btn-outline-dark">
        ← Back
    </a>
</div>

<div class="card shadow-lg border-0">
<div class="card-body p-4">

<form action="/admin/products/update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
@csrf

<!-- NAME -->
<div class="mb-3">
<label class="fw-semibold">Product Name</label>
<input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
</div>

<!-- PRICE -->
<div class="mb-3">
<label class="fw-semibold">Price</label>
<input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
</div>

<!-- CATEGORY -->
<div class="mb-3">
<label class="fw-semibold">Category</label>
<input type="text" name="category" class="form-control" value="{{ $product->category }}" required>
</div>

<!-- STOCK -->
<div class="mb-3">
<label class="fw-semibold">Stock</label>
<input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
</div>

<!-- DESCRIPTION -->
<div class="mb-4">
<label class="fw-semibold">Description</label>
<textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
</div>

<hr>

<!-- ================= IMAGE MANAGER ================= -->

<h5 class="fw-bold mb-3">Image Manager</h5>

<div class="mb-3 d-flex gap-2">
    <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelected()">
        🗑 Delete Selected
    </button>
</div>

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
                onclick="deleteImage({{ $img->id }}, this)">
            ×
        </button>

        <!-- MAIN LABEL -->
        @if($product->image == $img->image)
            <span class="badge bg-success main-badge">Main</span>
        @endif

    </div>

</div>
@endforeach

</div>

<!-- ADD NEW -->
<div class="mt-4">
<label>Add More Images</label>
<input type="file" name="images[]" multiple class="form-control" onchange="previewImages(event)">
</div>

<!-- PREVIEW -->
<div class="row mt-3" id="previewContainer"></div>

<button class="btn btn-success w-100 mt-4">
Update Product
</button>

</form>

</div>
</div>

</div>

<!-- ================= STYLES ================= -->

<style>

.image-box{
    position:relative;
    background:#f8f9fa;
    border-radius:12px;
    padding:10px;
    overflow:hidden;
    transition:0.3s;
}

.image-box:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}

.img-preview{
    width:100%;
    height:160px;
    object-fit:contain;
    cursor:pointer;
    transition:0.3s;
}

/* MAIN IMAGE */
.main-active{
    border:3px solid #28a745;
}

/* BADGE */
.main-badge{
    position:absolute;
    top:8px;
    left:8px;
}

/* CHECKBOX */
.select-img{
    position:absolute;
    top:8px;
    right:8px;
    transform:scale(1.2);
}

/* DELETE BUTTON */
.delete-btn{
    position:absolute;
    bottom:8px;
    right:8px;
    background:#dc3545;
    color:white;
    border:none;
    border-radius:50%;
    width:28px;
    height:28px;
    font-size:18px;
    cursor:pointer;
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