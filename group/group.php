<script>
    const salesListContainer = document.getElementById('contenido');

    // Función para agrupar los datos
    function groupData(data, groupByFields) {
        const groupedData = {};

        data.forEach(item => {
            let currentLevel = groupedData;
            groupByFields.forEach((field, index) => {
                const value = item[field];
                if (!currentLevel[value]) {
                    currentLevel[value] = index === groupByFields.length - 1 ? [] : {};
                }
                currentLevel = currentLevel[value];
            });
            currentLevel.push(item);
        });

        return groupedData;
    }

    // Campos por los que se agruparán los datos

    // Función para limpiar el texto y eliminar caracteres no deseados
    function cleanText(text) {
        return text.replace(/[^\w\s]/gi, '').replace(/\s+/g, '-');
    }

    // Función para renderizar el grupo
    // Función para renderizar el grupo
    function renderGroup(groupData, level, parentKey = '') {
        salesListContainer.innerHTML = '';
        console.log(groupData);

        // Si no hay campos para agrupar
        if (Array.isArray(groupData)) {
            // Crear la tabla aquí
            const salesTable = document.createElement('table');
            salesTable.classList.add('table', 'table-striped', 'table-bordered');
            salesTable.innerHTML = `
        <thead>
        <tr>
        ${columns.map(column => `
            <th>${column[0]}</th>
        `).join('')}
    </tr>
        </thead>
        <tbody>
                    ${groupData.map(sale => `
                         <tr>
                               ${columns.map(columna => `
                         <td>${sale[columna[1]]}</td>
                    `).join('')}
                      </tr>
                   `).join('')}
                 </tbody>`;
            return salesTable;
        } else {
            // Manejar el caso en el que groupData no es una matriz o está vacío
        }
        // Si hay campos para agrupar
        const groupAccordion = document.createElement('div');
        groupAccordion.classList.add('accordion');

        for (const key in groupData) {
            if (groupData.hasOwnProperty(key)) {
                const groupContent = groupData[key];
                const uniqueKey = parentKey ? `${parentKey}-${key}-${level}` : `${key}-${level}`; // Sufijo único
                const groupCard = document.createElement('div');
                groupCard.classList.add('card');

                const groupHeader = document.createElement('div');
                groupHeader.classList.add('card-header');
                groupHeader.setAttribute('id', `heading-${cleanText(uniqueKey)}`);
                const button = document.createElement('button');
                button.classList.add('btn', 'btn-link');
                button.setAttribute('type', 'button');
                button.setAttribute('data-toggle', 'collapse');
                button.setAttribute('data-target', `#collapse-${cleanText(uniqueKey)}`);
                button.setAttribute('aria-expanded', 'false');
                button.setAttribute('aria-controls', `collapse-${cleanText(uniqueKey)}`);
                button.textContent = key;
                groupHeader.appendChild(button);
                groupCard.appendChild(groupHeader);

                const groupCollapse = document.createElement('div');
                groupCollapse.id = `collapse-${cleanText(uniqueKey)}`;
                groupCollapse.classList.add('collapse');
                groupCollapse.setAttribute('aria-labelledby', `heading-${cleanText(uniqueKey)}`);
                const groupCardBody = document.createElement('div');
                groupCardBody.classList.add('card-body');

                if (Array.isArray(groupContent)) {
                    const salesTable = document.createElement('table');
                    salesTable.classList.add('table', 'table-striped', 'table-bordered');
                    salesTable.innerHTML = `
                    <thead>
                    <tr>
        ${columns.map(column => `
            <th>${column[0]}</th>
        `).join('')}
    </tr>
                    </thead>
                    <tbody>
                    ${groupContent.map(sale => `
                         <tr>
                               ${columns.map(columna => `
                         <td>${sale[columna[1]]}</td>
                    `).join('')}
                      </tr>
                   `).join('')}
                 </tbody>`;
                    groupCardBody.appendChild(salesTable);
                } else {
                    const subGroup = renderGroup(groupContent, level + 1, uniqueKey); // Pasamos el uniqueKey como parentKey
                    groupCardBody.appendChild(subGroup);
                }

                groupCollapse.appendChild(groupCardBody);
                groupCard.appendChild(groupCollapse);
                groupAccordion.appendChild(groupCard);
            }
        }

        return groupAccordion;
    }

    var datosArray = [];

    function sendDataToServer(datosArray) {
        console.log(datosArray);
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                'searchResults': datosArray,
            },
            success: function(response) {
                console.log('Los datos se enviaron con éxito a PHP.');
                actualizarLista();
                console.log(response);
                salesData = JSON.parse(response);

                if (groupByFields.length === 0) {
                    const salesList = renderGroup(salesData, 0);
                    salesListContainer.appendChild(salesList);
                } else {
                    const groupedSalesData = groupData(salesData, groupByFields);
                    const salesList = renderGroup(groupedSalesData, 0);
                    salesListContainer.appendChild(salesList);
                }

            },
            error: function(error) {
                console.error('Hubo un error al enviar los datos a PHP.');
            }
        });
    }
