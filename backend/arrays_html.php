<?php

/**
 * Нужно заполнить массив 5 на 7 случайными уникальными числами от 1 до 1000.
 * Вывести получившийся массив и суммы по строкам и по столбцам.
 */

$cols   = 5;
$rows   = 7;
$matrix = [];

// заполнение массива случайными числами
for ($i = 0; $i < $rows; $i++) {
    for ($j = 0; $j < $cols; $j++) {
        $matrix[$i][$j] = random_int(1, 1000);
    }
}

// грязный лайфхак - так не надо делать
echo '<table border="1">';
echo '<th>';
echo '<td></td><td></td><td></td><td></td><td></td><td>rowsum</td>';
echo '</th>';

// вывод массива на экран
for ($row = 0; $row < $rows; $row++) {
    echo '<tr>';
    echo '<td></td>';
    for ($col = 0; $col < $cols; $col++) {
        echo '<td>';
        echo $matrix[$row][$col];
        echo '</td>';
    }

    // подсчет суммы в ряду
    echo '<td>' . array_sum($matrix[$row]) . '</td>';
    echo '</tr>';
}

echo '<td>colsum</td>';
// подсчет суммы в столбце
for ($col = 0; $col < $cols; $col++) {
    echo '<td>' . array_sum(array_column($matrix, $col)) . '</td>';
}

echo '</table>';
