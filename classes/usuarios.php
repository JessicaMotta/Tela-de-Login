<?php
Class Usuario{
    // aqui está sendo criado uma classe de usuarios com o metodo de conectar
    // fará a conecção com o bd

    private $pdo;
    public $msgErro = ""; // caso esteja vazia, ok

    //CONECTANDO TELA AO BD
    public function conectar($nome, $host, $usuario, $senha)
    {
        global $pdo;
        try 
        {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,
                $usuario,$senha);
        } catch (PDOException $e) {
            // Aqui será tratado caso haja um possivel erro. Foi criado uma variavel
            // $msgErro para armazenar a mensagem de erro
            $msgErro = $e->getMessage();
        }
    }

    //CADASTRAR
    public function cadastrar($nome, $email, $cpf, $telefone, $senha)
    {
        global $pdo;
        //1.verificar se já existe(buscar) o e-mail cadastrado
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios
            WHERE email = :e"); //:e = aquilo que foi digitado no campo de e-mail
        $sql->bindValue(":e",$email);
        $sql->execute();

        if ($sql->rowCount() > 0){
            
            return false; //já está cadastrada 
        }else{
            //2.caso não, cadastrar
            $sql = $pdo->prepare("INSERT INTO usuarios(nome,email,
                cpf,telefone,senha) VALUES (:n, :e, :c, :t, :s)");
            $sql->bindValue(":n",$nome);
            $sql->bindValue(":e",$email);
            $sql->bindValue(":c",$cpf);
            $sql->bindValue(":t",$telefone);
            $sql->bindValue(":s",md5($senha)); //md5 criptografia de senha
            $sql->execute();
            return true; // o usuario foi cadastrado com sucesso
        }
    }
    //LOGIN
    public function logar($email, $senha){
        global $pdo;
        // verificar se o e-mail e senha estão cadastrados, se sim
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE 
            email = :e AND senha = :s"); //e-mail e senha iguais ao cadastrado no banco
        $sql->bindValue(":e",$email);
        $sql->bindValue(":s",md5($senha));
        $sql->execute();

        if ($sql->rowCount() > 0){
            // entrar no sistema e iniciar a sessão
            $dado = $sql->fetch();
            session_start();
            //o ususario que acabou de logar está armazenado em uma sessão (area privada)
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true; //logado com sucesso
        }else{
            return false; //não foi possivel logar
        }
        
    }
}
?>