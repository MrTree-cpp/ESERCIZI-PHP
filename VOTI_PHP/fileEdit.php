
<?php
// modifica_valutazione.php

$messaggio = "";

// Modifica
if (isset($_POST['modifica'])) {
    // Dati vecchi (da cercare)
    $vecchio_cognome = trim($_POST['vecchio_cognome']);
    $vecchio_nome = trim($_POST['vecchio_nome']);
    $vecchio_classe = trim($_POST['vecchio_classe']);
    $vecchio_disciplina = trim($_POST['vecchio_disciplina']);
    $vecchio_data = trim($_POST['vecchio_data']);
    $vecchio_voto = trim($_POST['vecchio_voto']);
    $vecchio_tipo = trim($_POST['vecchio_tipo']);
    
    // Dati nuovi (da sostituire)
    $nuovo_cognome = trim($_POST['cognome']);
    $nuovo_nome = trim($_POST['nome']);
    $nuovo_classe = trim($_POST['classe']);
    $nuovo_disciplina = trim($_POST['disciplina']);
    $nuovo_data = trim($_POST['data_valutazione']);
    $nuovo_voto = trim($_POST['voto']);
    $nuovo_tipo = trim($_POST['tipo']);
    
    $valutazioni = [];
    $trovato = false;
    
    $file = fopen("random-grades.csv", "r");
    $prima_riga = true;
    
    while (($line = fgets($file)) !== false) {
        if ($prima_riga) {
            $prima_riga = false;
            continue;
        }
        
        $separated = explode(",", $line);
        
        // Controlla se corrisponde ai dati vecchi
        if (count($separated) >= 7 &&
            trim($separated[0]) == $vecchio_cognome &&
            trim($separated[1]) == $vecchio_nome &&
            trim($separated[2]) == $vecchio_classe &&
            trim($separated[3]) == $vecchio_disciplina &&
            trim($separated[4]) == $vecchio_data &&
            trim($separated[5]) == $vecchio_voto &&
            trim($separated[6]) == $vecchio_tipo &&
            !$trovato) {
            // Sostituisci con i nuovi dati
            $nuova_riga = $nuovo_cognome . "," . $nuovo_nome . "," . $nuovo_classe . "," . 
                         $nuovo_disciplina . "," . $nuovo_data . "," . $nuovo_voto . "," . 
                         $nuovo_tipo . "\n";
            $valutazioni[] = $nuova_riga;
            $trovato = true;
        } else {
            $valutazioni[] = $line;
        }
    }
    fclose($file);
    
    if ($trovato) {
        // Riscrivi il file con la valutazione modificata
        $file = fopen("random-grades.csv", "w");
        fwrite($file, "cognome,nome,classe,disciplina,data_valutazione,voto,tipo\n");
        foreach ($valutazioni as $val) {
            fwrite($file, $val);
        }
        fclose($file);
        
        $messaggio = "Valutazione modificata con successo!";
    } else {
        $messaggio = "Nessuna valutazione trovata con i dati specificati.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Valutazione</title>
</head>
<body>
    <h1>Modifica Valutazione</h1>
    
    <?php if ($messaggio != ""): ?>
        <p><strong><?php echo $messaggio; ?></strong></p>
    <?php endif; ?>
    
    <p>Inserisci i dati VECCHI della valutazione da modificare:</p>
    
    <form method="POST">
        <fieldset>
            <legend><strong>DATI VECCHI (da cercare)</strong></legend>
            
            <label>Cognome:</label><br>
            <input type="text" name="vecchio_cognome" required><br><br>
            
            <label>Nome:</label><br>
            <input type="text" name="vecchio_nome" required><br><br>
            
            <label>Classe:</label><br>
            <input type="text" name="vecchio_classe" required><br><br>
            
            <label>Disciplina:</label><br>
            <input type="text" name="vecchio_disciplina" required><br><br>
            
            <label>Data Valutazione:</label><br>
            <input type="date" name="vecchio_data" required><br><br>
            
            <label>Voto:</label><br>
            <input type="number" name="vecchio_voto" step="0.5" min="0" max="10" required><br><br>
            
            <label>Tipo:</label><br>
            <input type="radio" name="vecchio_tipo" value="scritto" checked> Scritto
            <input type="radio" name="vecchio_tipo" value="orale"> Orale
            <input type="radio" name="vecchio_tipo" value="pratico"> Pratico<br><br>
        </fieldset>
        
        <br>
        
        <fieldset>
            <legend><strong>DATI NUOVI (da sostituire)</strong></legend>
            
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
            <input type="radio" name="tipo" value="scritto" checked> Scritto
            <input type="radio" name="tipo" value="orale"> Orale
            <input type="radio" name="tipo" value="pratico"> Pratico<br><br>
        </fieldset>
        
        <br>
        <button type="submit" name="modifica">Modifica Valutazione</button>
        <br><br>
        <a href="file.php">Torna alla pagina principale</a>
    </form>
</body>
</html>