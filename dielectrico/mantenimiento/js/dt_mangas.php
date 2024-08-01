<script>
$(document).ready(function() {
    var id_orden = <?php echo $id_orden; ?>;
    $("#dataTable").DataTable({

        paging: false,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
        },
        "ajax": {
            "url": "obtener_items.php",
            "method": "POST",
            "data": {
                id_orden: id_orden
            }
        },
        columns: [{
            data: null,
            render: function(data, type, row) {
                return '<button class="btn btn-primary btn-sm2 editar-btn" data-id="' + row
                    .id + '">Editar</button>' +
                    '  <button class="btn btn-danger btn-sm2" onclick="borrar(' + row.id +
                    ')">Borrar</button>' +
                    '<label hidden>' + row.id + '</label>';
            }
        }, {
            "data": "n_informe"
        }, {
            "data": null,
            render: function(data, type, row) {
                if (row.serie_manga === null) {
                    return row.serie_edit;
                } else {
                    return row.serie_manga;
                }
            }
        }, {
            "data": "clase"
        }, {
            "data": "marca"
        }, {
            data: null,
            render: function(data, type, row) {
                var long = row
                    .longitud; // Suponiendo que "id" es la propiedad que contiene el valor de id_orden
                var clase = row
                    .clase; // Suponiendo que "nro_orden" es la propiedad que contiene el valor de nro_orden
                var otro = row.otro;
                if ((long == "280" && clase == "Clase 00") || (long == "280" && clase ==
                        "Clase 0")) {
                    var corriente = 8;
                    return corriente;
                }
                if ((long == "360" && clase == "Clase 00") || (long == "360" && clase ==
                        "Clase 0")) {
                    var corriente = 12;
                    return corriente;
                }
                if ((long == "360" && clase == "Clase 1") || (long == "410" && clase ==
                        "Clase 0")) {
                    var corriente = 14;
                    return corriente;
                }
                if ((long == "360" && clase == "Clase 2") || (long == "410" && clase ==
                        "Clase 1")) {
                    var corriente = 16;
                    return corriente;
                }
                if ((long == "360" && clase == "Clase 3") || (long == "410" && clase ==
                        "Clase 2")) {
                    var corriente = 18;
                    return corriente;
                }
                if ((long == "410" && clase == "Clase 3") || (long == "460" && clase ==
                        "Clase 2")) {
                    var corriente = 20;
                    return corriente;
                }
                if ((long == "410" && clase == "Clase 4") || (long == "4460" && clase ==
                        "Clase 3")) {
                    var corriente = 22;
                    return corriente;
                }
                if ((long == "460" && clase == "Clase 4")) {
                    var corriente = 24;
                    return corriente;
                }
                if (otro == "Inflado") {
                    var corriente = "Inflado";
                    return corriente;
                } else {
                    return "Falta dato de longitud";
                }

            }
        }, {
            data: null,
            render: function(data, type, row) {
                var valor_izq = row
                    .valor_izq; // Suponiendo que "id" es la propiedad que contiene el valor de id_orden
                var valor_der = row
                    .valor_der; // Suponiendo que "nro_orden" es la propiedad que contiene el valor de nro_orden
                var otro = row.otro;
                if (otro == "Inflado") {
                    return otro;
                } else {
                    var combinedValue = valor_izq + '-' + valor_der;
                    return combinedValue;
                }
            }
        }, {
            "data": null,
            render: function(data, type, row) {
                if (row.resultado == "Pendiente") {
                    return "<span class='alert-warning'>Pendiente</span>"
                }
                if (row.resultado == "Apto") {
                    return "<span class='alert-success'>Apto</span>"
                }
                if (row.resultado == "No Apto") {
                    return "<span class='alert-danger'>No Apto</span>"
                }
            }
        }, {
            "data": null,
            render: function(data, type, row) {
                return '<button class="btn btn-primary btn-sm2 obs-btn" data-id="' + row
                    .id + '">Observaciones</button>';
            }
        }],
        order: [
            [0, 'asc']
        ]

    });
});
</script>

