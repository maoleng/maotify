@csrf
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="popup text-left">
                <h4 class="mb-4">{{ isset($category) ? 'Update' : 'Create' }} Category</h4>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="floating-input form-group">
                            <input class="form-control" value="{{ $category->name ?? null }}" type="text" name="name" id="name" required />
                            <label class="form-label" for="name">Name</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="floating-input form-group">
                            <input class="form-control" value="{{ $category->channel ?? null }}" type="text" name="channel" id="channel" required />
                            <label class="form-label" for="channel">Channel ID</label>
                        </div>
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
