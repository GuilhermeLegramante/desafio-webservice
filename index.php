<?php
	
	$url_prices = "https://challenge-for-adventurers.herokuapp.com/data/5e342ebd989a050014c61e87/prices";
	$json_prices = file_get_contents($url_prices);
	$prices = json_decode($json_prices, TRUE);

	$url_supplies = "https://challenge-for-adventurers.herokuapp.com/data/5e342ebd989a050014c61e87/supplies";
	$json_supplies = file_get_contents($url_supplies);
	$supplies = json_decode($json_supplies, TRUE);

	$url_spents = "https://challenge-for-adventurers.herokuapp.com/data/5e342ebd989a050014c61e87/spents";
	$json_spents = file_get_contents($url_spents);
	$spents = json_decode($json_spents, TRUE);

	function calculaTotalLitros($valorAbastecido, $precoLitro){
		$total = $valorAbastecido/$precoLitro;
		return $total;
	}

	function calculaCombustivelGasto($distancia){
		$gasto = $distancia/12;
		return $gasto;
	}


	foreach ($supplies as $key => $supply) {
		$aux = strtotime(str_replace("/","-",$supply['date']));
		$supplyDate = date('Y-m-d',$aux);
		$supplyDateTS = strtotime($supplyDate);
		$supplyValue = $supply['value'];
		
		foreach ($prices as $key => $price) {
			$aux2 = strtotime(str_replace("/","-",$price['date']));
			$priceDate = date('Y-m-d',$aux2);
			$priceDateTS = strtotime($priceDate);

			if($priceDateTS <= $supplyDateTS){
				$priceValue = $price['value'];
			} 
		}

		foreach ($spents as $key => $spent) {
			$aux3 = strtotime(str_replace("/","-",$spent['date']));
			$spentDate = date('Y-m-d',$aux3);
			$spentDateTS = strtotime($spentDate);
			
			if($spentDateTS == $supplyDateTS){
				$spentValue = $spent['value'];
				$combustivelGasto = calculaCombustivelGasto($spentValue);
			}
		}

		$totalLitros = calculaTotalLitros($supplyValue, $priceValue);
		$totalLitros = number_format($totalLitros, 2, '.', '');
		$saldo = $totalLitros - $combustivelGasto;
		echo "Data Abastecimento: " . $supplyDate . " Valor/Litro: " . $priceValue . " Total Litros abastecidos: " . $totalLitros . " Distância percorrida: " . $spentValue ."km " . "Saldo no tanque: ". $saldo ."<br/>"; 

	}

	$postfields = array('date'=>'30/01/2017', 'value'=>5);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://challenge-for-adventurers.herokuapp.com/check?id=5e342ebd989a050014c61e87');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	// Edit: prior variable $postFields should be $postfields;
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
	$result = curl_exec($ch);

	print_r($result);
