<?php

$n = $_POST['n'];

function isPrime ($n) 
{
    if ($n <= 1) return false;

    for ($i = 2; $i < $n; $i++)
    {
        if ($n % $i == 0) {
            return false; 
        }
    }
    return true;
}

//Stampo gli n numeri primi
$val = 0;
$i = 0;
while ($i < $n) 
{
    $val++;
   //Per ogni numeor guardo se è primo
   if (isPrime($val)) 
   {
    $i++;
    echo "$val e' un numero primo";
    echo "<br>";
   }
}

?>