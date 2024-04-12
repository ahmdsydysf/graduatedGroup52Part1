@extends('custom_layout.dash.app')

@section('page_title' , 'Edit category')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Default Layout</h5>
            <p class="mb-25">More complex forms can be built using the grid classes. Use these for form layouts that
                require multiple columns, varied widths, and additional alignment options.</p>
            <div class="row">
                <div class="col-sm">
                    <form action="{{ route('dashboard.categories.update' , $category->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <img src="{{ asset('uploads/category/' . $category->category_image) }}" id="img-prv" alt=""
                            width="250px" height="250" srcset="">
                        <div class="form-group">
                            <label for="categoryname">categoryname</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input name="name" value="{{ $category->name }}" class="form-control" id="categoryname"
                                    placeholder="categoryname" type="text">
                            </div>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">sub title</label>
                            <input name="sub_title" value="{{ $category->sub_title }}" class="form-control" id="email"
                                placeholder="you@example.com" type="text">
                        </div>
                        @error('sub_title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="email">Password</label>
                            <input onchange="showPreview(event)" name="category_image" class="form-control"
                                id="password" placeholder="Password" type="file">
                        </div>
                        @error('category_image')
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

                        <button class="btn btn-primary" type="submit">update</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
