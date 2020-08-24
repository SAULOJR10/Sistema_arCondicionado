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

function PesquisaAr() {
    var quais = ';';
    if ($('#ch_Marca').is(':checked')) {
        quais = quais + 'Marca' + ';';
    }
    if ($('#ch_Modelo').is(':checked')) {
        quais = quais + 'Modelo' + ';';
    }
    if ($('#ch_Potencia').is(':checked')) {
        quais = quais + 'Potencia' + ';';
    }
    if ($('#ch_Localizacao').is(':checked')) {
        quais = quais + 'Localizacao' + ';';
    }
    $('#Ar').removeAttr('onclick');
    $('#Ar').attr('onclick', 'Pesquisar(\'' + quais + '\', \'AR\')');
}

function PesquisarAr() {
        if ($('#ch_Localizacao').is(':checked')) {
            MontarGrafico('localizacao');
        }
        if ($('#ch_Marca').is(':checked')) {
            MontarGrafico('marca');
        }
        if ($('#ch_Modelo').is(':checked')) {
            MontarGrafico('modelo');
        }
        if ($('#ch_Potencia').is(':checked')) {
            MontarGrafico('potencia');
        }
}

function MontarGrafico(id) {
    google.charts.load("current", { packages: ["corechart"] });
    var titulo = id.toUpperCase();
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarPesquisar.json.php',
        data: {
            acao: 'Ar',
            id: id,
        },
        success: function (data) {
            data = data.replace(new RegExp(';', 'g'),"");
            alert(data);
            $('#titulo').removeAttr('style');
            var data2 = google.visualization.arrayToDataTable([
                ['Titulo', 'Quantidade'],
                data
            ]);

            var options = {
                pieHole: 0.3,
                tooltip: { text: 'value' },
                chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
                legend: { position: 'bottom' },
                fontSize: 12,
                pieSliceText: 'value',
                pieSliceTextStyle: { color: 'black', fontSize: '120px', margin: '20px' },
            };
            var chart = new google.visualization.PieChart(document.getElementById('graficos'));
            chart.draw(data2, options);
        },
        error: function (msg) {
            alert('ERRO' + msg.responseText);
        }
    });
}