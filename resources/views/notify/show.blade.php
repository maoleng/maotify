@extends('theme.master')

@section('content')
    <div class="content-page">
        <div class="content-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="navbar-breadcrumb">
                                <h1 class="mb-1">Notifies > {{ $notify->name }}</h1>
                            </div>
                        </div>
                        <form action="{{ route('content.store', ['notify_id' => $notify->id]) }}" method="post" enctype="multipart/form-data" class="float-sm-right">
                            @csrf
                            <button type="button" id="btn-add_content" class="btn btn-primary pr-5 position-relative" style="height: 40px;">
                                Add Content
                                <span class="event-add-btn" style="height: 40px;"><i class="ri-add-line"></i></span>
                            </button>
                            @if ($notify->type === \App\Enums\NotifyType::PHOTO)
                                <input type="file" id="i-contents" name="contents[]" multiple hidden>
                            @else
                                <textarea id="i-contents" name="contents" hidden></textarea>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    @if ($notify->type === \App\Enums\NotifyType::PHOTO)
                        <ul id="area" class="list-unstyled p-0 m-0 row">
                            @foreach($notify->contents as $content)
                                <li data-content_id="{{ $content->id }}" class="elm col-lg-4 col-md-6 col-sm-6 mt-2">
                                    <img src="{{ $content->value['banner'] ?? null }}" class="img-thumbnail w-100 img-fluid rounded" alt="Responsive image">
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div id="area" class="list-unstyled p-0 m-0 row">
                            @foreach($notify->contents as $content)
                                <div data-content_id="{{ $content->id }}" class="elm col-xl-3 col-lg-4 col-md-6">
                                    <div class="card card-block card-stretch card-height">
                                        <div class="card-body rounded event-detail event-detail-info">
                                            <h4 class="my-2">
                                                {{ $content->value['text'] }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div id="trash" class="col-lg-2 col-md-6">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body rounded event-detail event-detail-info">
                            <img src="https://cdn-icons-png.flaticon.com/512/1378/1378355.png" class="pb-3 card-img-top" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>{!! notifyAlert() !!}</script>
    <script>
        const iContents = $('#i-contents');

        $('#btn-add_content').on('click', function () {
            @if ($notify->type === \App\Enums\NotifyType::PHOTO)
                iContents.trigger('click')
            @else
                Swal.fire({
                    title: 'Enter content',
                    input: 'textarea',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Look up',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        iContents.text(result.value)
                        iContents.parent().submit()
                    }
                })
            @endif
        })
        iContents.on('change', function () {
            $(this).parent().submit()
        })

        $('#area').sortable({
            revert: true,
        })

        $('#trash').droppable({
            accept: "#area > .elm",
            classes: {
                "ui-droppable-active": "ui-state-highlight"
            },
            drop: function( event, ui ) {
                const element = ui.draggable

                element.fadeOut(function () {
                    $.ajax({
                        url: `/content/${element.data('content_id')}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        }
                    }).done(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Delete successfully',
                        })
                    })
                })

            }
        })
    </script>


@endsection
