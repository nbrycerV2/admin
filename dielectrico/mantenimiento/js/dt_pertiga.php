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
                    if (row.serie_pertiga === null || row.serie_pertiga === '') {
                        return row.serie_edit;
                    } else {
                        return row.serie_pertiga;
                    }

                }
            }, {
                "data": "marca"
            }, {
                "data": "clase"
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

            if (rowData.serie_pertiga === null || rowData.serie_pertiga === '') {
                var series = rowData.serie_edit
            } else {
                var series = rowData.serie_pertiga;
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

            var idOrden = '<?php echo $id_orden ?>';
            var equipo = '<?php echo $equipo ?>';

            // Console log para verificar los valores
            console.log('ID Orden:', idOrden);
            console.log('Equipo:', equipo);

            $.ajax({
                url: 'procesar.php?id_orden=' + idOrden + '&equipo=' + equipo +
                    '&funcion=genero_pdf',
                type: 'GET',
                success: function(data, textStatus, jqXHR) {
                    // Verificar el estado HTTP
                    // Verificar el estado HTTP
                    if (jqXHR.status === 200) {
                        console.log('Solicitud exitosa. Código de estado:', jqXHR.status);
                        console.log('Respuesta del servidor:', data); // Agrega este log
                    } else {
                        console.warn('Llegada a la URL, pero con código de estado:', jqXHR
                            .status);
                    }
                    // Ocultar el modal de espera
                    $('#waitModal').modal('hide');
                    // Mostrar el modal de descarga
                    $('#downloadModal').modal('show');
                    // Mostrar el enlace para descargar el ZIP
                    $('#downloadLink').html(
                        '<a href="pdfs/' + idOrden +
                        '_certificados.zip">Descargar ZIP de certificados</a>'
                    );
                },
                error: function(xhr, status, error) {
                    // Ocultar el modal de espera en caso de error
                    $('#waitModal').modal('hide');
                    // Manejar errores
                    console.error('Error:', error);
                    console.error('Estado:', status);
                    console.error('Respuesta del servidor:', xhr.responseText);
                    alert('Error al generar PDFs y ZIP.');
                }
            });
        });
    });
</script>