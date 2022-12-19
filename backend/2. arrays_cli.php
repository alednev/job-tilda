<?php

/**
 * Нужно заполнить массив 5 на 7 случайными уникальными числами от 1 до 1000.
 * Вывести получившийся массив и суммы по строкам и по столбцам.
 */

$n      = 5;
$m      = 7;
$matrix = [];

// заполнение двумерного массива случайными числами
for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < $m; $j++) {
        $matrix[$i][$j] = random_int(1, 1000);
    }
}

// ===================

echo 'Version 1:' . PHP_EOL . PHP_EOL;

// допустим, что мы не знаем размерность массива
// тогда надо высчитывать количество строк и столбцов
for ($row = 0, $rows = count($matrix); $row < $rows; $row++) {
    for ($col = 0, $cols = count($matrix[$row]); $col < $cols; $col++) {
        echo ' ' . $matrix[$row][$col];
    }

    // подсчет суммы в ряду
    echo ' row sum=' . array_sum($matrix[$row]);
    echo PHP_EOL;
}

// подсчет суммы в столбцах
// можно использовать уже вычесленный $cols из второго for
// а можно заново найти количество столбцов как count($matrix[0])
for ($col = 0; $col < $cols; $col++) {
    echo ' col sum=' . array_sum(array_column($matrix, $col));
}

echo PHP_EOL . PHP_EOL;

/**
 * второй глобальный вариант, когда ключи не цифровые
 */
echo "Version 2:" . PHP_EOL . PHP_EOL;

$dailyTasks = [
    ['Reading' => 2, 'Writing' => 5, 'Cooking' => 2, 'Walking' => 1],
    ['Reading' => 3, 'Writing' => 4, 'Cooking' => 1, 'Walking' => 0.5],
    ['Reading' => 2, 'Writing' => 6, 'Cooking' => 1, 'Walking' => 1],
    ['Reading' => 3, 'Writing' => 5, 'Cooking' => 2, 'Walking' => 0.5],
    ['Reading' => 1, 'Writing' => 7, 'Cooking' => 2, 'Walking' => 1],
];

$dayHours = [];

foreach ($dailyTasks as $day) {
    foreach ($day as $task) {
        echo ' ' . $task;
    }

    // подсчет суммы в ряду
    $dayHours[] = array_sum($day);

    echo PHP_EOL;
}

echo PHP_EOL . 'Sum by days: ';

print_r($dayHours);

// результирующий массив сумм по столбцам
$totalHours = [];

foreach ($dailyTasks as $day) {
    foreach ($day as $task => $hours) {
        array_key_exists($task, $totalHours) ? $totalHours[$task] += $hours : $totalHours[$task] = $hours;
    }
}

echo PHP_EOL . 'Sum by tasks: ';
print_r($totalHours);
