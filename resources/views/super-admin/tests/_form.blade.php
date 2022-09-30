<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">{{__('Category')}}</label>
            <select name="category_id" class="select2 form-control custom-select" style="width: 100%; height:40px; id="category" required>
                @if(isset($test))
                    <option value="{{$test['category_id']}}" selected>{{$test->category_name}}</option>
                @else                
                <option value="">Select</option>
                @endif
               
                @foreach ($categories as $item)
                    <option value="{{$item->id}}">{{$item->category_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
      <div class="form-group">
        <label for="name">{{__('Name')}}</label>
        <input type="text" class="form-control" name="name" id="name" @if(isset($test)) value="{{$test->name}}" @endif required>
      </div> 
    </div>
    <div class="col-lg-3">
      <div class="form-group">
        <label for="shortcut">{{__('Short code')}}</label>
        <input type="text" class="form-control" name="shortcut" id="shortcut" @if(isset($test)) value="{{$test->shortcut}}" @endif required>
      </div>
    </div> 
    <div class="col-lg-3">
       <div class="form-group">
            <label for="price">{{__('Price')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" step="any" class="form-control" name="price" min="0" id="price" @if(isset($test)) value="{{$test->price}}" @endif required>
                <div class="input-group-append">
                <span class="input-group-text">
                    UGX
                </span>
                </div>
            </div>
       </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="reference_range_min">Min-Reference range</label>
            <input type="number" step="any" name="reference_range_min" @if(isset($test)) value="{{$test->reference_range_min}}"@endif class="form-control" id="reference_range_min">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="reference_range_max">Max-Reference range</label>
            <input type="number" step="any" name="reference_range_max" @if(isset($test)) value="{{$test->reference_range_max}}"@endif class="form-control" id="reference_range_max">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
             <label for="precautions">{{__('Precautions')}}</label>
             <textarea name="precautions" id="precautions" rows="3" class="form-control" placeholder="{{__('Precautions')}}">@if(isset($test)){{$test['precautions']}}@endif</textarea>
        </div>
    </div>
</div>
<br>
 <div class="row">
    <div class="card card-primary">
        <div class="card-header">
            <h5 class="card-title">
                {{__('Results')}}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <select name="type" onchange="reslutstype()" id="resultype" class="form-select" style="width: 100%; height:36px;" required>
                        <option value="">Select</option>
                        <option value="text">Text</option>
                        <option value="file">File</option>
                        <option value="Absolute">Absolute</option>
                        <option value="Measurable">Measurable</option>
                    </select>
                </div>
                <div id="resultoption" style="display: none" class="col">
                    <div class="table-responsive">
                       
                        <table class="table table-bordered" id="dynamicoptions">
                            <tr>
                                <th>Option</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="results[]" placeholder="Enter possible result" class="form-control" />
                                </td>
                                <td><button type="button" name="add" id="dynamic-results" class="btn btn-outline-primary">Add</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="uomdefault" style="display: none" class="col">
                    <div class="form-group">
                        <label for="uom">{{__('Unit of Messure')}}</label>
                        <input type="text" class="form-control" name="uom" id="uom" @if(isset($test)) value="{{$test->uom}}" @endif>
                      </div>
                </div>
            </div>
           
        </div>
    </div>
 </div>
 <div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{__('Result sample types')}}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <select class="select2 m-b-10 select2-multiple form-control" name="sample_type[]" style="width: 100%" multiple="multiple" data-placeholder="Choose sample types">
                                @if(count($sampletypes)>0)
                                    @foreach($sampletypes as $item)
                                        <option value="{{ $item->sample_name}}">{{ $item->sample_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                    
                    </div>
             
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{__('Result comments')}}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                       
                        <table class="table table-bordered" id="dynamicAddRemove">
                            <tr>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="comments[]" placeholder="Enter comment" class="form-control" />
                                </td>
                                <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add</button></td>
                            </tr>
                        </table>
                    </div>
             
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="comments[]" placeholder="Enter comment" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>

<script type="text/javascript">
    var k = 0;
  $("#dynamic-results").click(function () {
      ++k;
      $("#dynamicoptions").append('<tr><td><input type="text" name="results[]" placeholder="Enter another possible result" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-result">Delete</button></td></tr>'
          );
  });
  $(document).on('click', '.remove-input-result', function () {
      $(this).parents('tr').remove();
  });
</script>
<script type="text/javascript">
    function reslutstype()
    {
        var x = document.getElementById('resultype').value;

        if(x  == 'Absolute')
        {
            // document.getElementByName("results[]").setAttribute("required", "required");
            // document.getElementByName("uom").removeAttribute("required");

            document.getElementById("resultoption").style.display = "block";
            document.getElementById("uomdefault").style.display = "none";
        }
        else if(x  == 'Measurable')
        {
            // document.getElementByName("uom").setAttribute("required", "required");
            // document.getElementByName("results[]").removeAttribute("readonly");

            document.getElementById("resultoption").style.display = "none";
            document.getElementById("uomdefault").style.display = "block";
        }
        else
        {
            document.getElementById("resultoption").style.display = "none";
            document.getElementById("uomdefault").style.display = "none";
        }
    }
</script>
@endpush



