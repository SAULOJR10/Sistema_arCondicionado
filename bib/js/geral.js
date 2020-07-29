/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}



function mensagem(titulo, msg) {
    $("<div title='" + titulo + "'>" + msg + "</div>").dialog({
        modal: true,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        }
    });
}


function mensagemAtualizar(titulo, msg) {
    $("<div title='" + titulo + "'>" + msg + "</div>").dialog({
        modal: true,
        close: function (event, ui) {
            $(this).dialog('destroy').remove();
             location.reload();
        },
        buttons: {
            Ok: function () {
                $(this).dialog("close");
                location.reload();
            }
        }
    });
}


function mensagemErro(titulo, msg) {
    $("<div title='" + titulo + "'> <span class='ui-icon ui-icon-alert' style='float:left; margin:12px 12px 20px 0;'> </span>" + msg + "</div>").dialog({
        modal: true,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        }
    });
} 