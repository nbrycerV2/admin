<!-- Modal Agregar Items-->
<div class="modal fade" id="agregar_item" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="procesar.php?funcion=agrego_items" method="post">
                    <input type="hidden" value="<?php echo $cliente; ?>" name="empresa">
                    <input type="hidden" value="<?php echo $vendedor; ?>" name="vendedor">
                    <input type="hidden" value="<?php echo $id_orden; ?>" name="id_orden">
                    <input type="hidden" value="<?php echo $equipo; ?>" name="equipo">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Marca</span>
                                        <input class="form-control" list="marca_lista" placeholder="Marca" name="marca">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Clase 00</span>
                                        <input type="number" min="0" class="form-control" placeholder="Cantidad"
                                            name="clase00">
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Clase 0</span>
                                        <input type="number" min="0" class="form-control" placeholder="Cantidad"
                                            name="clase0">
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Clase 1</span>
                                        <input type="number" min="0" class="form-control" placeholder="Cantidad"
                                            name="clase1">
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Clase 2</span>
                                        <input type="number" min="0" class="form-control" placeholder="Cantidad"
                                            name="clase2">
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Clase 3</span>
                                        <input type="number" min="0" class="form-control" placeholder="Cantidad"
                                            name="clase3">
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Clase 4</span>
                                        <input type="number" min="0" class="form-control" placeholder="Cantidad"
                                            name="clase4">
                                    </div>
                                </td>

                            </tr>

                        </tbody>
                    </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar-->
<div id="editarModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Información</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="procesar.php?funcion=edito_items" method="post">
                <div class="modal-body">
                    <input type="hidden" name="equipo" value="<?php echo $equipo ?>">
                    <input type="hidden" name="id_orden" value="<?php echo $id_orden; ?>">
                    <input type="hidden" name="id_item" id="id_item">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Nº Informe</span>
                                        <input type="text" class="form-control" placeholder="Nº Informe" id="n_informe"
                                            name="n_informe" aria-describedby="basic-addon1">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Serie</span>
                                        <input type="text" class="form-control" placeholder="Serie" id="serie"
                                            name="serie" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Clase</span>
                                        <select type="text" class="form-control" placeholder="Clase" id="clase"
                                            name="clase" aria-describedby="basic-addon1">
                                            <option value="Clase 00">Clase 00</option>
                                            <option value="Clase 0">Clase 0</option>
                                            <option value="Clase 1">Clase 1</option>
                                            <option value="Clase 2">Clase 2</option>
                                            <option value="Clase 3">Clase 3</option>
                                            <option value="Clase 4">Clase 4</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Marca</span>
                                        <input type="text" class="form-control" placeholder="Marca" name="marca"
                                            id="marca" list="marca_lista" aria-describedby="basic-addon1">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Valor Izq.</span>
                                        <input type="text" class="form-control" name="valor_izq" id="valor_izq"
                                            placeholder="Valor Izq." aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Valor Der.</span>
                                        <input type="text" class="form-control" name="valor_der" id="valor_der"
                                            placeholder="Valor Der." aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Metodo</span>
                                        <select type="text" class="form-control" name="otro" id="otro"
                                            aria-label="Username" aria-describedby="basic-addon1">
                                            <option value="Dielectrico">Dielectrico</option>
                                            <option value="Inflado">Inflado</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Resultado</span>
                                        <select type="text" class="form-control" name="resultados" id="resultados"
                                            placeholder="Resultado" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                            <option value="Apto">Apto</option>
                                            <option value="No Apto">No Apto</option>
                                            <option value="Pendiente">Pendiente</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="guardarEdicion">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Observaciones -->
<div class="modal fade" tabindex="-1" id="obsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <textarea id="obs_edit" name="obs_edit"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edito Orden -->
<div class="modal fade" tabindex="-1" id="edit_orden">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Orden</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="procesar.php?funcion=edito_orden" method="post">
                <input type="hidden" name="id_orden" value="<?php echo $id_orden; ?>">
                <div class="modal-body">
                    <div class="col">
                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Empresa</span>
                                            <input type="text" class="form-control" value="<?php echo $cliente; ?>"
                                                name="cliente" id="clienteInput">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Ruc</span>
                                            <input type="text" class="form-control" value="<?php echo $ruc; ?>"
                                                name="ruc" id="rucInput">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Vendedor</span>
                                            <input type="text" class="form-control" name="vendedor" list="empleados"
                                                value="<?php echo $vendedor; ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Estado</span>
                                            <select class="form-control" name="estado" id="">
                                                <option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
                                                <option disabled>──────────</option>
                                                <option value="Pendiente">Pendiente</option>
                                                <option value="Anulado">Anulado</option>
                                                <option value="Entregado">Entregado</option>
                                                <option value="Evaluado">Evaluado</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Fecha de
                                                Salida</span>
                                            <input type="date" class="form-control" value="<?php echo $salida; ?>"
                                                name="salida" id="">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Datos informe -->
<div class="modal fade" tabindex="-1" id="datos_informe">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos para el informe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="procesar.php?funcion=datos_informe" method="post">
                <input type="hidden" name="id_orden" value="<?php echo $id_orden; ?>">
                <div class="modal-body">
                    <div class="col">
                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Fecha del
                                                Informe</span>
                                            <input type="date" class="form-control" name="fecha_inf"
                                                value="<?php echo $fecha_inf; ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Temperatura</span>
                                            <input type="text" class="form-control" id="temperatura_informe"
                                                name="temperatura_informe" value="<?php echo $temperatura; ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Humedad</span>
                                            <input type="text" class="form-control" name="humedad_informe"
                                                id="humedad_informe" value="<?php echo $humedad; ?>">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para mostrar el enlace de descarga -->
<div id="downloadModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Descargar Zip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Haz clic en el enlace para descargar el ZIP con los certificados:</p>
                <div id="downloadLink"></div> <!-- Contenedor para mostrar el enlace de descarga -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar mensaje de espera -->
<div id="waitModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generación en progreso</h5>
            </div>
            <div class="modal-body">
                Espere un momento, se están generando los certificados...
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>