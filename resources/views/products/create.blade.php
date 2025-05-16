@extends('layouts.app') 
 
@section('content') 
 
<div class="row justify-content-center mt-3"> 
    <div class="col-md-8"> 
 
        <div class="card"> 
            <div class="card-header"> 
                <div class="float-start"> 
                    Add New Product 
                </div> 
                <div class="float-end"> 
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a> 
                </div> 
            </div> 
            <div class="card-body"> 
                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data"> 
                    @csrf 
 
                    <div class="mb-3 row"> 
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label> 
                        <div class="col-md-6"> 
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"> 
                            @error('name') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror 
                        </div> 
                    </div> 
 
                    <div class="mb-3 row"> 
                        <label for="stock" class="col-md-4 col-form-label text-md-end text-start">Stock</label> 
                        <div class="col-md-6"> 
                          <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}"> 
                            @error('stock') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror 
                        </div> 
                    </div> 
 
                    <div class="mb-3 row"> 
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start">Price</label> 
                        <div class="col-md-6"> 
                          <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}"> 
                            @error('price') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror 
                        </div> 
                    </div> 

                    <div class="mb-3 row"> 
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label> 
                        <div class="col-md-6"> 
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea> 
                            @error('description') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror 
                        </div> 
                    </div> 

                    <div class="mb-3 row"> 
                        <label for="file" class="col-md-4 col-form-label text-md-end text-start">File (PDF, DOC, DOCX, JPG, PNG)</label> 
                        <div class="col-md-6"> 
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" onchange="previewFile(this)"> 
                                        <span class="input-group-text">Upload File</span>
                                    </div>
                                    @error('file') 
                                        <span class="text-danger">{{ $message }}</span> 
                                    @enderror 
                                </div>
                            </div>
                            <div id="filePreview" class="mt-2" style="display: none;">
                                <div class="card">
                                    <div class="card-body">
                                        <img id="imagePreview" class="img-fluid" style="max-height: 200px; display: none;">
                                        <div id="fileInfo" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                     
                    <div class="mb-3 row"> 
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Product"> 
                    </div> 
                </form> 
            </div> 
        </div> 
    </div>     
</div> 

@push('scripts')
<script>
function previewFile(input) {
    const preview = document.getElementById('filePreview');
    const imagePreview = document.getElementById('imagePreview');
    const fileInfo = document.getElementById('fileInfo');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileType = file.type;
        
        // Show preview container
        preview.style.display = 'block';
        
        // Check if file is an image
        if (fileType.startsWith('image/')) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                fileInfo.style.display = 'block';
                
                // Add some styling to make the preview more visible
                imagePreview.style.maxWidth = '100%';
                imagePreview.style.borderRadius = '4px';
                imagePreview.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                
                // Show file info including the link
                fileInfo.innerHTML = `
                    <p class="mb-0"><strong>File Name:</strong> ${file.name}</p>
                    <p class="mb-0"><strong>File Type:</strong> ${fileType}</p>
                    <p class="mb-0"><strong>File Size:</strong> ${(file.size / 1024).toFixed(2)} KB</p>
                    <p class="mb-0"><strong>Image Link:</strong> <a href="${e.target.result}" target="_blank">View Image</a></p>
                `;
            }
            
            reader.readAsDataURL(file);
        } else {
            // For non-image files, show file info
            imagePreview.style.display = 'none';
            fileInfo.style.display = 'block';
            fileInfo.innerHTML = `
                <p class="mb-0"><strong>File Name:</strong> ${file.name}</p>
                <p class="mb-0"><strong>File Type:</strong> ${fileType}</p>
                <p class="mb-0"><strong>File Size:</strong> ${(file.size / 1024).toFixed(2)} KB</p>
            `;
        }
    } else {
        preview.style.display = 'none';
    }
}
</script>
@endpush
     
@endsection 