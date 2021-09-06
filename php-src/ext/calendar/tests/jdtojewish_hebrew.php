<?php
for ($year = 5000; $year <= 5001; $year++) {
    $leap = ($year === 5001) ? 'leap' : 'normal';
    echo "$leap year $year\n";
    for ($month = 1; $month <= 13; $month++) {
        $jd = jewishtojd($month, 1, $year);
        $hebrew = jdtojewish($jd, true);
        $hex = bin2hex($hebrew);
        echo "$hex\n";
    }
    echo "\n";
}
?>
===DONE===
