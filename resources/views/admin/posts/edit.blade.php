@extends('admin/app')
@section('content')

<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Post</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Post</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>

    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <!--begin::Card Header-->
                        <div class="card-header">
                            <h5 class="card-title mb-0">Edit New Post</h5>
                        </div>
                        <!--end::Card Header-->

                        <!--begin::Form-->
                        <form action="{{route('posts.update',$post->id)}}" method="post" enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            <!--begin::Card Body-->
                            <div class="card-body">
                                <div class="row">
                                    <!-- Form Inputs Column -->
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="title" id="title" value="{{$post->title}}" required />
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                                <select name="category_id" class="form-control" required>
                                                    <option value="">--Select Categoty--</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{$post->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="image" id="imageInput" accept="image/*" />
                                                <div class="form-text">Upload an image file (JPEG, PNG, GIF, etc.) Max 5MB.</div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="body">Body <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="body" name="body" placeholder="Post Body">{{$post->body}}</textarea>
                                                <small class="text-danger ps-2 d-none" id="bodyErr">Add content in the body</small>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Inputs Column -->


                                    <div class="col-lg-4">
                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-3 text-center">Image Preview</h6>
                                            <div class="text-center" id="imagePreviewContainer">
                                                @if($post->image)
                                                <img src="{{ asset('assets/posts/' . $post->image) }}"
                                                    id="currentImage"
                                                    alt="Current Image"
                                                    class="img-fluid rounded border preview-image"
                                                    style="max-height: 200px;">
                                                <div class="mt-2 text-center text-muted small" id="currentFileName">
                                                    {{ $post->image }}
                                                </div>
                                                @else
                                                <div id="noImagePlaceholder">
                                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                    <p class="text-muted">No image available</p>
                                                </div>
                                                @endif

                                                <!-- New image preview (initially hidden) -->
                                                <div id="newImagePreview" class="d-none">
                                                    <img id="previewImage"
                                                        src="#"
                                                        alt="New Image Preview"
                                                        class="img-fluid rounded border preview-image"
                                                        style="max-height: 200px;">
                                                    <div class="mt-2 text-center text-muted small" id="newFileName"></div>
                                                    <div class="mt-1 text-center">
                                                        <small class="text-info"><i class="fas fa-sync-alt me-1"></i>New selection</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card Body-->

                            <!--begin::Card Footer-->
                            <div class="card-footer">
                                <div class="d-flex ">
                                    <a href="{{route('posts.index')}}" class="btn btn-outline-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Post</button>
                                </div>
                            </div>
                            <!--end::Card Footer-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
</main>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

<script>
    let editor;

    ClassicEditor
        .create(document.querySelector('#body'))
        .then(ed => {
            editor = ed;

            editor.model.document.on('change:data', () => {
                const bodyErr = document.getElementById('bodyErr');
                if (editor.getData().trim() !== "") {
                    bodyErr.classList.add('d-none');
                }
            });
        })
        .catch(error => console.error(error));

    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('imageInput');
        const previewImage = document.getElementById('previewImage');
        const newImagePreview = document.getElementById('newImagePreview');
        const currentImage = document.getElementById('currentImage');
        const noImagePlaceholder = document.getElementById('noImagePlaceholder');
        const currentFileName = document.getElementById('currentFileName');
        const newFileName = document.getElementById('newFileName');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file (JPEG, PNG, GIF, etc.)');
                    this.value = '';
                    return;
                }

                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    // Show new image preview
                    previewImage.src = reader.result;
                    newFileName.textContent = file.name;

                    // Hide current image or placeholder
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                    if (noImagePlaceholder) {
                        noImagePlaceholder.style.display = 'none';
                    }
                    if (currentFileName) {
                        currentFileName.style.display = 'none';
                    }

                    // Show new image preview
                    newImagePreview.classList.remove('d-none');

                    // Add animation effect
                    newImagePreview.style.opacity = '0';
                    newImagePreview.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => {
                        newImagePreview.style.opacity = '1';
                    }, 10);
                });

                reader.readAsDataURL(file);
            } else {
                // If no file selected, show the original image again
                newImagePreview.classList.add('d-none');
                if (currentImage) {
                    currentImage.style.display = 'block';
                    currentFileName.style.display = 'block';
                }
                if (noImagePlaceholder && !currentImage) {
                    noImagePlaceholder.style.display = 'block';
                }
            }
        });

        // Optional: Add drag and drop functionality
        const previewContainer = document.getElementById('imagePreviewContainer');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            previewContainer.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            previewContainer.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            previewContainer.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            previewContainer.classList.add('border-primary');
            previewContainer.classList.add('bg-primary-light');
        }

        function unhighlight(e) {
            previewContainer.classList.remove('border-primary');
            previewContainer.classList.remove('bg-primary-light');
        }

        previewContainer.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                imageInput.files = files;

                // Trigger change event manually
                const event = new Event('change', {
                    bubbles: true
                });
                imageInput.dispatchEvent(event);
            }
        });
    });
</script>

<style>
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .preview-image {
        object-fit: contain;
        max-width: 100%;
        transition: transform 0.3s ease;
    }

    .preview-image:hover {
        transform: scale(1.02);
    }


    #noImagePlaceholder {
        transition: all 0.3s ease;
    }
</style>
@endsection