<?php

if(isset($_POST["consultaAjax"]) && $_POST["consultaAjax"] == "on"){
	
	$arrResult = array("operations" => "", "resultsOp" => "", "error" => false);
		
	if(isset($_POST["form"]) && $_POST["form"] != ""){
		
		//change the form serialized by array
		$params = array();
		parse_str($_POST["form"], $params);	
		
		//Starting new object of the class
		$operation = new operations();
		
		//Setting the var arrCube in the class 
		$operation->initialize($_POST["numMatriz"]);
		
		$totalOpr = isset($_POST["totalOperations"]) ? $_POST["totalOperations"] : 0;
		$principalId = isset($_POST["id"]) ? $_POST["id"] : 0;		
		$stringResult ="";
		
		for($i=1; $i<= $totalOpr; $i++){
			
			$operationToExecute = $params["operation_".$principalId."_".$i];
			
			if($operationToExecute == "update"){
				
				$valCoord = $params["valuePosition_".$principalId."_".$i];
				$valNewVal 	   = $params["newValuePosition_".$principalId."_".$i];
				
				$operation->update($valCoord, $valNewVal);
				
				$arrResult["operations"] .= " Update " . $valCoord . " " . $valCoord . " " .  $valCoord . " To " . $valNewVal . "</br>";
				
			} else if($operationToExecute == "query"){
					
				$valInitCoord = $params["valueFrom_".$principalId."_".$i];
				$valEndCoord  = $params["valueTo_".$principalId."_".$i];	   
				
				$getSum = $operation->setQuery($valInitCoord, $valEndCoord);
				
				$arrResult["resultsOp"]  .= $getSum . "</br>"; 
				$arrResult["operations"] .= " Query " . $valInitCoord . " " . $valInitCoord . " " .  $valInitCoord . " To " . 
												 $valEndCoord . " " . $valEndCoord . " " .  $valEndCoord . " </br>";
			} else {
				break;
			}
		}		
	}
	
	echo json_encode($arrResult);
}


class operations {    
    public $arrCube = array();
    public $x;
    public $y;
    public $z;
    public $n;
    public $m;
      
   function initialize($n)
   {		
		$this->n = $n; 

		for ($a = 1; $a<=$n; $a++){
			$this->x = $a;
			$this->y = $a;
			$this->z = $a;
				
			$this->arrCube[$this->x][$this->y][$this->z] = 0; 
		}	
	}
	
	public function update($valCoord, $valw)
	{
		$this->arrCube[$valCoord][$valCoord][$valCoord] = $valw; 
	}

	public function setQuery($valCoordA, $valCoordB)
	{			
		$sum = 0;
		
		for ($j=$valCoordA; $j<=$valCoordB; $j++){
			$sum += $this->arrCube[$j][$j][$j];
		}
		
		return $sum;
	}	
} 


?>