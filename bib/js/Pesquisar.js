function SoUm(id) {
    switch (id) {
        case 'ch_Arcond':
            $('#ch_Prop').prop('checked', false);
            $('#ch_UH').prop('checked', false);
            if ($('#ch_ArCond').is(':checked')) {
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
                $('#ch_Localizacao').prop('checked', false);v
            }
            break;
        case 'ch_Prop':
            $('#ch_ArCond').prop('checked', false);
            $('#ch_UH').prop('checked', false);
            break;
        case 'ch_UH':
            $('#ch_Prop').prop('checked', false);
            $('#ch_Arcond').prop('checked', false);
            break;
    }

}