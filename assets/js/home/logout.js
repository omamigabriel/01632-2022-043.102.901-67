var timeoutNow = 1000 * 21600;  
var timeoutAlert = 1000 * 19800;
var timeoutTimer;
var alertFimSessao;

$(document).ready(function(){
  timeoutTimer = setTimeout(logout, timeoutNow);
  
  $(this).on('mousemove', resetarTempoSessao);
  $(this).on('keydown', resetarTempoSessao);

  });

// Reset timer
 function resetarTempoSessao() {
   clearTimeout(timeoutTimer);
   clearTimeout(alertFimSessao);
   timeoutTimer = setTimeout(logout, timeoutNow);
   alertFimSessao = setTimeout(validaTempoSessao, timeoutAlert);
}

function validaTempoSessao(){
  modal();
}

// logout do usuário
function logout()
{
  var endereco = base_url + "Login/logout";
  $.ajax({
        async: false,
        type: "POST",
        url: endereco,
    }).done(window.location = base_url);
}

function modal()
{
  // var meu_modal = '<div id="fundo_modal" class="modal">'
  //                   +'<div class="modal-dialog">'
  //                     +'<div class="modal-content">'
  //                       +'<div class="modal-header">'
  //                         +'<h5 class="modal-title">Inativo</h5>'
  //                         +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>'
  //                           +'<span aria-hidden="true">&times;</span>'
  //                         +'</button>'
  //                       +'</div>'
  //                       +'<div class="modal-body">'
  //                         +'<p class="text-black">Sua sessão será fechada em 30 minuto(s) por falta de atividade no Supra.</p>'
  //                       +'</div>'
  //                     +'</div>'
  //                   +'</div>'
  //                 +'</div>';

 var meu_modal = '<div id="fundo_modal" class="modal" style="background: rgb(0 0 0 / 60%);">'
                    +'<div class="modal-dialog">'
                      +'<div class="modal-content alert-logout">'
                        +'<div class="modal-body" style="padding-bottom: 2rem;">'
                          +'<div class="row">'
                            +'<div class="col-md-12">'
                              +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>'
                                +'<span class="pull-right" aria-hidden="true" style="cursor: pointer;">&times;</span>'
                              +'</button>'
                            +'</div>'
                            +'<div class="col-md-2">'
                              +'<i class="fa fa-bell bell-modal-alert"></i>'
                            +'</div>'
                            +'<div class="col-md-10">'
                              +'<p>Sua sessão será fechada em <b>30 minuto(s)</b> por falta de atividade no SUPRA.</p>'
                            +'</div>'
                          +'</div>'
                        +'</div>'
                      +'</div>'
                    +'</div>'
                  +'</div>';
  
  $("body").append(meu_modal);
  
  $("#fundo_modal, .close").click(function(){ $("#fundo_modal").hide(); });

  $('#fundo_modal').fadeIn();
}