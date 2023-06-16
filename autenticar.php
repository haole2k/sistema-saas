<?php 
@session_start();
require_once("conexao.php");
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$senha_crip = md5($senha);

$query = $pdo->prepare("SELECT * FROM usuarios WHERE (email = :usu or cpf = :usu) and senha_crip = :senha");
$query->bindValue(":usu", "$usuario");
$query->bindValue(":senha", "$senha_crip");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0){


	if($res[0]['ativo'] != 'Sim'){
		echo '<script>alert("Usuário Inativo, contate o Administrador!")</script>';
		echo '<script>window.location="index.php"</script>';
		exit();
	}
	
	$id = $res[0]['id'];
	$nivel = $res[0]['nivel'];
	$empresa = $res[0]['empresa'];

	if($nivel != 'Administrador' and $nivel != 'SAS'){
	$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
		if($total_reg == 0){
			echo '<script>alert("Você ainda não tem acessos, contate o administrador!")</script>';
			echo '<script>window.location="index.php"</script>';	
		}
	}

	//armazenar no storage o id e o nivel
	echo "<script>localStorage.setItem('id_usu', '$id')</script>";
	echo "<script>localStorage.setItem('nivel_usu', '$nivel')</script>";
	echo "<script>localStorage.setItem('id_empresa', '$empresa')</script>";
	//$id_teste = "<script>document.write(localStorage.id_usu)</script>";

	@$_SESSION['id_empresa'] = $empresa;
	@$_SESSION['id_usuario'] = $id;
	@$_SESSION['nivel'] = $nivel;
	

	if($nivel == 'SAS'){
		echo '<script>window.location="sas"</script>';
	}else{	

		echo '<script>window.location="sistema"</script>';
	}

}else{
	echo '<script>alert("Dados Incorretos!")</script>';
	echo '<script>window.location="index.php"</script>';
	exit();
}

 ?>