<?php

$n1 = $_POST['n1'];
$n2 = $_POST['n2'];

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
while ($n1 < $n2) 
{
   //Per ogni numeor guardo se è primo
   if (isPrime($n1)) 
   {
    echo "$n1 e' un numero primo";
    echo "<br>";
   }
   $n1++;
}

?>