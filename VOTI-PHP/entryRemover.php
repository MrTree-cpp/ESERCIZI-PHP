<?php
// elimina_valutazione.php

$messaggio = "";

// Eliminazione
if (isset($_POST['elimina'])) {
    $cognome = trim($_POST['cognome']);
    $nome = trim($_POST['nome']);
    $classe = trim($_POST['classe']);
    $disciplina = trim($_POST['disciplina']);
    $data = trim($_POST['data_valutazione']);
    $voto = trim($_POST['voto']);
    $tipo = trim($_POST['tipo']);
    
    $valutazioni = [];
    $trovato = false;
    
    $file = fopen("random-grades.csv", "r");
    $header = fgets($file); // Salva l'header
    
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);
        
        // Controlla se corrisponde a tutti i campi
        if (count($separated) >= 7 &&
            trim($separated[0]) == $cognome &&
            trim($separated[1]) == $nome &&
            trim($separated[2]) == $classe &&
            trim($separated[3]) == $disciplina &&
            trim($separated[4]) == $data &&
            trim($separated[5]) == $voto &&
            trim($separated[6]) == $tipo &&
            !$trovato) 
        {
            // Salta questa riga (non aggiungerla all'array)
            $trovato = true;
            continue;
        }
        
        $valutazioni[] = $line;
    }
    fclose($file);
    
    if ($trovato) {
        // Riscrivi il file senza la valutazione eliminata
        $file = fopen("random-grades.csv", "w");
        fwrite($file, $header); // Scrivi l'header originale
        foreach ($valutazioni as $val) {
            fwrite($file, $val);
        }
        fclose($file);
        
        $messaggio = "Valutazione eliminata con successo!";
    } else {
        $messaggio = "Nessuna valutazione trovata con i dati specificati.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Elimina Valutazione</title>
</head>
<body>
    <h1>Elimina Valutazione</h1>
    
    <?php if ($messaggio != ""): ?>
        <p><strong><?php echo $messaggio; ?></strong></p>
    <?php endif; ?>
    
    <p>Inserisci tutti i dati della valutazione da eliminare:</p>
    
    <form method="POST">
        <label>Cognome:</label><br>
        <input type="text" name="cognome" required><br><br>
        
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>
        
        <label>Classe:</label><br>
        <input type="text" name="classe" required><br><br>
        
        <label>Disciplina:</label><br>
        <input type="text" name="disciplina" required><br><br>
        
        <label>Data Valutazione:</label><br>
        <input type="date" name="data_valutazione" required><br><br>
        
        <label>Voto:</label><br>
        <input type="number" name="voto" step="0.5" min="0" max="10" required><br><br>
        
        <label>Tipo:</label><br>
        <input type="radio" name="tipo" value="scritto" checked> Scritto<br>
        <input type="radio" name="tipo" value="orale"> Orale<br>
        <input type="radio" name="tipo" value="pratico"> Pratico<br><br>
        
        <button type="submit" name="elimina">Elimina Valutazione</button>
        <br><br>
        <a href="main.php">Torna alla pagina principale</a>
    </form>
</body>
</html>