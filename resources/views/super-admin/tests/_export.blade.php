<table>
    <thead>
        <tr>
            <th align="center" width="10">Category</th>
            <th align="center" width="20">Test name</th>
            <th align="center" width="20">Shortcut</th>
            <th align="center" width="20">Component name</th>
            <th align="center" width="20">Unit</th>
            <th align="center" width="20">Gender</th>
            <th align="center" width="20">Age from days</th>
            <th align="center" width="20">Age to days</th>
            <th align="center" width="20">Normal from</th>
            <th align="center" width="20">Normal to</th>
            <th align="center" width="20">Critical low from</th>
            <th align="center" width="20">Critical high from</th>
            <th align="center" width="100">Reference range</th>
            <th align="center" width="10">Price</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tests as $test)
        @foreach($test['components'] as $component)
            @if(count($component['reference_ranges']))
                @foreach($component['reference_ranges'] as $reference_range)
                <tr>
                    <td>
                        {{$test['category']['name']}}
                    </td>
                    <td>
                        {{$test['name']}}
                    </td>
                    <td>
                        {{$test['shortcut']}}
                    </td>
                    <td>
                        {{$component['name']}}
                    </td>
                    <td>
                        {{$component['unit']}}
                    </td>
                    <td>
                        {{$reference_range['gender']}}
                    </td>
                    <td>
                        {{$reference_range['age_from_days']}}
                    </td>
                    <td>
                        {{$reference_range['age_to_days']}}
                    </td>
                    <td>
                        {{$reference_range['normal_from']}}
                    </td>
                    <td>
                        {{$reference_range['normal_to']}}
                    </td>
                    <td>
                        {{$reference_range['critical_low_from']}}
                    </td>
                    <td>
                        {{$reference_range['critical_high_from']}}
                    </td>
                    <td>
                        {{$component['reference_range']}}
                    </td>
                    <td>
                        {{$test['price']}}
                    </td>
                </tr>
                @endforeach
            @else 
            <tr>
                <td>
                    {{$test['category']['name']}}
                </td>
                <td>
                    {{$test['name']}}
                </td>
                <td>
                    {{$test['shortcut']}}
                </td>
                <td>
                    {{$component['name']}}
                </td>
                <td>
                    {{$component['unit']}}
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                  
                </td>
                <td>
                    
                </td>
                <td>
                   
                </td>
                <td>
                    
                </td>
                <td>
                         
                </td>
                <td>
                         
                </td>
                <td>
                    {{$test['price']}}
                </td>
            </tr>
            @endif
        @endforeach
    @endforeach
    </tbody>
</table>