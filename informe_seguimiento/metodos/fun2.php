<script>
    $.ajax({
        url: "../metodos/comprobar_permisos.php",
        method: "GET",
        dataType: "json",
        success: function(data) {

            console.log("ID de Permiso:", data[1].id_permiso);
            console.log("Existe:", data[1].existe);

            var miCheckbox1 = document.getElementById('check_phicargo');
            if (data[0].id_permiso == 121 && data[0].existe == false) {
                miCheckbox1.checked = false;
                miCheckbox1.disabled = true;
            } else {
                miCheckbox1.checked = true;
                miCheckbox1.disabled = false;
            }

            var miCheckbox2 = document.getElementById('check_servi');
            if (data[1].id_permiso == 122 && data[1].existe == false) {
                miCheckbox2.checked = false;
                miCheckbox2.disabled = true;
            } else {
                miCheckbox2.checked = true;
                miCheckbox2.disabled = false;
            }

            var miCheckbox3 = document.getElementById('check_tank');
            if (data[2].id_permiso == 123 && data[2].existe == false) {
                miCheckbox3.checked = false;
                miCheckbox3.disabled = true;
            } else {
                miCheckbox3.checked = true;
                miCheckbox3.disabled = false;
            }

            var miCheckbox4 = document.getElementById('check_ometra');
            if (data[3].id_permiso == 124 && data[3].existe == false) {
                miCheckbox4.checked = false;
                miCheckbox4.disabled = true;
            } else {
                miCheckbox4.checked = true;
                miCheckbox4.disabled = false;
            }

            var miCheckbox5 = document.getElementById('check_transportes_belchez');
            if (data[4].id_permiso == 125 && data[4].existe == false) {
                miCheckbox5.checked = false;
                miCheckbox5.disabled = true;
            } else {
                miCheckbox5.checked = true;
                miCheckbox5.disabled = false;
            }

            consultarViajes();
        }
    });
</script>