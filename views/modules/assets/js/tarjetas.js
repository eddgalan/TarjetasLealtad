$(document).ready(function () {
  /* ..:: DATATABLE ::.. */
  var table = $('#tb_tarjetas').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  });

  /* ..:: OBTIENE DATOS PARA RECARGA ::.. */
  $("input[name='num_tarjeta_recarga']").on('input', function(){
    valida_num_tarjeta();
    valida_monto();
  });

  /* ..:: VALIDA MONTO | RECARGA ::.. */
  $("input[name='monto_recarga']").on('input', function() {
    valida_num_tarjeta();
    var nombre = $("input[name='nom_cliente_recarga']").val();
    if(nombre != "-----"){
      valida_monto();
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

/* ..:: GET TARJETA RECARGA ::.. */
function valida_num_tarjeta(){
  var num_tarjeta = $("input[name='num_tarjeta_recarga']").val();
  var token = $("input[name='token']").val();

  if (num_tarjeta.length > 0){
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "./API/tarjetas/get_tarjeta_by_num/" + num_tarjeta,
      data: {"token":token},
      success: function(resp){
        // console.log(resp.data);
        if(resp.data.length > 0){
          $("small[name='msg_no_encontrado_recarga']").css("display","none");
          // Obtiene los datos del servicio
          var id = resp.data['0'].Id;
          var num_tarjeta = resp.data['0'].Tarjeta;
          var propietario = resp.data['0'].Propietario;
          var saldo = resp.data['0'].Saldo;
          // Setea los datos en el formulario
          $("input[name='id_tarjeta']").val(id);
          $("input[name='nom_cliente_recarga']").val(propietario);
          $("input[name='saldo']").val("$ " + saldo);
        }else{
          $("small[name='msg_no_encontrado_recarga']").css("display","block");
          $("input[name='nom_cliente_recarga']").val("-----");
          $("input[name='saldo']").val("$ 0.00");
          $("button[name='btn-recargar']").attr("disabled", "disabled");
        }
      },
      error : function(xhr, status) {
        console.log(xhr);
      }
    });
  }
}

/* ..:: VALIDA MONTO RECARGA ::.. */
function valida_monto(){
  var monto = $("input[name='monto_recarga']").val();
  if($.isNumeric(monto)){
    $("button[name='btn-recargar']").removeAttr("disabled");
  }else{
    $("button[name='btn-recargar']").attr("disabled", "disabled");
  }
}

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
