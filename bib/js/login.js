function checa_formulario(dados) {

    if (dados.login.value === "") {
        mensagemErro("Falha no Acesso!","Login não pode ficar em branco!");
        dados.login.focus();
        return (false);
    }
    
    if (dados.senha.value === "") {
        mensagemErro("Falha no Acesso!","Senha não pode ficar em branco!");
        dados.senha.focus();
        return (false);
    }
}

function voltar(){
    location.href="index.php";
}


