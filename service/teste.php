<?php
	$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
	$query = $conexao->query('SET CHARACTER SET utf8');
	$query = $conexao->query("SELECT usuario_has_cupom.id,usuario.nome,usuario.celular,usuario_has_cupom.preco_cupom,usuario_has_cupom.estado FROM usuario_has_cupom INNER JOIN usuario ON(usuario.id = usuario_has_cupom.usuario_id) WHERE usuario_has_cupom.cupom_id = 1");
	$dados = array();
	while($row = $query->fetch_assoc())
	{
		$celular = $row["celular"];
		$celular[strlen($celular)-1] = "X";
		$row["celular"] = $celular;
		$dados[] = $row;
	}
	$conexao->close();
	echo json_encode($dados);
?>