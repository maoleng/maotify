@extends('theme.master')

@section('content')
    <div class="content-page">
        <div class="content-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="navbar-breadcrumb">
                                <h1 class="mb-1">Notifies</h1>
                            </div>
                            <div class="float-sm-right">
                                <a href="#" data-toggle="modal" data-target="#form-create" class="btn btn-primary pr-5 position-relative" style="height: 40px;">
                                    Add Notify
                                    <span class="event-add-btn" style="height: 40px;"><i class="ri-add-line"></i></span>
                                </a>
                                <form action="{{ route('notify.store') }}" method="post" enctype="multipart/form-data" class="modal fade" id="form-create" tabindex="-1" role="dialog" aria-hidden="true">
                                    @include('notify.form')
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
                        @foreach ($notifies as $notify)
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body rounded event-detail event-detail-info">
                                        <img src="{{ $notify->banner }}" class="pb-3 card-img-top" alt="#">
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div><h1 class="text-info">{{ $notify->schedule }}</h1></div>
                                            <div class="d-flex align-items-center list-action">
                                                <h4 class=""><span class="badge badge-success">{{ $notify->count }} times</span></h4>
                                            </div>
                                        </div>
                                        <h4 class="my-2">{{ $notify->name }}</h4>
                                        <div class="d-flex align-items-center pt-4">
                                            <a href="{{ route('notify.show', ['notify' => $notify]) }}" class="btn btn-outline-info mr-3">Show</a>
                                            <a href="#" data-toggle="modal" data-target="#form-{{ $notify->id }}-update" class="btn btn-outline-warning mr-3">Edit</a>
                                            <form action="{{ route('notify.destroy', ['notify' => $notify]) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-outline-danger">Destroy</button>
                                            </form>
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

    @foreach ($notifies as $notify)
        <form action="{{ route('notify.update', ['notify' => $notify]) }}" method="post" enctype="multipart/form-data" class="modal fade" id="form-{{ $notify->id }}-update" tabindex="-1" role="dialog" aria-hidden="true">
            @method('PUT')
            @include('notify.form')
        </form>
    @endforeach

@endsection

@section('script')
    <script>{!! notifyAlert() !!}</script>
@endsection
