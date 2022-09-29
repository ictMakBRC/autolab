@extends('layouts.app')

@section('title')
{{__('Test consumptions')}}
@endsection

@section('css')
<link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
@endsection

@section('breadcrumb')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">
          <i class="fa fa-flask"></i>
          {{__('Test consumptions')}}
        </h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item "><a href="{{route('admin.tests.index')}}">{{__('Tests')}}</a></li>
          <li class="breadcrumb-item active">{{__('Test consumptions')}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">{{__('Test consumptions')}}</h3>
  </div>
  <form method="POST" action="{{route('admin.tests.consumptions.submit')}}">
    <!-- /.card-header -->
    <div class="card-body">
      @csrf
      @php
      $consumption_count=0;
      @endphp

      @foreach($tests as $test)
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="card-title">
                {{$test['name']}}
              </h5>
              <button type="button" class="btn btn-primary float-right add_consumption" test_id="{{$test['id']}}">
                <i class="fa fa-plus"></i> {{__('Add')}}
              </button>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>{{__('Product')}}</th>
                    <th width="100px">{{__('Quantity')}}</th>
                    <th width="10px"></th>
                  </tr>
                </thead>
                <tbody class="test_consumptions">
                  @foreach($test['consumptions'] as $consumption)
                  @php
                  $consumption_count++;
                  @endphp
                  <tr class="consumption_row">
                    <td>
                      <select class="form-control product_id" id="consumption_product_{{$consumption_count}}"
                        name="consumption[{{$test['id']}}][{{$consumption_count}}][product_id]" required>
                        <option value="{{$consumption['product_id']}}" selected>{{$consumption['product']['name']}}
                        </option>
                      </select>
                    </td>
                    <td>
                      <input type="number" class="form-control"
                        name="consumption[{{$test['id']}}][{{$consumption_count}}][quantity]"
                        placeholder="{{__('Quantity')}}" value="{{$consumption['quantity']}}" required>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-danger delete_consumption">
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @endforeach

      <script>
        var consumption_count={{$consumption_count}}
      </script>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i> {{__('Save')}}</button>
    </div>
  </form>

</div>
@endsection
@section('scripts')
<script src="{{url('js/admin/tests.js')}}"></script>
@endsection