<div class="modal fade delete p-4 bg-light border border-bottom-0 mg-t-20" id="DelePackageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal d-block pos-static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <form action="{{ route('packages.destroy','test') }}" method="POST">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="">
                            <i class="fe fe-x-circle fs-100 text-danger lh-1 mg-t-20 d-inline-block"></i>
                        <h4 class="text-danger">Error: Cannot process your entry!</h4>
                        <p class="mg-b-20 mg-x-20">{{ __('message.will_delete_items') }}</p>
                        <button aria-label="Close" class="btn btn-danger pd-x-25" type="submit">{{ __('message.continue') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>