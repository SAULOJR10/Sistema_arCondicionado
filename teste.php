<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="bib/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $teste = ["teste1", "teste2", "testando1", "testando2"];
        $("#nomeProp").autocomplete({
            source: $teste
        });
    </script>
</head>

<body>
    <input type="text" name="search" id="nomeProp" class="j_complete">
</body>