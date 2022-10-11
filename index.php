<?php
require_once 'classes/usuarios.php';
$u = new Usuario;

?>

<html lang ="pt-br">
<head>
    <meta charset ="utf-8" />
    <title> projeto login </title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body> 
    <!-- criando o formulário de login -->
<div id="corpo-form-login">
    <h1> Acesse ou crie sua conta </h1>
    <form method="POST"> <!--enviando infos ao bd -->
        <input type="email" name="email" placeholder="Digite seu E-mail">
        <input type="password" name="senha" placeholder="Digite sua Senha" >
        <input type="submit" value="Entrar">
        <!-- leva o usuario para outra página caso não tenha cadastro 
        a partir daqui, todo o código foi reaproveitado de tela de login -->
        <a href="cadastrar.php"><strong>Clique aqui </strong> para criar uma nova conta</a>
    </form>
</div>
<?php
if(isset($_POST['email']))
{
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    //verificar se todos os campos estão preenchidos
    if(!empty($email) && !empty($senha))
    {
        $u->conectar("projeto_login","localhost","root","");
        if($u->msgErro == "")
        {
        if ($u->logar($email, $senha))
        {
            //acessando a aréa privada
            header ("location: AreaPrivada.php");
        }
        else
        {
            ?>
            <div class="msg-erro">
                E-mail e/ou senha incorretos!
            </div>
            <?php
        }
        }
        else
        {
            ?>
            <div class="msg-erro">
                <?php echo "Erro: ".$u->megErro; ?>
            </div>
            <?php
            
        }
    }else
    {
        ?>
        <div class="msg-erro">
            "Preencha todos os campos!"
        </div>
        <?php
    }
}
?>
</body>
</html>