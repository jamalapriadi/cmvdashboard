<div class="table-responsive">
    <table class="table table-stripe">
        <thead>
            <tr>
                <th>No.</th>
                <th width="20%">Brand</th>
                <th>Subdemography Name</th>
                <th>Quartal</th>
                <th>Totals(000s)</th>
                <th>Totals Vert%</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=0;?>
            @foreach($demo as $row)
                <?php $no++;?>
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$row->brand->brand_name}}</td>
                    <td>{{$row->subdemo->subdemo_name}}</td>
                    <td>{{$row->quartal}}</td>
                    <td>{{$row->totals_thousand}}</td>
                    <td>{{$row->totals_ver}}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-warning editdemo" kode="{{$row->id}}"><i class="icon-pencil4"></i></a>
                            <a class="btn btn-sm btn-danger hapusdemo" kode="{{$row->id}}"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br>
{{$demo->links()}}