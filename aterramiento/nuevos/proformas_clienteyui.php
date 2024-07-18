<?php $conexion = mysqli_connect("localhost", "root", "", "sistema"); ?>
YUI().use('autocomplete', 'autocomplete-filters', 'autocomplete-highlighters', function (Y) {
var states = [<?php $sql = mysqli_query($conexion, "SELECT * from ven_clientes");
                while ($reg = mysqli_fetch_array($sql)) {
                    print "'" . $reg['id'] . "|" . addslashes($reg['nombre']) . "|" . $reg['ruc'] . "',";
                } ?> ];
Y.one('#empresa_yui').plug(Y.Plugin.AutoComplete, {
activateFirstItem: true,
minQueryLength:2,
tabSelect: true,
maxResults: 40,
resultFilters: 'subWordMatch',
source : states
});
});