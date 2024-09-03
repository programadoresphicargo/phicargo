<script>
    flatpickr("#rangoInput", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "es",
        onClose: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const fechaInicio = selectedDates[0].toISOString().slice(0, 10);
                const fechaFin = selectedDates[1].toISOString().slice(0, 10);
                inicio = fechaInicio;
                fin = fechaFin;
                sendResultsToServer();
            }
        }
    });

    // Array para almacenar los resultados de búsqueda
    var searchResults = [];

    function search() {
        var searchText = document.getElementById("searchText").value;
        var searchField = document.getElementById("searchField").value;

        // Realizar la búsqueda y guardar el resultado en el array
        var result = {
            searchText: searchText,
            searchField: searchField
        };
        searchResults.push(result);

        // Mostrar los resultados en pantalla
        displayResults();
        sendResultsToServer();
    }

    function removeResult(index) {
        if (index >= 0 && index < searchResults.length) {
            searchResults.splice(index, 1);
            displayResults();
            sendResultsToServer();
        } else {
            console.error("Índice fuera de rango");
        }
    }

    function displayResults() {
        var resultsDiv = document.getElementById("results");
        resultsDiv.innerHTML = "";

        for (var i = 0; i < searchResults.length; i++) {
            var result = searchResults[i];
            var resultElement = document.createElement("div");
            resultElement.textContent = "Búsqueda: " + result.searchText + " en " + result.searchField;
            console.log(searchResults);
            // Agregar un botón para eliminar este resultado
            var removeButton = document.createElement("button");
            removeButton.textContent = "Eliminar";
            removeButton.onclick = (function(index) {
                return function() {
                    removeResult(index);
                }
            })(i);

            resultElement.appendChild(removeButton);
            resultsDiv.appendChild(resultElement);
        }
    }

    function sendResultsToServer() {
        $.ajax({
            type: 'POST',
            url: 'tabla.php',
            data: {
                searchResults: JSON.stringify(searchResults),
                'inicio': inicio,
                'fin': fin
            },
            success: function(response) {
                console.log('Los datos se enviaron con éxito a PHP.');
                $("#tabla").html(response);
            },
            error: function(error) {
                console.error('Hubo un error al enviar los datos a PHP.');
            }
        });
    }
</script>