<?php

include("operation.class.php");

if(isset($_POST["consultaAjax"]) && $_POST["consultaAjax"] == "on"){
	
	$arrResult = array("operations" => "", "resultsOp" => "", "error" => false);
		
	if(isset($_POST["form"]) && $_POST["form"] != ""){
		
		//change the form serialized by array
		$params = array();
		parse_str($_POST["form"], $params);	
		
		//Starting new object of the class
		$operation = new Operation();
		
		//Setting the var arrCube in the class 
		$operation->initialize($_POST["numMatriz"]);
		
		$totalOpr = isset($_POST["totalOperations"]) ? $_POST["totalOperations"] : 0;
		$principalId = isset($_POST["id"]) ? $_POST["id"] : 0;		
		$stringResult ="";
		
		for($i=1; $i<= $totalOpr; $i++){
			
			$operationToExecute = isset($params["operation_".$principalId."_".$i]) ? $params["operation_".$principalId."_".$i] : "";
			
			if($operationToExecute == "update"){
				
				$valCoord  = isset($params["valuePosition_".$principalId."_".$i]) ? $params["valuePosition_".$principalId."_".$i] : "";
				$valNewVal = isset($params["newValuePosition_".$principalId."_".$i]) ? $params["newValuePosition_".$principalId."_".$i] : "";
				
				if($valCoord != "" && $valNewVal != ""){
					$operation->update($valCoord, $valNewVal);
				
					$arrResult["operations"] .= " Update " . $valCoord . " " . $valCoord . " " .  $valCoord . " To " . $valNewVal . "</br>";
				}else{
					$arrResult["error"] = true;
				}
				
			} else if($operationToExecute == "query"){
					
				$valInitCoord = isset($params["valueFrom_".$principalId."_".$i])  ? $params["valueFrom_".$principalId."_".$i] : "";
				$valEndCoord  = isset($params["valueTo_".$principalId."_".$i]) ? $params["valueTo_".$principalId."_".$i] : "";	   
				
				if($valInitCoord != "" && $valEndCoord != ""){
					$getSum = $operation->setQuery($valInitCoord, $valEndCoord);
				
					$arrResult["resultsOp"]  .= $getSum . "</br>"; 
					$arrResult["operations"] .= " Query " . $valInitCoord . " " . $valInitCoord . " " .  $valInitCoord . " To " . 
												 $valEndCoord . " " . $valEndCoord . " " .  $valEndCoord . " </br>";
				}else{
					$arrResult["error"] = true;
				}
				
			} else {
				break;
			}
		}		
	}
	
	echo json_encode($arrResult);
}

?>