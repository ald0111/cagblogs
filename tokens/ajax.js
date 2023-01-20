$(document).ready(function(){
  var slotdata;
  $("#frnew").css("display","none");
  $("#frslot2").css("display","none");
  $("#tget").css("display","none");
  $("#dsee").css("display","none");
  $("#tput").css("margin-left","auto");
  $("#tput").css("margin-right","auto");
  $("#db").prop('disabled', true);
    $("#put").submit(function(event){
      event.preventDefault();
      //var mode = $(this).attr('id');
      var ajaxdata;
      var rigisdata = $(this).serialize();
      var isBlock = $('#frslot2').is(':visible');
      if(isBlock) {
        var d = window.slotdata;
        ajaxdata = rigisdata;
        ajaxdata += "&seat1="+d[0]+"&name="+d[1];
      } else {
        ajaxdata = rigisdata;
      }
      $("#db").prop('disabled', true);
      $("#bsee").prop('disabled', true);
      $("#loading").css('display','block');
      //var ajaxdata = "mode=" + mode + "&" + rigisdata;
      var url = $(this).attr('action');
      $.ajax({
      type: "POST",
      url: url,
      data: ajaxdata,
      cache: false,
      success: function(result){
        $("#status").html(result);
        $("#db").prop('disabled', false);
        $("#bsee").prop('disabled', false);
        $("#loading").css('display','none');
      }
    });
    });
      $("#phone").keyup(function(){

        var a = $("#phone").val();

        var url = $("#put").attr('action');
        if(a > 1000000000) {
          var data = "cphone="+a;
          $("#db").prop('disabled', true);
          $("#bsee").prop('disabled', true);
          $("#loading").css('display','block');
          $.ajax({
          type: "POST",
          url: url,
          data: data,
          cache: false,
          success: function(result){
            $("#db").prop('disabled', false);
            $("#bsee").prop('disabled', false);
            $("#loading").css('display','none');
            var res = result.split("-");
            if(result=="new") {
              $("#frnew").css("display","block");
              $("#db").prop('disabled', false);
            } else if(result=="exists") {
              let a = $("#phone").val();
              let url = $("#get").attr('action');
              var ajaxdata = "phonet="+a;
              $.ajax({
              type: "POST",
              url: url,
              data: ajaxdata,
              cache: false,
              success: function(result){
                $("body").empty();
                $("body").html(result);
              }
              });
            } else if ((res[0]=="Male")||(res[0]=="Female")) {
              window.slotdata = res;
              $("#frslot2").css("display","block");
              $("#dsee").css("display","block");
              if(result=="Male"){
                //$("#opt2").prop('selected', true);
              } else if(result=="Female"){
                //$("#opt3").prop('selected', true);
              }
              $("#slot1").prop('required', false);
              $("#slot2").prop('required', true);
              $("#name").prop('required', false);
              $("#name").prop('disabled', true);
              $("#db").prop('disabled', false);
            }
          }
          });
        } else {
          $("#frnew").css("display","none");
          $("#dsee").css("display","none");
          $("#frslot2").css("display","none");
          $("#db").prop('disabled', true);
        }
      });
    $("#bsee").click(function(event){
    let a = $("#phone").val();
    let url = $("#get").attr('action');
    var ajaxdata = "phonet="+a;
    $("#db").prop('disabled', true);
    $("#bsee").prop('disabled', true);
    $("#loading").css('display','block');
    $.ajax({
    type: "POST",
    url: url,
    data: ajaxdata,
    cache: false,
    success: function(result){
      $("#db").prop('disabled', false);
      $("#bsee").prop('disabled', false);
      $("#loading").css('display','none');
      $("body").empty();
      $("body").html(result);
    }
    });
    });
});
