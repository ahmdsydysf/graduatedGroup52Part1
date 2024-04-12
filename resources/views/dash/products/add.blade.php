@extends('custom_layout.dash.app')

@section('page_title' , 'Add new product')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Default Layout</h5>
            <p class="mb-25">More complex forms can be built using the grid classes. Use these for form layouts that
                require multiple columns, varied widths, and additional alignment options.</p>
            <div class="row">
                <div class="col-sm">
                    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <img src="{{ asset('uploads/product/default-product.png') }}" id="img-prv" alt="" width="250px"
                            height="250" srcset="">
                        <div class="form-group">
                            <label for="productname">productname ar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input name="name_ar" value="{{ old('name_ar') }}" class="form-control" id="productname"
                                    placeholder="productname" type="text">
                            </div>
                            @error('name_ar')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="productname">productname en</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input name="name_en" value="{{ old('name_en') }}" class="form-control" id="productname"
                                    placeholder="productname" type="text">
                            </div>
                            @error('name_en')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Price</label>
                            <input name="price" value="{{ old('price') }}" class="form-control" id="email"
                                placeholder="you@example.com" type="text">
                        </div>
                        @error('price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="email">description ar</label>
                            <textarea name="description_ar" class="ahmed form-control mt-15" rows="3"
                                placeholder="Readonly Textarea">description_ar</textarea>
                        </div>
                        @error('description_ar')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="email">description en</label>
                            <textarea name="description_en" class="ahmed form-control mt-15" rows="3"
                                placeholder="Readonly Textarea">description_en</textarea>
                        </div>
                        @error('description_en')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="email">Choose Category</label>
                            <select class="form-control custom-select mt-15" name="category_id" id="">
                                <option value="">No Category</option>
                                @foreach ( $allCategories as $cat )
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror


                        <div class="form-group">
                            <label for="email">Image</label>
                            <input onchange="showPreview(event)" name="image" class="form-control" id="image"
                                placeholder="image" type="file">
                        </div>
                        @error('image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <script>
                            function showPreview(event){
                                if(event.target.files.length > 0){
                                    let src = URL.createObjectURL(event.target.files[0]);
                                    let prv = document.getElementById('img-prv');
                                    prv.src = src;
                                }
                            }
                        </script>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>
<script>
    let allTxtDescriptions = document.querySelectorAll('.ahmed');
    allTxtDescriptions.forEach(desc => {
        ClassicEditor
        .create( desc )
        .catch( error => {
            console.error( error );
        } );
    });

</script>

@endpush
