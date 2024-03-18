<!-- modal-wrapper-User -->
<div class="modal fade p-4 bg-light border border-bottom-0 edit_package_form_modal" id="CreatePackageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal d-block pos-static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('message.create_new_package') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('update.package.details') }}" method="POST" id="edit_package_form">
                    @csrf
                    <input type="hidden" name="pid">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.package_name') }}</label>
                                    <input type="text" name="package_name" class="form-control" id="package_name" placeholder="Package Name">
                                    <span class="text-danger error-text package_name_error"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.package_description') }}</label>
                                    <input type="text" name="description" class="form-control" id="package_description" placeholder="Package Description">
                                    <span class="text-danger error-text description_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.package_price') }}</label>
                                    <input type="text" name="price" class="form-control" id="package_price" placeholder="Package Price">
                                    <span class="text-danger error-text price_error"></span>
                                </div>
                            </div>

                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.package_trial_days') }}</label>
                                    <input type="number" name="package_trial_days" class="form-control" id="package_trial_days" placeholder="Package Trial Days">
                                    <span class="text-danger error-text package_trial_days_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.is_active') }}</label>
                                    <input type="checkbox" checked value="0" name="is_active" class="form-control" id="is_active">
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.is_one_time') }}</label>
                                    <input type="checkbox" checked value="0" name="is_one_time" class="form-control" id="is_one_time">
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-0">
                                <div class="form-group">
                                    <label class="form-label">{{ __('message.is_private') }}</label>
                                    <input type="checkbox" checked value="0" name="is_private" class="form-control" id="is_private">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-12 mb-0">
                                <div class="form-group">
                                <label class="form-label">{{ __('message.interval') }}</label>
                                    <select name="interval" id="interval" required class="form-control custom-select select2">
                                        @error('interval')<div class="alert alert-danger">{{ $message }}</div>@enderror
                                        @forelse($intervals as $interval)
                                            <option value="{{$interval}}"> -- {{$interval}} </option>
                                        @empty
                                            <option selected>-- There No Data --</option>
                                        @endforelse
                                    </select>
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
