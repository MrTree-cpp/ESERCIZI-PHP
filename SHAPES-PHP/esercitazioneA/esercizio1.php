<?php

// Definizione delle funzioni di stampa

// Quadrato
function printQuad ($lenght) 
{
    for ($i = 0; $i < $lenght; $i++)
    {
        for ($j = 0; $j < $lenght; $j++) 
        {
            echo '*';
        }

        echo "<br>";
    }   
}
// Cornice
function printFrame($lenght) 
{
    if ($lenght < 7) {
        echo "Il lato inserito è troppo corto.";
        return;
    }

    echo "<pre>"; 
    
    $inner = 2; 

    for ($i = 0; $i < $lenght; $i++) {
        for ($j = 0; $j < $lenght; $j++) {
            if ($i == 0 || $i == $lenght - 1 || $j == 0 || $j == $lenght - 1) {
                echo '*';
            }
            else if (($i == $inner || $i == $lenght - 1 - $inner) && ($j >= $inner && $j <= $lenght - 1 - $inner)) {
                echo '*';
            }
            else if (($j == $inner || $j == $lenght - 1 - $inner) && ($i >= $inner && $i <= $lenght - 1 - $inner)) {
                echo '*';
            }
            else {
                echo ' ';
            }
        }
        echo "\n";
    }
    
    echo "</pre>"; 
}

// Triangolo con la punta in alto
function printTriDown ($lenght) 
{
    for ($i = $lenght; $i > 0; $i--) {
        for ($j = 1; $j <= $i; $j++) {
            echo '*';
        }
        echo "<br>";
    }
}

// Triangolo con la punta in basso
function printTriUp ($lenght) 
{
    for ($i = 1; $i <= $lenght; $i++) {
        for ($j = 1; $j <= $i; $j++) {
            echo '*';
        }
        echo "<br>"; 
    }
}

// Recupero le informazioni dal form
$figura = $_POST['choice'];
$lato = $_POST['n'];

// Invoco la funzione giusta
if ($figura == "quad") {printQuad($lato);}
else if ($figura == "frame") {printFrame($lato);}
else if ($figura == "tri_dw") {printTriDown($lato);}
else if ($figura == "tri_up") {printTriUp($lato);}
?>

<!-- LINK PER TORNARE INDIETRO -->
<a href="esercizio1.html">Torna indietro</a>