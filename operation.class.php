<?php

//Class Operation
class Operation
{    
	//Variables
    public $arrCube = array();
    public $x;
    public $y;
    public $z;
    public $n;
    public $m;
      
	//This function is for setting the var $arrCube in an array with value 0 for all positions
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
	
	//This Function change the value of the position given
	public function update($valCoord, $valw)
	{
		$this->arrCube[$valCoord][$valCoord][$valCoord] = $valw; 
	}

	//This function sums the values from the initial position to the last position given
	public function setQuery($valCoordA, $valCoordB)
	{			
		$addTotal = 0;
		
		for ($j=$valCoordA; $j<=$valCoordB; $j++){
			$addTotal += $this->arrCube[$j][$j][$j];
		}
		
		return $addTotal;
	}	
} 
?>