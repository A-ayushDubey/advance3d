@extends('layouts.app')

@section('content')

<div class="container py-5">

<h2 class="fw-bold mb-4">Add Multiple Products</h2>

{{-- SUCCESS / ERROR --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif


<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div id="productWrapper">

    <!-- ================= PRODUCT BLOCK ================= -->
    <div class="product-box card p-4 mb-4 shadow-sm">

        <div class="d-flex justify-content-between mb-3">
            <h5>Product</h5>
        </div>

        <input type="text" name="products[0][name]" class="form-control mb-2" placeholder="Product Name" required>

        <input type="number" name="products[0][price]" class="form-control mb-2" placeholder="Price" required>

        <input type="text" name="products[0][category]" class="form-control mb-2" placeholder="Category" required>

        <input type="number" name="products[0][stock]" class="form-control mb-2" placeholder="Stock" required>

        <textarea name="products[0][description]" class="form-control mb-3" placeholder="Description"></textarea>

        <!-- IMAGE INPUT -->
        <input type="file" name="products[0][images][]" class="form-control image-input" multiple onchange="previewImages(event, 0)">

        <!-- PREVIEW -->
        <div class="row mt-3 preview-container" id="preview-0"></div>

    </div>

</div>

<!-- ADD PRODUCT -->
<button type="button" class="btn btn-dark mb-3" onclick="addProduct()">
➕ Add Another Product
</button>

<!-- SUBMIT -->
<button class="btn btn-primary w-100">
🚀 Upload Products
</button>

</form>

</div>


<!-- ================= STYLES ================= -->
<style>

.product-box{
    border-radius:12px;
    transition:0.3s;
}

.product-box:hover{
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* Image preview */
.preview-img{
    height:120px;
    object-fit:contain;
    border-radius:8px;
    background:#f8f9fa;
    padding:5px;
}

</style>


<!-- ================= SCRIPT ================= -->

<script>

let index = 1;

// ADD PRODUCT BLOCK
function addProduct(){

    let html = `
    <div class="product-box card p-4 mb-4 shadow-sm">

        <div class="d-flex justify-content-between mb-3">
            <h5>Product</h5>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.product-box').remove()">
                ❌ Remove
            </button>
        </div>

        <input type="text" name="products[${index}][name]" class="form-control mb-2" placeholder="Product Name" required>

        <input type="number" name="products[${index}][price]" class="form-control mb-2" placeholder="Price" required>

        <input type="text" name="products[${index}][category]" class="form-control mb-2" placeholder="Category" required>

        <input type="number" name="products[${index}][stock]" class="form-control mb-2" placeholder="Stock" required>

        <textarea name="products[${index}][description]" class="form-control mb-3" placeholder="Description"></textarea>

        <input type="file" name="products[${index}][images][]" class="form-control image-input" multiple onchange="previewImages(event, ${index})">

        <div class="row mt-3 preview-container" id="preview-${index}"></div>

    </div>
    `;

    document.getElementById('productWrapper').insertAdjacentHTML('beforeend', html);

    index++;
}


// IMAGE PREVIEW
function previewImages(event, index){

    let container = document.getElementById('preview-' + index);
    container.innerHTML = "";

    Array.from(event.target.files).forEach(file => {

        let reader = new FileReader();

        reader.onload = function(e){
            container.innerHTML += `
                <div class="col-md-3 mb-2">
                    <img src="${e.target.result}" class="img-fluid preview-img shadow-sm">
                </div>
            `;
        }

        reader.readAsDataURL(file);
    });
}

</script>

@endsection