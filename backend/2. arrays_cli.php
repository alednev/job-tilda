<?php

/**
 * Нужно заполнить массив 5 на 7 случайными уникальными числами от 1 до 1000.
 * Вывести получившийся массив и суммы по строкам и по столбцам.
 */

$cols   = 5;
$rows   = 7;
$matrix = [];

// заполнение двумерного массива случайными числами
for ($i = 0; $i < $rows; $i++) {
    for ($j = 0; $j < $cols; $j++) {
        $matrix[$i][$j] = random_int(1, 1000);
    }
}

// вывод двумерного массива на экран
for ($row = 0; $row < $rows; $row++) {
    for ($col = 0; $col < $cols; $col++) {
        echo ' ' . $matrix[$row][$col];
    }

    // подсчет суммы в ряду
    echo ' row sum=' . array_sum($matrix[$row]);
    echo PHP_EOL;
}

// подсчет суммы в столбце
for ($col = 0; $col < $cols; $col++) {
    echo ' col sum=' . array_sum(array_column($matrix, $col));
}

echo PHP_EOL;
