<?php

$morse = ''; $text = '';

// Alphabet letter => Morse code
$CharToMorse = array(
    'A' => '.-',
    'B' => '-...',
    'C' => '-.-.',
    'D' => '-..',
    'E' => '.',
    'F' => '..-.',
    'G' => '--.',
    'H' => '....',
    'I' => '..',
    'J' => '.---',
    'K' => '-.-',
    'L' => '.-..',
    'M' => '--',
    'N' => '-.',
    'O' => '---',
    'P' => '.--.',
    'Q' => '--.-',
    'R' => '.-.',
    'S' => '...',
    'T' => '-',
    'U' => '..-',
    'V' => '...-',
    'W' => '.--',
    'X' => '-..-',
    'Y' => '-.--',
    'Z' => '--..'
);

// Morse code => Alphabet letter
$morseToChar = array(
    '.-' => 'A',
    '-...' => 'B',
    '-.-.' => 'C',
    '-..' => 'D',
    '.' => 'E',
    '..-.' => 'F',
    '--.' => 'G',
    '....' => 'H',
    '..' => 'I',
    '.---' => 'J',
    '-.-' => 'K',
    '.-..' => 'L',
    '--' => 'M',
    '-.' => 'N',
    '---' => 'O',
    '.--.' => 'P',
    '--.-' => 'Q',
    '.-.' => 'R',
    '...' => 'S',
    '-' => 'T',
    '..-' => 'U',
    '...-' => 'V',
    '.--' => 'W',
    '-..-' => 'X',
    '-.--' => 'Y',
    '--..' => 'Z'
);

// Decido quale azione intraprendere
if (isset($_POST['action']) && $_POST['action'] === 'std_a_morse') {
    $text = $_POST['clear'];
    $morse = '';
    $char = $_POST['clear'];

    // Conversione
    foreach (str_split($char) as $toConvert) 
    {
        // Se leggo uno spazio, metto lo spazio anche nel morse
        if ($toConvert == ' ') 
        {
            $morse .= '/';
        }
        // Altrimenti metto il carattere corrispondente in morse
        else 
        {
        // Adesso cerco il corrispondente nel dizionario
        foreach ($CharToMorse as $key => $value)
        {
            if ($toConvert == $key) 
            {
                $morse .= $value.' ';
            }
        }
        }
    }


}
else if (isset($_POST['action']) && $_POST['action'] === 'morse_a_std') {
    // Estraggo la stringa in morse
    $temp = $_POST['morse'];

    // Divido la stringa Morse in parole
    $paroleMorse = explode("/", $temp);
    $risultato = [];

    foreach ($paroleMorse as $toSplit) {
        $char = explode(' ', trim($toSplit)); // Rimuove spazi extra
        $parolaTradotta = '';

        foreach ($char as $toConvert) {
            if (isset($morseToChar[$toConvert])) {
                $lettera = $morseToChar[$toConvert];
            } else {
                $lettera = '?'; // simbolo non riconosciuto
            }
            $parolaTradotta .= $lettera;
        }

        $risultato[] = $parolaTradotta;
    }

    $text = implode(' ', $risultato);
}


?>

<!DOCTYPE hmtl>
<html>

<head>
    <meta charset="UTF-8"> 
    <title>Traduttore codice morse</title>
</head>

<body>
    <form action="morse.php" method="post">
        <input type="text" name="clear" placeholder="testo in chiaro" value="<?php echo $text; ?>">
        <button type="submit" name="action" value="std_a_morse">std a morse</button><br>
        <input type="text" name="morse" placeholder ="codice morse"value="<?php echo $morse; ?>">
        <button type="submit" name="action" value="morse_a_std">morse a std</button>
    </form>
</body>

</html>