$(document).ready(function () {
  /* ..:: VALIDA MONTO ::.. */
  $("input[name='monto_recarga']").on('input', function() {
    var monto = $("input[name='monto_recarga']").val();
    if($.isNumeric(monto)){
      $("button[name='btn-recargar']").removeAttr("disabled");
    }else{
      $("button[name='btn-recargar']").attr("disabled", "disabled");
    }
  });
  
});

/* ..:: CARGA DATOS TARJETA | AJAX ::.. */
function carga_datos_tarjeta(id){
  var token = $("input[name='token']").val();

  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "./API/tarjetas/get_tarjeta/" + id,
    data: {"token":token},
    success: function(resp){
      // console.log(resp.data);
      // Obtiene los datos del servicio
      var id = resp.data['0'].Id;
      var num_tarjeta = resp.data['0'].Tarjeta;
      var propietario = resp.data['0'].Propietario;
      var saldo = resp.data['0'].Saldo;
      // Setea los datos en el formulario
      $("input[name='id_tarjeta']").val(id);
      $("input[name='num_tarjeta_edit']").val(num_tarjeta);
      $("input[name='nom_cliente_edit']").val(propietario);
      $("input[name='saldo']").val("$ " + saldo);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
