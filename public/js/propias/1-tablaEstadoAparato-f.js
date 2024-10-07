$(document).ready(function() {
    
    $('#consultarAparato').on("submit", function(event) {
        event.preventDefault();
        var sin_registros = false;
        var dni = $("#dni").val();
        var url_admin = $("#url_admin").val();
        toastr.info("Consultando Dni: " + dni);
        $.ajax({
            url: '/consultar_aparato', 
            method: 'POST',
            data: { accion: dni},
            beforeSend: function() {
                $(".consultandoAparato").removeClass('d-none');
                $(".consultandoAparato").show();
            },
            success: function(data) {
                var contenedorTablas = $('#generar_tablas');
                contenedorTablas.empty(); 
                var sin_registros = true;
                if (data === 'DNI inválido') {
                    toastr.error("DNI inválido.<br> Por favor, ingrese un DNI válido");
                }
                $.each(data, function(index, item) {
                    console.log(item);
                    if (item) {
                        sin_registros = false;
            
                        // Crear la fila de la tabla con la información del item
                        var tabla = '<div class="table-responsive mb-3">' +
                                    '<table class="table table-bordered">' +
                                    '<thead>' +
                                    '<tr>' +
                                    '<th width="160px">Estado</th>' +
                                    '<th>Presupuesto</th>' +
                                    '<th>Tipo</th>' +
                                    '<th>Marca</th>' +
                                    '<th>Recibido</th>' +
                                    '</tr>' +
                                    '</thead>' +
                                    '<tbody>';
                        var estadoTexto = item.estado.toUpperCase();
                        if (item.fecha_entrega == "0000-00-00") {
                            var fecha_entrega = 'Sin Fecha';
                        } else{
                            var fecha_entrega = item.fecha_entrega.toUpperCase();
                        }
                        if (item.estado == "entregado") {
                            var estado = '<td style="background-color: green; color: white; display:flex; justify-content: center; padding: 14px 18px; margin-top: 12px; border-radius: 8px; flex-direction: column; align-items: center;"><b>' + estadoTexto + '</b> <b  style="background-color: green; margin: 0px -2px;">' + fecha_entrega + '</b></td>';
                        } else if (item.estado == "retirar") {
                            var estado = '<td style="background-color: #FFC107; color: black; display:flex; justify-content: center; padding: 14px 25px; margin-top: 12px; border-radius: 8px;"><b>' + estadoTexto + '</b></td>';
                        } else if (item.estado == "reparando") {
                            var estado = '<td style="background-color: #17a2b8; color: white; display:flex; justify-content: center; margin-top: 12px; border-radius: 8px;"><b>' + estadoTexto + '</b></td>';
                        } else if (item.estado == "recibido") {
                            var estado = '<td style="background-color: blue; color: white; display:flex; justify-content: center; padding: 14px 25px; margin-top: 12px; border-radius: 8px;"><b>' + estadoTexto + '</b> </td>';
                        }
                        
                        var monto = '<td>' + item.monto + '</td>';
                        var tipo = '<td>' + item.tipo + '</td>';
                        var marca = '<td>' + item.marca + '</td>';
                        var fechaRecibido = '<td>' + item.fecha_recibido + '</td>';
            
                        tabla += '<tr>' + estado  + monto + tipo + marca + fechaRecibido  +'</tr>';
                        tabla += '</tbody></table></div>';
            
                        contenedorTablas.append(tabla);
                    }
                });
            
                if (sin_registros) {
                    var mensaje = '<h5 class="py-3 text-center">No tenemos resultados</h5>';
                    contenedorTablas.append(mensaje);
                }
            },
            complete: function() {
                $(".consultandoAparato").addClass('d-none');
                $(".consultandoAparato").hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var contenedorTablas = $('#generar_tablas');
                var mensaje = '<h5 class="py-3">Error al obtener los datos</h5>';
                contenedorTablas.append(mensaje);
                console.error('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
        
    });
    
        
});