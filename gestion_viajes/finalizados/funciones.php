<script>
  var id_viaje_universal = '';
  var placas_universal = '';
  var modo_universal = '';
  var consulta_universal = 'finalizado';
  var selectedOptions = [];
  var inicio;
  var fin;

  $.ajax({
    type: 'POST',
    url: 'tabla.php',
    success: function(response) {
      console.log('Los datos se enviaron con éxito a PHP.');
      $("#tabla").html(response);
      $('#loadingCard').hide();
    },
    error: function(error) {
      console.error('Hubo un error al enviar los datos a PHP.');
    }
  });
</script>