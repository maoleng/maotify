@csrf
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="popup text-left">
                <h4 class="mb-4">{{ isset($notify) ? 'Update' : 'Create' }} Notify</h4>

                <div class="row content create-workform">
                    <div class="col-lg-12 mb-2">
                        <label class="title">Type</label>
                        <div class="form-group">
                            <select name="type" class="selectpicker form-control" data-style="py-0">
                                @foreach(\App\Enums\NotifyType::asArray() as $name => $value)
                                    <option value="{{ $value }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <label class="title">Category</label>
                        <div class="form-group">
                            <select name="category_id" class="selectpicker form-control" data-style="py-0">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="floating-input form-group">
                            <input class="form-control" value="{{ $notify->name ?? null }}" type="text" name="name" id="name" required />
                            <label class="form-label" for="name">Name</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="floating-input form-group">
                            <input class="form-control" value="{{ $notify->schedule ?? null }}" type="text" name="schedule" id="schedule" required />
                            <label class="form-label" for="schedule">Cronjob expression</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label class="title">Banner</label>
                        <input type="file" name="banner" class="form-control">
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                        <button class="btn btn-primary mr-4">Save</button>
                        <div class="btn btn-outline-primary" data-dismiss="modal">Cancel</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
