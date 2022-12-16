<?php

/**
 * Нужно вывести лесенкой числа от 1 до 100.
 */

$numbers = range(1, 100);

$currentNumber = 0;
$numbersCount  = count($numbers);
$output        = '';

for ($i = 0; $i <= $numbersCount; $i++) {

    for ($k = $i; $k >= 0; $k--) {

        if ($currentNumber <= $numbersCount) {
            $output .= $numbers[$currentNumber++] . ' ';
        }

    }

    $output .= PHP_EOL;
}

echo trim($output);
