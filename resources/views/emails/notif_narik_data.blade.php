@if($status=="Sukses")
    Yey, data sosmed tanggal {{ date('d-m-Y', strtotime($sekarang)) }} berhasil ditarik
@elseif($status=="Gagal")
    Duhhh, data sosmed tanggal {{ date('d-m-Y', strtotime($sekarang)) }} gagal ditarik
@else 
    Tidak ada status
@endif