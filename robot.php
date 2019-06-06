<?php
//Entradas
$array[][1] =   8;
$array[][0] =   2;
$array[]['M'] = 5;
$array[]['R'] = 0;
$array[]['M'] = 1;
$array[]['L'] = 0;
$array[]['M'] = 3;
$array[]['L'] = 0;
$array[]['L'] = 0;
$array[]['M'] = 3;

//Tamanho da Matriz
$t = 10;

for($i=$t; $i>=0; $i--){	
	
	for($j=0; $j<=$t; $j++){
		
		$x = $j;
		$y = $i;
		
		$result = "[".str_pad($x, 2, "0", STR_PAD_LEFT).",".str_pad($y, 2, "0", STR_PAD_LEFT)."]";
		

		foreach($array as $key => $arr){
			
			foreach($arr as $k => $value){
				
				if(!is_string($k)){
					
					if($k == $x && $value == $y){
						
						
						$obs[$x] = $y;
						
						
						$result = '[X,X]';
					
					}
					
				}else{
					
				$MV[$key] = array($k=>$value);
				
				}
				

			}
			
		}

				
		echo $result;		

	
	}
	
	echo "<br>";
}



//print_r($MV);


echo "<br><br><br>";


$x = 0;

$y = 0;

$d = "N";

$nd = $d;

foreach($MV as $kr => $vr){

	foreach($vr as $k => $v){
		
		if($k == 'M'){
			echo "novo valor $d  $v ($x, $y) <br>";
			switch ($d) {
				case 'N':
					$nv = $y + $v;					
					for($y; $y<=$nv; $y++){			
							foreach($obs as $key =>$value){
								if($x == $key && $y == $value){					
									echo "break <br>";
									break 2; 
								}
							}
					}
					$y = $y-1;
					$rx[] = $x;
					$ry[] = $y;
					echo "$x,$y <br>";
				break;
				case 'E':
					$nv = $x + $v;
					for($x; $x<=$nv; $x++){				
							foreach($obs as $key =>$value){
								if($x == $key && $y == $value){
									echo "break <br>";
									break 2;
								}
							}
					}
					$x = $x-1;
					$rx[] = $x;
					$ry[] = $y;
					echo "$x,$y <br>";
				break;
				case 'S':
					$nv = $y - $v;
					for($y; $y>=$nv; $y--){	
							foreach($obs as $key =>$value){
								if($x == $key && $y == $value){
									echo "break <br>";
									break 2; 
								}
							}
					}
					$y = $y + 1;
					$rx[] = $x;
					$ry[] = $y;
					echo "$x,$y <br>";
				break;
				case 'W':
					$nv = $x - $v;
					for($x; $x>=$nv; $x--){			
							foreach($obs as $key =>$value){
								if($x == $key && $y == $value){
									echo "break <br>";
									break 2; 
								}
							}
					}
					$x = $x +1;
					$rx[] = $x;
					$ry[] = $y;
					echo "$x,$y <br>";
				break;
			}
		}else{
			if($k == 'R'){	
				switch ($d) {
					case 'N':
						$nd = 'E';
					break;
					case 'E':
						$nd = 'S';
					break;
					case 'S':
						$nd = 'W';
					break;
					case 'W':
						$nd = 'E';
					break;
				}
			}
			
			if($k == 'L'){		
				switch ($d) {
					case 'N':
						$nd = 'W';
					break;
					case 'E':
						$nd = 'N';
					break;
					case 'S':
						$nd = 'E';
					break;
					case 'W':
						$nd = 'S';
					break;
				}
			}
			
			$d = $nd;
		
		}
	}
}

array_multisort($rx, $ry);

$rx = end($rx);
$ry = end($ry);
echo "maior distancia (".$rx.",".$ry.")";
echo "<br> ultima posição: ($x,$y)";
