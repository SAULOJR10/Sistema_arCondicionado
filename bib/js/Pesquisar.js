function SoUm(id) {
    switch (id) {
        case 'ch_Arcond':
            if ($('#ch_ArCond').is(':checked')) {
                $('#ch_Prop').prop('checked', false);
                $('#ch_UH').prop('checked', false);
                $('.opaco').removeAttr('style');
                $('.opaco').attr('style', 'margin-top:15px;');
                $('#ch_Marca').removeAttr('disabled');
                $('#ch_Modelo').removeAttr('disabled');
                $('#ch_Potencia').removeAttr('disabled');
                $('#ch_Localizacao').removeAttr('disabled');
            } else {
                $('.opaco').attr('style', 'margin-top:15px; opacity:0.5');
                $('#ch_Marca').attr('disabled', true);
                $('#ch_Modelo').attr('disabled', true);
                $('#ch_Potencia').attr('disabled', true);
                $('#ch_Localizacao').attr('disabled', true);
                $('#ch_Marca').prop('checked', false);
                $('#ch_Modelo').prop('checked', false);
                $('#ch_Potencia').prop('checked', false);
                $('#ch_Localizacao').prop('checked', false);
            }
            break;
        case 'ch_Prop':
            $('#ch_ArCond').prop('checked', false);
            $('#ch_UH').prop('checked', false);
            SoUm('ch_Arcond');
            break;
        case 'ch_UH':
            $('#ch_Prop').prop('checked', false);
            $('#ch_Arcond').prop('checked', false);
            SoUm('ch_Arcond');
            break;
    }

}

function PesquisaAr(){
    var quais = ';';
    if($('#ch_Marca').is(':checked')){
        quais = quais + 'Marca' + ';';
    }
    if($('#ch_Modelo').is(':checked')){
        quais = quais + 'Modelo' + ';';
    }
    if($('#ch_Potencia').is(':checked')){
        quais = quais + 'Potencia' + ';';
    }
    if($('#ch_Localizacao').is(':checked')){
        quais = quais + 'Localizacao' + ';';
    }
    $('#Ar').removeAttr('onclick');
    $('#Ar').attr('onclick', 'Pesquisar(\''+quais+'\', \'AR\')');
}

function Pesquisar(oq, acao){
    
}