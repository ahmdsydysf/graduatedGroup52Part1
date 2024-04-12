@extends('custom_layout.dash.app')

@section('page_title' , 'All categories')

@section('content')
<!-- Row -->
<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Striped Table</h5>
            <p class="mb-40">Add class <code>.table-striped</code> in table tag.</p>
            <a class="btn btn-primary" href="{{ route('dashboard.categories.create') }}">Add category</a>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>name</th>
                                        <th>sub title</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $category )
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{ $category->name }}
                                        </td>
                                        <td>{{ $category->sub_title }}</td>
                                        <td>

                                            <img width="150" height="150"
                                                src="{{ asset('uploads/category/' . $category->category_image ) }}"
                                                alt="" srcset="">

                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.categories.edit' , $category->id) }}"
                                                class="mr-25" data-toggle="tooltip" data-original-title="Edit"> <i
                                                    class="icon-pencil"></i> </a>
                                            <form action="{{ route('dashboard.categories.destroy' , $category->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger"> <i class="icon-trash txt-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
