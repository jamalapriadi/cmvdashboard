<table class="table table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Category ID</th>
            <th>Sector Name</th>
            <th>Category Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=0;?>
        @foreach($category as $row)
        <?php $no++;?>
        <tr>
            <td>{{$no}}</td>
            <td>{{$row->category_id}}</td>
            <td>{{$row->sector->sector_name}}</td>
            <td>{{$row->category_name}}</td>
            <td>
                <div class='btn-group' data-toggle='buttons'>
                <a href='#' class='btn btn-sm btn-warning editcategory' kode="{{$row->category_id}}" title='Edit'><i class='icon-pencil4'></i></a>
                <a href='#' class='btn btn-sm btn-danger hapuscategory' kode="{{$row->category_id}}" title='Hapus'><i class='icon-trash'></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<hr>
{{$category->links()}}