<?php
// Ottengo i dati dal form
$cognome = "";
$classe = "";
$materia = "";
$risultato = "";

//cognome,nome,classe,disciplina,data_valutazione,voto,tipo
$cognome = isset($_POST['cognome']) ? trim($_POST['cognome']) : "";
$classe   = isset($_POST['classe'])  ? trim($_POST['classe'])  : "";
$materia  = isset($_POST['materia']) ? trim($_POST['materia']) : "";
$tipo_media = isset($_POST['tipo_media']) ? trim($_POST['tipo_media']) : 'media_generale';


// Apro file
$file = fopen("random-grades.csv", "r");

// ========================
// FUNZIONI
// ========================

// Restituisce Array associativo (Di uno studente) array[materie][array[voti]]
function getVotiMaterie ($studente, $file)
{
    $votiMateria = [];
    rewind($file);
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);

        // Se sono sullo studente che mi interessa
        if($separated[0] == $studente) 
            {
            // Ottengo voto e materia
            $materia = $separated[3];
            $voto = $separated[5];

            // Aggiungo la materia all'array
            if(!isset($votiMateria[$materia])) // Se la materia non esiste aggiungila
            {
                $votiMateria[$materia] = []; //Aggiungi materia                
            }

            $votiMateria[$materia][] = $voto; // Aggiungi voto sempre
        }
    }

    return $votiMateria;
}

function calcolaVotiMateria($votiMateria)
{
    $media_per_materia = [];

    // Scorro tutte le materie
    foreach ($votiMateria as $materia => $voti)
    {
        $temp = 0; // azzero la somma dei voti per questa materia

        // Sommo tutti i voti della materia
        foreach ($voti as $voto)
        {
            $temp += $voto;
        }

        // Calcolo la media della materia
        if (count($voti) > 0)
        {
            $media_per_materia[$materia] = $temp / count($voti);
        }
        else
        {
            $media_per_materia[$materia] = 0; // nessun voto
        }
    }

    return $media_per_materia;
}

// Restituisce Array associativo (Di una classe) array[materie][array[voti]]
function getVotiMaterieClasse ($classe, $file)
{
    $votiMateria = [];
    rewind($file);
    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);

        // Se sono sullo studente che mi interessa
        if($separated[2] == $classe) 
            {
            // Ottengo voto e materia
            $materia = $separated[3];
            $voto = $separated[5];

            // Aggiungo la materia all'array
            if(!isset($votiMateria[$materia])) // Se la materia non esiste aggiungila
            {
                $votiMateria[$materia] = []; //Aggiungi materia                
            }

            $votiMateria[$materia][] = $voto; // Aggiungi voto sempre
        }
    }

    return $votiMateria;
}

function calcolaVotiMateriaClasse($votiMateria)
{
    $media_per_materia = [];

    // Scorro tutte le materie
    foreach ($votiMateria as $materia => $voti)
    {
        $temp = 0; // azzero la somma dei voti per questa materia

        // Sommo tutti i voti della materia
        foreach ($voti as $voto)
        {
            $temp += $voto;
        }

        // Calcolo la media della materia
        if (count($voti) > 0)
        {
            $media_per_materia[$materia] = $temp / count($voti);
        }
        else
        {
            $media_per_materia[$materia] = 0; // nessun voto
        }
    }

    return $media_per_materia;
}

////////////////////////////////////////////// TABELLONE SPERIMENTALE /////////////////////////////////////////////

function getVotiMaterieTabellone ($classe, $file)
{
    $votiStudenti = [];
    rewind($file);

    while (($line = fgets($file)) !== false) {
        $separated = explode(",", $line);

        // Se sono sulla classe che mi interessa
        if($separated[2] == $classe) 
        {
            // Ottengo studente, materia e voto
            $studente = $separated[0];
            $materia = $separated[3];
            $voto = $separated[5];

            // Aggiungo lo studente all'array se non esiste
            if(!isset($votiStudenti[$studente])) 
            {
                $votiStudenti[$studente] = [];
            }

            // Aggiungo la materia se non esiste per questo studente
            if(!isset($votiStudenti[$studente][$materia]))
            {
                $votiStudenti[$studente][$materia] = [];
            }

            $votiStudenti[$studente][$materia][] = $voto; // Aggiungi voto
        }
    }

    return $votiStudenti;
}

function calcolaVotiMateriaTabellone($votiStudenti)
{
    $medie_studenti = [];

    // Scorro tutti gli studenti
    foreach ($votiStudenti as $studente => $materie)
    {
        $medie_studenti[$studente] = [];
        
        // Scorro tutte le materie dello studente
        foreach ($materie as $materia => $voti)
        {
            $temp = 0;
            
            // Sommo tutti i voti della materia
            foreach ($voti as $voto)
            {
                $temp += $voto;
            }

            // Calcolo la media della materia per lo studente
            if (count($voti) > 0)
            {
                $medie_studenti[$studente][$materia] = $temp / count($voti);
            }
            else
            {
                $medie_studenti[$studente][$materia] = 0;
            }
        }
        
        // Calcolo la media generale dello studente
        $somma_medie = 0;
        $num_materie = count($medie_studenti[$studente]);
        
        foreach ($medie_studenti[$studente] as $media_materia)
        {
            $somma_medie += $media_materia;
        }
        
        if ($num_materie > 0)
        {
            $medie_studenti[$studente]['MEDIA_GENERALE'] = $somma_medie / $num_materie;
        }
    }

    return $medie_studenti;
}