</script>
<script>
    function cargar_agrupar(columnas2) {
        // Referencia al contenedor del menú desplegable
        const dropdownMenu = document.getElementById('dropdownMenu');

        // Array para almacenar las opciones seleccionadas
        let opcionesSeleccionadas = [];

        // Generar opciones del menú desplegable
        columnas2.forEach((columna, index) => {
            const nombreCheckbox = columna[0];
            const valorColumna = columna[1];
            const checkboxId = `checkbox_${index}`;
            const checkboxHTML = `
        <label class="dropdown-item">
            <input type="checkbox" id="${checkboxId}" value="${valorColumna}"> ${nombreCheckbox}
        </label>
    `;
            dropdownMenu.innerHTML += checkboxHTML;
        });

        // Event listener para los cambios en el menú desplegable
        dropdownMenu.addEventListener('change', function(event) {
            const checkbox = event.target;
            const valorColumna = checkbox.value;

            if (checkbox.checked) {
                // Si se selecciona, agregar al array si no está presente
                if (!opcionesSeleccionadas.includes(valorColumna)) {
                    opcionesSeleccionadas.push(valorColumna);
                }
            } else {
                // Si se deselecciona, eliminar del array
                opcionesSeleccionadas = opcionesSeleccionadas.filter(opcion => opcion !== valorColumna);
            }

            groupByFields = opcionesSeleccionadas;
            console.log(groupByFields);
            if (groupByFields.length === 0) {
                const salesList = renderGroup(salesData, 0);
                salesListContainer.appendChild(salesList);
            } else {
                const groupedSalesData = groupData(salesData, groupByFields);
                const salesList = renderGroup(groupedSalesData, 0);
                salesListContainer.appendChild(salesList);
            }
        });
    }


    function actualizarLista() {
        var dropdownList = document.getElementById('dropdown-list');
        dropdownList.innerHTML = ''; // Limpiar la lista antes de actualizar

        datosArray.forEach(function(item, index) {
            var link = document.createElement('a');
            link.classList.add('btn', 'btn-soft-dark', 'btn-xs', 'rounded-pill');
            link.innerHTML = item.texto + '   <i class="bi bi-x-circle"></i>';
            link.addEventListener('click', function() {
                datosArray.splice(index, 1); // Elimina el elemento del array
                actualizarLista(); // Actualiza la lista después de eliminar
                sendDataToServer(datosArray);
            });
            dropdownList.appendChild(link);
        });
    }
</script>

<script>
    function crearElementos(columns) {
        var camposBusqueda = document.getElementById('campos_busqueda');

        columns.forEach(function(column) {
            var link = document.createElement('a');
            link.classList.add('dropdown-item');
            link.innerHTML = '<span>Buscar en <strong>' + column[0] + '</strong></span>';

            link.addEventListener('click', function() {

                const inputFullName = document.getElementById('fullName');
                const texto = inputFullName.value;
                const datos = {
                    texto: texto,
                    opcion: column[1]
                };
                datosArray.push(datos);
                $("#fullName").val('').change();
                sendDataToServer(datosArray);
                refreshDropdownItems();

            });

            camposBusqueda.appendChild(link);
        });
    }
</script>