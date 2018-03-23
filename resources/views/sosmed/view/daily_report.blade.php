<table class="table tabl-striped" id="tabeldaily">
    <thead>
        <tr>
            <th>No.</th>
            <th>Unit name</th>
            <th>Type Sosmed</th>
            <th>Account Name</th>
            <th>Tanggal</th>
            <th>Follower</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=0;?>
        @foreach($daily as $row)
            <?php $no++;?>
            <tr>
                <td>{{$no}}</td>
                <td>{{$row->unit_name}}</td>
                <td>{{$row->type_sosmed}}</td>
                <td>{{$row->unit_sosmed_name}}</td>
                <td>{{$row->tanggal}}</td>
                <td>{{number_format($row->follower)}}</td>
                <td>
                    <div class='btn-group' data-toggle='buttons'>
                        @if(auth()->user()->can('Edit Daily Report'))
                            <a href='#' class='btn btn-sm btn-warning editfollower' kode='{{$row->idfollower}}' title='Edit'><i class='fa fa-edit'></i></a>
                        @endif
                        
                        @if(auth()->user()->can('Delete Daily Report'))
                            <a href='#' class='btn btn-sm btn-danger hapusfollower' kode='{{$row->idfollower}}' title='Hapus'><i class='fa fa-trash'></i></a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>