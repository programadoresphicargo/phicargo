<?php
require_once('getMovedores.php');

$ids = json_decode($json, true);
?>

<div class="table-responsive">
    <table class="js-datatable table table-thead-bordered table-align-middle table-hover" id="tabla-datos">
        <thead class="thead-light">
            <tr class="text-center">
                <th>MOVEDOR</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ids as $item) : ?>
                <tr onclick="ir('<?php echo $item['id']; ?>')">
                    <td>
                        <div class="ms-3"><span class="d-block h5 text-inherit mb-0"><?php echo $item['name']; ?></span></div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function ir(id) {
        window.location.href = "../maniobras_realizadas/index.php?id=" + id;
    };
</script>