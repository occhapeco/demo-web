<?php
	function call($data)
	{
		$postdata = http_build_query($data);

		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $postdata
		    )
		);

		$context  = stream_context_create($opts);

		return file_get_contents("http://clubedeofertas.net/rest/api.php", false, $context);
	}

	$data = array(
        "token"=>"40a171806a09f910ede2f842be9d25f7cbae5141",
        "classe"=>"usuario",
        "metodo"=>"select_cupons",
        "usuario_id"=>1,
        "cidade_id"=>1,
        "delivery"=>0,
        "pagamento"=>0,
        "tipo_id"=>"[]"
    );

    echo call($data);
?>