<!-- para el modal editar item -->
<script>
$(document).ready(function() {
    // ...

    // Abrir modal al hacer clic en el botón de editar
    $('#dataTable').on('click', '.editar-btn', function() {
        var id = $(this).data('id');
        var rowData = $('#dataTable').DataTable().row($(this).closest('tr')).data();

        if (rowData.serie_manga === null) {
            var series = rowData.serie_edit
        } else {
            var series = rowData.serie_manga;
        }
        // Llena los campos del formulario con los valores de la fila
        $('#id_item').val(id);
        $('#n_informe').val(rowData.n_informe);
        $('#serie').val(series);
        $('#clase').val(rowData.clase);
        $('#marca').val(rowData.marca);
        $('#talla').val(rowData.talla);
        $('#longitud').val(rowData.longitud);
        $('#valor_izq').val(rowData.valor_izq);
        $('#valor_der').val(rowData.valor_der);
        $('#resultados').val(rowData.resultado);

        // Abre el modal
        $('#editarModal').modal('show');
    });

    $('#dataTable').on('click', '.obs-btn', function() {
        var id = $(this).data('id');
        var rowData = $('#dataTable').DataTable().row($(this).closest('tr')).data();

        // Llena los campos del formulario con los valores de la fila
        $('#id_item_obs').val(id);
        $('#floatingTextarea2').val(rowData.obs);


        // Abre el modal
        $('#obsModal').modal('show');
    });
    // ...
});
</script>

<!-- Para inputs en modal -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const clienteInput = document.getElementById("clienteInput");
    const rucInput = document.getElementById("rucInput");

    clienteInput.addEventListener("change", function() {
        const selectedCliente = clienteInput.value;
        const option = Array.from(rucInput.children).find(option => option.textContent ===
            selectedCliente);
        if (option) {
            rucInput.value = option.value;
        }
    });

    rucInput.addEventListener("change", function() {
        const selectedRuc = rucInput.value;
        const option = Array.from(clienteInput.children).find(option => option.textContent ===
            selectedRuc);
        if (option) {
            clienteInput.value = option.value;
        }
    });
});
</script>

<script>
function actualizarDatos() {
    fetch('https://api.thingspeak.com/channels/1748898/feeds.json?results=2')
        .then(response => response.json())
        .then(data => {
            const field1Value = parseFloat(data.feeds[1].field1).toFixed(2); // Formatea a 2 decimales
            const field2Value = parseFloat(data.feeds[1].field2).toFixed(2); // Formatea a 2 decimales
            document.getElementById('humedad_informe').value = field1Value;
            document.getElementById('temperatura_informe').value = field2Value;
        })
        .catch(error => {
            console.error('Error al obtener datos de la API:', error);
        });
}

// Actualiza los datos cada 5 segundos (5000 milisegundos)
setInterval(actualizarDatos, 10000);
</script>

<script>
$(document).ready(function() {
    $('#generarPDFs').click(function() {
        // Mostrar el modal de espera
        $('#waitModal').modal('show');

        $.ajax({
            url: 'procesar.php?id_orden=<?php echo $id_orden ?>&equipo=<?php echo $equipo ?>&funcion=genero_pdf',
            type: 'GET',
            success: function(data) {
                // Ocultar el modal de espera
                $('#waitModal').modal('hide');
                // Mostrar el modal de descarga
                $('#downloadModal').modal('show');
                // Mostrar el enlace para descargar el ZIP
                $('#downloadLink').html(
                    '<a href="pdfs/<?php echo $id_orden ?>_certificados.zip">Descargar ZIP de certificados</a>'
                );
            },
            error: function() {
                // Ocultar el modal de espera en caso de error
                $('#waitModal').modal('hide');
                // Manejar errores
                alert('Error al generar PDFs y ZIP.');
            }
        });
    });
});
</script>