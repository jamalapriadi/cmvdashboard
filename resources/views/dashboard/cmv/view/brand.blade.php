<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Brand ID</th>
                <th>Brand Name</th>
                <th>Category</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $no=0;?>
            @foreach($brand as $row)
                <?php $no++;?>
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$row->brand_id}}</td>
                    <td>{{$row->brand_name}}</td>
                    <td>{{$row->category->category_name}}</td>
                    <td>
                        <div class='btn-group'>
                            <a href='#' class='btn btn-sm btn-warning editbrand' kode="{{$row->brand_id}}" title='Role'><i class='icon-pencil4'></i></a>
                            <a href='#' class='btn btn-sm btn-danger hapusbrand' kode="{{$row->brand_id}}" title='Hapus'><i class='icon-trash'></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<hr>

{{$brand->links('vendor/pagination/bootstrap-4')}}