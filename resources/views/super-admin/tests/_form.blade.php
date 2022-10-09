<div class="row">
    <div class="mb-3 col-lg-3">
        <div class="form-group">
            <label for="category">{{ __('Category') }}</label>
            <select name="category_id" wire:model='category_id' class="select2 form-control" id="category" required>
                <option selected value="">Select</option>
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3 col-lg-7">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" class="form-control" name="name" id="name"
                @if (isset($test)) wire:model="name" @endif required>
        </div>
    </div>
    <div class="mb-3 col-lg-2">
        <div class="form-group">
            <label for="shortcut">{{ __('Short code') }}</label>
            <input type="text" class="form-control" name="shortcut" id="shortcut"
                @if (isset($test)) wire:model='short_code' @endif required>
        </div>
    </div>
    <div class="mb-3 col-lg-3">
        <div class="form-group">
            <label for="price">{{ __('Price') }}</label>
            <div class="input-group form-group mb-3">
                <input type="number" step="any" class="form-control" name="price" min="0" id="price"
                    @if (isset($test)) wire:model='price' @endif required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        UGX
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 col-lg-2">
        <div class="form-group">
            <label for="reference_range_min">Min-Ref range</label>
            <input type="number" step="any" name="reference_range_min"
                @if (isset($test)) wire:model='reference_range_min' @endif class="form-control"
                id="reference_range_min">
        </div>
    </div>
    <div class="mb-3 col-lg-2">
        <div class="form-group">
            <label for="reference_range_max">Max-Ref range</label>
            <input type="number" step="any" name="reference_range_max"
                @if (isset($test)) wire:model='reference_range_max' @endif class="form-control"
                id="reference_range_max">
        </div>
    </div>
    <div class="col-lg-5">
        <div class="form-group">
            <label for="precautions">{{ __('Precautions') }}</label>
            <textarea name="precautions" id="precautions" rows="3"
                @if (isset($test)) wire:model='precautions' @endif class="form-control"
                placeholder="{{ __('Precautions') }}"></textarea>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div>
        <h6>
            {{ __('Attach Result Type') }}
        </h6>
    </div>
    @if (isset($test))
        @if ($test->unit == 'Absolute')
            <div class="table-responsive">
                <table class="table" id="dynamicoptions">
                    {{-- <tr>
                        <th>Option</th>
                        <th>Action</th>
                    </tr> --}}
                    @foreach ($testresults as $item)
                        <tr>
                            <td>{{ $item->possible_result }}</td>
                            <td> <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip"
                                    wire:click="deleteConfirmation({{ $item->id }})" title="Delete"><i
                                        class="bi bi-trash-fill"></i></a> </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <input type="text" name="possible_result" wire:model="possible_result"
                                placeholder="Enter possible result" class="form-control" />
                            @error('possible_result')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </td>
                        <td><button type="button" name="add" id="dynamic-resultsc"
                                wire:click.prevent="storeResult()" class="btn btn-outline-primary">Add</button></td>
                    </tr>
                </table>
            </div>
        @elseif ($test->unit == 'Measurable')
            @foreach ($testresults as $item)
                <div class="row">
                    <div class="col-md-6">
                        <select name="type" readonly class="form-control" id="">
                            <option value="{{ $item->id }}">{{ $test->unit }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group form-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __('Unit of Measure') }}
                                </span>
                            </div>
                            <input type="text" class="form-control" name="uom" id="uom"
                                value="{{ $item->uom }}">
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <select name="type" onchange="resultstype()" id="resultype" class="form-select"
                            style="width: 100%; height:36px;" required>
                            <option selected value="{{ $test->unit }}">Input ({{ $test->unit }})
                            </option>
                            <option disabled value="text">Text</option>
                            <option disabled value="file">File</option>
                            <option disabled value="Absolute">Absolute</option>
                            <option disabled value="Measurable">Measurable</option>
                        </select>
                    </div>
                    <div id="resultoption" style="display: none" class="col">
                        <div class="table-responsive">

                            <table class="table" id="dynamicoptions">
                                {{-- <tr>
                                    <th>Option</th>
                                    <th>Action</th>
                                </tr> --}}
                                <tr>
                                    <td><input type="text" name="results[]" placeholder="Enter possible result"
                                            class="form-control" />
                                    </td>
                                    <td><button type="button" name="add" id="dynamic-results"
                                            class="btn btn-outline-primary">Add</button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="uomdefault" style="display: none" class="col">
                        <div class="input-group form-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __('Unit of Measure') }}
                                </span>
                            </div>
                            <input type="text" class="form-control" name="uom" id="uom"
                                @if (isset($test)) value="{{ $test->uom }}" @endif>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="col-md-12">
            <div class="row">
                <div class="col">
                    <select name="type" onchange="resultstype()" id="resultype" class="form-select"
                        style="width: 100%; height:36px;" required>
                        <option value="">Select</option>
                        <option value="text">Text</option>
                        <option value="file">File</option>
                        <option value="Absolute">Absolute</option>
                        <option value="Measurable">Measurable</option>
                    </select>
                </div>
                <div id="resultoption" style="display: none" class="col">
                    <div class="table-responsive">

                        <table class="table" id="dynamicoptions">
                            {{-- <tr>
                                <th>Option</th>
                                <th>Action</th>
                            </tr> --}}
                            <tr>
                                <td><input type="text" name="results[]" placeholder="Enter possible result"
                                        class="form-control" />
                                </td>
                                <td><button type="button" name="add" id="dynamic-results"
                                        class="btn btn-outline-primary">Add</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="uomdefault" style="display: none" class="col">
                    <div class="input-group form-group">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                {{ __('Unit of Measure') }}
                            </span>
                        </div>
                        <input type="text" class="form-control" name="uom" id="uom"
                            @if (isset($test)) value="{{ $test->uom }}" @endif>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="row mt-3">
    <div>
        <h6>
            {{ __('Attach Possible Sample/Specimen Types') }}
        </h6>
    </div>

    @if (isset($test))
        <div class="row ">
            <div class="col table-responsive">
                <table class="table">
                    <tr>
                        <th>Sample type</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($testsampletypes as $item)
                        <tr>
                            <td>{{ $item->sample }}</td>
                            <td> <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip"
                                    wire:click="deletesample({{ $item->id }})" title="Delete"><i
                                        class="bi bi-trash-fill"></i></a> </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col">
                @error('sample')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                <select class="form-control" wire:model="sample" name="sample"
                    data-placeholder="Choose sample types">
                    <option value="">Select</option>
                    @if (count($sampletypes) > 0)
                        @foreach ($sampletypes as $item)
                            <option value="{{ $item->sample_name }}">{{ $item->sample_name }}</option>
                        @endforeach
                    @endif
                </select>
                <button type="button" name="add" id="sample" wire:click.prevent="storeSampleType()"
                    class="btn btn-outline-primary mt-3 float-right text-end">Add</button>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col">
                <select class="select2 m-b-10 select2-multiple form-control" name="sample_type[]" style="width: 100%"
                    multiple="multiple" data-placeholder="Choose sample types">
                    @if (count($sampletypes) > 0)
                        @foreach ($sampletypes as $item)
                            <option value="{{ $item->sample_name }}">{{ $item->sample_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

        </div>
    @endif
</div>

<div class="row mt-3">
    <div>
        <h6>
            {{ __('Attach Test comments') }}
        </h6>
    </div>
    <div class="col-lg-12">
        @if (isset($test))
            <div class="table-responsive">

                <table class="table">
                    {{-- <tr>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr> --}}
                    @foreach ($testcomments as $item)
                        <tr>
                            <td>{{ $item->comment }}</td>
                            <td> <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip"
                                    wire:click="deleteComment({{ $item->id }})" title="Delete"><i
                                        class="bi bi-trash-fill"></i></a> </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <input type="text" name="comment" wire:model="comment"
                                placeholder="Enter new comment" class="form-control" />
                            @error('comment')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </td>
                        <td><button type="button" name="" id="dynamic-comment"
                                wire:click.prevent="storecomment()" class="btn btn-outline-primary">Add</button></td>
                    </tr>
                </table>
            </div>
        @else
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table" id="dynamicAddRemove">
                        {{-- <tr>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr> --}}
                        <tr>
                            <td><input type="text" name="comments[]" placeholder="Enter comment"
                                    class="form-control" />
                            </td>
                            <td><button type="button" name="add" id="dynamic-ar"
                                    class="btn btn-outline-primary">Add</button></td>
                        </tr>
                    </table>
                </div>

            </div>
        @endif
    </div>
</div>


@push('scripts')
    <script type="text/javascript">
        var i = 0;
        $("#dynamic-ar").click(function() {
            ++i;
            $("#dynamicAddRemove").append(
                '<tr><td><input type="text" name="comments[]" placeholder="Enter comment" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
        });
        $(document).on('click', '.remove-input-field', function() {
            $(this).parents('tr').remove();
        });
    </script>

    <script type="text/javascript">
        var k = 0;
        $("#dynamic-results").click(function() {
            ++k;
            $("#dynamicoptions").append(
                '<tr><td><input type="text" name="results[]" placeholder="Enter another possible result" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-result">Delete</button></td></tr>'
            );
        });
        $(document).on('click', '.remove-input-result', function() {
            $(this).parents('tr').remove();
        });
    </script>
    <script type="text/javascript">
        function resultstype() {
            var x = document.getElementById('resultype').value;

            if (x == 'Absolute') {
                // document.getElementByName("results[]").setAttribute("required", "required");
                // document.getElementByName("uom").removeAttribute("required");

                document.getElementById("resultoption").style.display = "block";
                document.getElementById("uomdefault").style.display = "none";
            } else if (x == 'Measurable') {
                // document.getElementByName("uom").setAttribute("required", "required");
                // document.getElementByName("results[]").removeAttribute("readonly");

                document.getElementById("resultoption").style.display = "none";
                document.getElementById("uomdefault").style.display = "block";
            } else {
                document.getElementById("resultoption").style.display = "none";
                document.getElementById("uomdefault").style.display = "none";
            }
        }
    </script>
@endpush
