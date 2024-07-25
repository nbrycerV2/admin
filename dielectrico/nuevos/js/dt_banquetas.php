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
                if (row.serie_banqueta == '' || row.serie_banqueta == null) {
                    return row.serie_edit;
                } else {
                    return row.serie_banqueta;
                }

            }
        }, {
            "data": "clase"
        }, {
            "data": "marca"
        }, {
            "data": null,
            render: function(data, type, row) {
                const clases = {
                    "Clase 00": "2 mA",
                    "Clase 0": "2 mA",
                    "Clase 1": "2 mA",
                    "Clase 2": "2 mA",
                    "Clase 3": "2 mA",
                    "Clase 4": "2 mA"
                };

                return clases[row.clase] || "Falta colocar la clase";
            }
        }, {
            "data": "talla"
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

        if (rowData.serie_banqueta == '' || rowData.serie_banqueta == null) {
            var series = rowData.serie_edit
        } else {
            var series = rowData.serie_banqueta;
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
<!-- Obs_editar -->
<script>
ClassicEditor
    .create(document.querySelector('#obs_edit'))
    .then(editor => {
        editor.model.document.on('change:data', () => {
            document.querySelector('#contenido1').value = editor.getData();
        });
    })
    .catch(error => {
        console.error(error);
    });
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