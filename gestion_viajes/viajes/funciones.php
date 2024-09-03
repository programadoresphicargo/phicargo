<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('get_viaje.php')
            .then(response => response.json())
            .then(data => {
                // Suponiendo que los datos sean un array y quieras el primer objeto
                const primerDato = data[0];
                document.getElementById('name').value = primerDato.name;
                document.getElementById('id').value = primerDato.id;
            })
            .catch(error => console.error('Error:', error));
    });
</script>