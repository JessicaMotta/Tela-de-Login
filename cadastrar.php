<?php
    require_once'classes/usuarios.php';
    $u = new Usuario; //classe de ususarios que foi criada em usuarios.php
?>
<html lang ="pt-br">
<head>
    <meta charset ="utf-8" />
    <title> PROJETO </title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body> 
    <!-- criando o formulário de login -->
<div id="corpo-form-cadastro">
    <h1> Cadastre-se </h1>
    <hr>
    <form method="POST"> <!--enviando infos ao bd -->
    <!--maxlength = determinando os mesmos valores destinados ao banco de dados 
        desta forma, será "bloqueado" caso o usuario ultrapasse o limite  -->
        <input type="text" name="nome" placeholder="Digite seu Nome Completo:" maxlength="30">
        <input type="email" name="email" placeholder="Digite seu E-mail:" maxlength="40">
        <input type="text" name="cpf" placeholder="Digite seu CPF:" maxlength="11">
        <input type="text" name="telefone" placeholder="Digite seu Telefone:" maxlength="30">
        <input type="password" name="senha" placeholder="Digite sua Senha:" maxlength="15">
        <input type="password" name="confSenha" placeholder="Confirme sua senha:">
        <input type="submit" value="Cadastrar">
    </form>
</div>
<?php
//verificar se clicou no botão (cadastrar)
if(isset($_POST['nome']))
{
    $nome = addslashes($_POST['nome']);
    $email = addslashes($_POST['email']);
    $cpf = addslashes($_POST['cpf']);
    $telefone = addslashes($_POST['telefone']);
    $senha = addslashes($_POST['senha']);
    $confirmarSenha = addslashes($_POST['confSenha']);

    //verificar se todos os campos estão preenchidos
    if(!empty($nome) && !empty($email) && !empty($cpf) && !empty($telefone) && !empty(
        $senha) && !empty($confirmarSenha))
    {
        $u->conectar("projeto_login","localhost","root","");
        if($u->msgErro == "") //vazia == sem erros
        {
            if($senha == $confirmarSenha){
                if($u->cadastrar($nome,$email,$cpf,$telefone,$senha))
                {
                    ?> 
                    <div id="msg-sucesso">
                        Cadastrado com sucesso!
                    </div>
                    <?php
                }else
                    {
                        ?> 
                        <div class="msg-erro">
                            E-mail já cadastrado ;)
                        </div>
                        <?php
                }
            }else
                {
                    ?>
                    <div class="msg-erro">
                        'Senha' e 'Confirmar Senha' não correspondem...
                    </div>
                    <?php
                }
            }else
                {
                    ?>
                    <div class="msg-erro">
                    //se estiver com erro, mensagem será apresentada junto com a descrição de erro
                        <?php echo "Erro: ".$u->msgErro;?>
                    </div>
                    <?php
                }
            }else
                {
                    ?>
                    <div class="msg-erro">
                        Preencha todos os campos!
                    </div>
                    <?php
                }
}
?>
</body>
</html>