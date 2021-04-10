$(document).ready(function () {

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
      console.log(resp.data);
      // Obtiene los datos del servicio
      var id = resp.data['0'].Id;
      var num_tarjeta = resp.data['0'].Tarjeta;
      var propietario = resp.data['0'].Propietario;
      // Setea los datos en el formulario
      $("input[name='id_tarjeta']").val(id);
      $("input[name='num_tarjeta_edit']").val(num_tarjeta);
      $("input[name='nom_cliente_edit']").val(propietario);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