////////////////////////////////////////////////////////////////////////////////////////////////

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
} 

else if ($cognome != "" && $materia != "") {
    $risultato = MediaStudenteMateria($cognome, $materia, $file);
} 

else if ($cognome != "") {

    if ($tipo_media == 'media_generale') 
    {
        $risultato = MediaStudente($cognome, $file);
    } 

    else if ($tipo_media == 'media_per_materia') 
    {
        // Media generale già calcolata dalla funzione
        $media_generale = MediaStudente($cognome, $file);

        // Ottieni voti per materia e calcola medie
        $votiMateria = getVotiMaterie($cognome, $file);
        $medie_per_materia = calcolaVotiMateria($votiMateria);

        // Creo la stringa risultato
        $risultato = $media_generale;
        foreach ($medie_per_materia as $materia => $media) {
            echo "$materia: $media<br>";
        }
    }
} 

else if ($materia != "" && $classe != "") {
    $risultato = MediaMateriaClasse($materia, $classe, $file);
} 

else if ($materia != "") {
    $risultato = MediaMateria($materia, $file);
}

else if ($classe != "") {
    if ($tipo_media == 'media_generale') 
    {
        $risultato = MediaClasse($classe, $file);
    } 
    
    else if ($tipo_media == 'media_per_materia') 
    {
        // Media generale già calcolata dalla funzione
        $media_generale = MediaClasse($classe, $file);

        // Ottieni voti per materia e calcola medie
        $votiMateria = getVotiMaterieClasse($classe, $file);
        $medie_per_materia = calcolaVotiMateriaClasse($votiMateria);
     
        // Crea tabella HTML -- GRAZIE CLAUDE PER L'AIUTO
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Materia</th><th><strong>MEDIA</strong></th></tr>";
        // Righe materie
        foreach ($medie_per_materia as $materia => $media) {
            echo "<tr>";
            echo "<td><strong>$materia</strong></td>";
            echo "<td>" . number_format($media, 2) . "</td>";
            echo "</tr>";
        }
        }
       
    }
    


    else if ($tipo_media == 'tabellone_classe') // -- GRAZIE CLAUDE PER L'AIUTO
    {
        // Ottieni voti per studente e materia
        $votiStudenti = getVotiMaterieTabellone($classe, $file);
        $medie_studenti = calcolaVotiMateriaTabellone($votiStudenti);
        
        // Ottieni tutte le materie presenti
        $tutte_materie = [];
        foreach ($medie_studenti as $studente => $materie) {
            foreach ($materie as $materia => $media) {
                if ($materia != 'MEDIA_GENERALE' && !in_array($materia, $tutte_materie)) {
                    $tutte_materie[] = $materia;
                }
            }
        }
        sort($tutte_materie);
        
        // Crea tabella HTML -- GRAZIE CLAUDE PER L'AIUTO
        echo "<h2>Tabellone Classe: $classe</h2>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Studente</th>";
        
        // Intestazioni materie
        foreach ($tutte_materie as $materia) {
            echo "<th>$materia</th>";
        }
        echo "<th><strong>MEDIA</strong></th></tr>";
        
        // Righe studenti
        foreach ($medie_studenti as $studente => $materie) {
            echo "<tr><td><strong>$studente</strong></td>";
            
            foreach ($tutte_materie as $materia) {
                if (isset($materie[$materia])) {
                    echo "<td>" . number_format($materie[$materia], 2) . "</td>";
                } else {
                    echo "<td>-</td>";
                }
            }
            
            // Use the correct key for MEDIA_GENERALE if it exists, otherwise show '-'
            if (isset($materie['MEDIA_GENERALE'])) {
                echo "<td><strong>" . number_format($materie['MEDIA_GENERALE'], 2) . "</strong></td>";
            } else {
                echo "<td>-</td>";
            }
            echo "</tr>";
        }
        
        echo "</table>";
        
        $risultato = "Tabellone visualizzato sopra";
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

        <label>Tipo di media:</label><br>
        <input type="radio" name="tipo_media" value="media_generale" checked> Media Generale<br>
        <input type="radio" name="tipo_media" value="media_per_materia"> Media per Materia<br>
        <input type="radio" name="tipo_media" value="tabellone_classe"> Tabellone per Classe<br>

        <button type="submit" name="send">Invia</button><br><br>

        <input type="text" name="risultato" readonly value="<?php echo $risultato; ?>">
    </form>
</body>
</html>
