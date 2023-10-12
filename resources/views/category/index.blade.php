@extends('theme.master')

@section('content')
    <div class="content-page">
        <div class="content-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="navbar-breadcrumb">
                                <h1 class="mb-1">Category</h1>
                            </div>
                            <div class="float-sm-right">
                                <a href="#" data-toggle="modal" data-target="#form-create" class="btn btn-primary pr-5 position-relative" style="height: 40px;">
                                    Add Category
                                    <span class="event-add-btn" style="height: 40px;"><i class="ri-add-line"></i></span>
                                </a>
                                <form action="{{ route('category.store') }}" method="post" class="modal fade" id="form-create" tabindex="-1" role="dialog" aria-hidden="true">
                                    @include('category.form')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach ($categories as $category)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body rounded work-detail work-detail-success">
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <h4>
                                                <a href="{{ route('index', ['category_id' => $category->id]) }}" target="_blank">{{ $category->name }}</a>
                                                <span class="badge badge-success">{{ $category->notifies_count }}</span>
                                            </h4>
                                            <div class="d-flex align-items-center list-action">
                                                <a class="badge mr-3" data-toggle="modal" data-target="#form-{{ $category->id }}-update" href="#"><i class="ri-edit-box-line"></i></a>
                                                <form action="{{ route('category.destroy', ['category' => $category]) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="badge" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center pt-4">
                                            <input type="text" hidden value="{{ $category->channel }}" id="i-{{ $category->id }}-channel">
                                            <a href="#" class="btn btn-success mr-3 px-4 btn-calendify copy px-xl-4" data-input="#i-{{ $category->id }}-channel" data-extra-toggle="copy" title="Copy to clipboard" data-toggle="tooltip"><i class="las la-link pr-2"></i>Copy Channel ID</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($categories as $category)
        <form action="{{ route('category.update', ['category' => $category]) }}" method="post" class="modal fade" id="form-{{ $category->id }}-update" tabindex="-1" role="dialog" aria-hidden="true">
            @method('PUT')
            @include('category.form')
        </form>
    @endforeach
@endsection

@section('script')
    <script>{!! notifyAlert() !!}</script>
@endsection
