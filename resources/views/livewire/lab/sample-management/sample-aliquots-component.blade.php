<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    <h6 class="modal-title" id="staticBackdropLabel">Aliquots For Sample (<span
                                            class="text-danger">{{ $sample_identity }}</span>) with Lab_No <span
                                            class="text-info">{{ $lab_no }}</span></h6>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="storeAliquots">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="form-label fw-bold text-success">Aliquots</label>
                                @foreach ($aliquots as $aliquot)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model='aliquots_performed'
                                            id="aliquot{{ $aliquot->id }}" value="{{ $aliquot->id }}">
                                        <label class="form-check-label"
                                            for="aliquot{{ $aliquot->id }}">{{ $aliquot->type }}</label>
                                        <input type="text" wire:model.lazy="aliquotIdentities.{{ $aliquot->id }}"
                                            class="form-control" placeholder="ALIQUOT ID">
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea wire:model.lazy="comment" rows="3" class="form-control" placeholder="{{ __('comment') }}"></textarea>

                                @error('comment')
                                    <div class="text-danger text-small">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <x-button>{{ __('Save') }}</x-button>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
