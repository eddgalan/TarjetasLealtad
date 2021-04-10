$(document).ready(function () {
  /* ..:: VALIDA MONTO | RECARGA ::.. */
  $("input[name='monto_recarga']").on('input', function() {
    var monto = $("input[name='monto_recarga']").val();
    if($.isNumeric(monto)){
      $("button[name='btn-recargar']").removeAttr("disabled");
    }else{
      $("button[name='btn-recargar']").attr("disabled", "disabled");
    }
  });

  /* ..:: VALIDA MONTO | OPERACIÓN ::.. */
  $("input[name='monto_operacion']").on('input', function() {
    var monto = $("input[name='monto_operacion']").val();
    if($.isNumeric(monto)){
      $("button[name='btn-transaccion']").removeAttr("disabled");
    }else{
      $("button[name='btn-transaccion']").attr("disabled", "disabled");
    }
  });

  /* ..:: CONSULTA SALDO | CLIC BOTÓN ::.. */
  $("button[name='btn-consultar']").click(function(){
    var num_tarjeta = $("input[name='num_tarjeta_consulta']").val();
    if(num_tarjeta!=""){
      $("small[name='msg_num_tarjeta']").css("display","none");
      carga_datos_tarjeta_by_num(num_tarjeta);
    }else{
      $("small[name='msg_num_tarjeta']").css("display","block");
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

/* ..:: CARGA DATOS TARJETA BY NUM | AJAX ::.. */
function carga_datos_tarjeta_by_num(num_tarjeta){
  var token = $("input[name='token']").val();

  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "./API/tarjetas/get_tarjeta_by_num/" + num_tarjeta,
    data: {"token":token},
    success: function(resp){
      // console.log(resp.data);
      if(resp.data.length > 0){
        $("small[name='msg_no_encontrado']").css("display","none");
        // Obtiene los datos del servicio
        var id = resp.data['0'].Id;
        var num_tarjeta = resp.data['0'].Tarjeta;
        var propietario = resp.data['0'].Propietario;
        var saldo = resp.data['0'].Saldo;
        // Setea los datos en el formulario
        $("input[name='cliente_consulta']").val(propietario);
        $("input[name='saldo_consulta']").val("$ " + saldo);
      }else{
        $("small[name='msg_no_encontrado']").css("display","block");
        $("input[name='cliente_consulta']").val("-------------");
        $("input[name='saldo_consulta']").val("$ 0.00");
      }
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
