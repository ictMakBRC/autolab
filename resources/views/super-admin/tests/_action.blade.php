@can('edit_test')
    @if($test['parent_id'])
        <a href="{{route('admin.tests.edit',$test['parent_id'])}}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit"></i>
        </a>
    @else 
        <a href="{{route('admin.tests.edit',$test['id'])}}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit"></i>
        </a>
    @endif
@endcan

@can('edit_test')
    @if($test['parent_id'])
        <a href="{{route('admin.tests.consumptions',$test['parent_id'])}}" class="btn btn-warning btn-sm">
            <i class="fa fa-tools"></i>
        </a>
    @else 
        <a href="{{route('admin.tests.consumptions',$test['id'])}}" class="btn btn-warning btn-sm">
            <i class="fa fa-tools"></i>
        </a>
    @endif
@endcan


@can('delete_test')
    <form method="POST" action="{{route('admin.tests.destroy',$test['id'])}}" class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_test">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endcan
