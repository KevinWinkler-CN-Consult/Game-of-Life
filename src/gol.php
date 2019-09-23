<?php

$field = array();
$size = 52;
$birth = [3];
$survival = [2,3];

for($y = 0; $y< $size; $y++)
{
	for($x = 0; $x < $size; $x++)
	{
		$field[$y][$x] = 0;
	}
}

for($y = 1; $y < $size-1; $y++)
{
	for($x = 1; $x < $size-1; $x++)
	{
		$field[$y][$x] = (int)rand(0,1);
	}
}

function printField($_field)
{
	global $size;
	
	for($y = 0; $y < $size; $y++)
	{
		for($x = 0; $x < $size; $x++)
			echo $_field[$y][$x] ? "O" : " ";
		echo "\n";
	}
}

function nextGeneration(&$_field)
{
	global $size;
	global $birth;
	global $survival;
	$buffer = array();
	
	for($y = 0; $y < $size; $y++)
		for($x = 0; $x < $size; $x++)
			$buffer[$y][$x] = 0;
		
	for($y = 1; $y < $size-1; $y++)
	{
		for($x = 1; $x < $size-1; $x++)
		{
			$indecies = [ [-1,-1], [0,-1], [1,-1], [-1,0], [1,0], [-1,1], [0,1], [1,1] ];
			$neighbourCount = 0;
			
			for($i = 0; $i<8 ;$i++)
				if($_field[$y+$indecies[$i][0]][$x+$indecies[$i][1]] == 1)
					$neighbourCount++;
			
			foreach($birth as $b)
				if($neighbourCount == $b)
					$buffer[$y][$x] = 1;
					
			foreach($survival as $s)
				if($neighbourCount == $s && $_field[$y][$x] == 1)
					$buffer[$y][$x] = 1;
		}
	}
	
	for($x = 0; $x < $size; $x++)
		for($y = 0; $y < $size; $y++)
			$_field[$x][$y] = $buffer[$x][$y];
}



printField($field);
for( $i = 0; $i < 10;$i++)
{
echo "Next Gen\n";
nextGeneration($field);
printField($field);
}