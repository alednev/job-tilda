<?php

/**
 * Нужно заполнить массив 5 на 7 случайными уникальными числами от 1 до 1000.
 * Вывести получившийся массив и суммы по строкам и по столбцам.
 */

$cols   = 7;
$rows   = 5;
$matrix = [];

// заполнение массива случайными числами
for ($i = 0; $i < $rows; $i++) {
    for ($j = 0; $j < $cols; $j++) {
        $matrix[$i][$j] = random_int(1, 1000);
    }
}

// грязный лайфхак - так не надо делать
echo '<table border="1">';
echo '<thead>';
echo '<tr>';
echo '<th colspan="'. $cols + 1 .'"></th><th>rowsum</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

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
echo '</tbody>';

echo '<tfoot>';
echo '<tr>';
echo '<td>colsum</td>';

// подсчет суммы в столбце
for ($col = 0; $col < $cols; $col++) {
    echo '<td>' . array_sum(array_column($matrix, $col)) . '</td>';
}

echo '<td></td>';
echo '</tr>';
echo '</tfoot>';
echo '</table>';
