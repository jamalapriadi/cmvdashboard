<table class="table table-striped table-bordered" id="tabelBrand">
    <thead>
        <tr>
            <th rowspan="3">No.</th>
            <th rowspan="3">Brand Name</th>
            @foreach($data['demography'] as $row)
                <th colspan="{{count($row['subdemo']) * 2}}" class="text-center">{{$row['demo_name']}}</th>
            @endforeach
        </tr>
        <tr>
            @foreach($data['demography'] as $k)
                @foreach($k['subdemo'] as $s)
                    <th colspan="2">{{$s['subdemo_name']}}</th>
                @endforeach
            @endforeach
        </tr>
        <tr>
            @foreach($data['demography'] as $k)
                @foreach($k['subdemo'] as $s)
                    <th>Total Thousand</th>
                    <th>Total Vert</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1.</td>
            <td>{{$data['brand_name']}}</td>
            @foreach($data['demography'] as $k)
                @foreach($k['subdemo'] as $s)
                    <td>{{$s['variabel']['totals_thousand']}}</td>
                    <td>{{$s['variabel']['totals_ver']}}</td>
                @endforeach
            @endforeach
        </tr>
    </tbody>
</table>