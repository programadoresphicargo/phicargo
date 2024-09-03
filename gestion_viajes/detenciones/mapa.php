<?php
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];
?>
<iframe width="600" height="450" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=<?php echo $latitud ?>,<?php echo $longitud ?>&hl=es&z=14&output=embed">
</iframe>