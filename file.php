<?php
// Ottengo i dati dal form
$cognome = "";
$classe = "";
$materia = "";
$risultato = "";

if (isset($_POST['cognome'])) {$cognome = $_POST['cognome'];}
if (isset($_POST['classe'])) {$classe = $_POST['classe'];}
if (isset($_POST['materia'])) {$materia = $_POST['materia'];}

// Apro file
$file = fopen("random-grades.csv", "r");

// ========================
// FUNZIONI
// ========================

function MediaStudente($studente, $file) {
    $media = 0;
    $voti = 0;
    rewind($file);
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);
        if ($separated[0] == $studente) {
            $media += $separated[5];
            $voti++;
        }
    }

    if ($voti > 0) {
        $media = $media / $voti;
        return $media;
    } else {
        return null;
    }
}

function MediaStudenteMateria($studente, $materia, $file) {
    $media = 0;
    $voti = 0;
    rewind($file);
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);
        if (($separated[0] == $studente) && ($separated[3] == $materia)) {
            $media += $separated[5];
            $voti++;
        }
    }

    if ($voti > 0) {
        $media = $media / $voti;
        return $media;
    } else {
        return null;
    }
}

function MediaStudenteMateriaClasse($studente, $materia, $classe, $file) {
    $media = 0;
    $voti = 0;
    rewind($file);
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);
        if (($separated[0] == $studente) && ($separated[3] == $materia) && ($separated[2] == $classe)) {
            $media += $separated[5];
            $voti++;
        }
    }

    if ($voti > 0) {
        $media = $media / $voti;
        return $media;
    } else {
        return null;
    }
}

function MediaMateria($materia, $file) {
    $media = 0;
    $voti = 0;
    rewind($file);
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);
        if ($separated[3] == $materia) {
            $media += $separated[5];
            $voti++;
        }
    }

    if ($voti > 0) {
        $media = $media / $voti;
        return $media;
    } else {
        return null;
    }
}

function MediaMateriaClasse($materia, $classe, $file) {
    $media = 0;
    $voti = 0;
    rewind($file);
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);
        if (($separated[3] == $materia) && ($separated[2] == $classe)) {
            $media += $separated[5];
            $voti++;
        }
    }

    if ($voti > 0) {
        $media = $media / $voti;
        return $media;
    } else {
        return null;
    }
}

function MediaClasse($classe, $file) {
    $media = 0;
    $voti = 0;
    rewind($file);
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);
        if ($separated[2] == $classe) {
            $media += $separated[5];
            $voti++;
        }
    }

    if ($voti > 0) {
        $media = $media / $voti;
        return $media;
    } else {
        return null;
    }
}

// ========================
// LOGICA PRINCIPALE
// ========================

if ($cognome != "" && $materia != "" && $classe != "") {
    $risultato = MediaStudenteMateriaClasse($cognome, $materia, $classe, $file);
} else if ($cognome != "" && $materia != "") {
    $risultato = MediaStudenteMateria($cognome, $materia, $file);
} else if ($cognome != "") {
    $risultato = MediaStudente($cognome, $file);
} else if ($materia != "" && $classe != "") {
    $risultato = MediaMateriaClasse($materia, $classe, $file);
} else if ($materia != "") {
    $risultato = MediaMateria($materia, $file);
} else if ($classe != "") {
    $risultato = MediaClasse($classe, $file);
}

// Chiudo il file
fclose($file);

// ========================
// GESTIONE RISULTATO
// ========================

if ($risultato === null) {
    $risultato = "Nessun risultato trovato";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>VOTI PHP</title>
</head>

<body>
    <form action="file.php" method="post">
        <input type="text" name="cognome" placeholder="Cognome Studente"><br>
        <input type="text" name="classe" placeholder="Classe"><br>
        <input type="text" name="materia" placeholder="Materia"><br>
        <button type="submit" name="send">Invia</button><br><br>

        <input type="text" name="risultato" readonly value="<?php echo $risultato; ?>">
    </form>
</body>
</html>
