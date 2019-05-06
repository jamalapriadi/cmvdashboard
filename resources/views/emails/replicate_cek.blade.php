<p>
    Hay Gays,
</p>

<p> Replicate Error Nih </p>
<p>{!! $errornya !!}</p>

<br><br>
<h4 style="color:red">Untuk Memperbaikinya, ikuti cara berikut:</h4>
<ol>
    <li>Buka Mysql di server public</li> 
    <li>Ketik : <strong>SHOW SLAVE STATUS \G</strong></li>
    <li>Lihat dulu errornya kenapa</li>
    <li>Ketik : <strong>STOP SLAVE;</strong> (untuk menstop service replicate)</li>
    <li>Jika sudah Ketik : <strong>SET GLOBAL SQL_SLAVE_SKIP_COUNTER = 1;</strong></li>
    <li>Kemudian jalankan service replicate nya : <strong>START SLAVE;</strong></li>
    <li>Cek Lagi statusnya, apakah masih ada error atau ngga : <strong>SHOW SLAVE STATUS \G</strong></li> 
</ol>

<p>SIPPP MANTAP (Y) </p>