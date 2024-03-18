<!-- modal-wrapper-User -->
<div class="modal fade p-4 bg-light border border-bottom-0 tax_form_modal" id="CreateTaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal d-block pos-static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('message.create_new_tax') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('taxs.store') }}" method="POST" id="tax_form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.tax_name') }}</label>
                                    <input type="text" name="tax_name" class="form-control" id="tax_name" placeholder="tax Name">
                                    <span class="text-danger error-text tax_name_error"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.tax_amount') }}</label>
                                    <input type="text" name="tax_amount" class="form-control" id="tax_amount" placeholder="tax amount">
                                    <span class="text-danger error-text tax_amount_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-indigo" type="submit">{{ __('message.save_changes') }}</button> 
                        <button class="btn btn-secondary" type="button"  data-dismiss="modal">{{ __('message.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>