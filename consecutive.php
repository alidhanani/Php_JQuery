<?php

function groupConsecutiveNumbers($numbers) {
    sort($numbers);
    $result = [];

    $start = $end = $numbers[0];

    foreach ($numbers as $key => $num) {
        if ($key + 1 < count($numbers) && $num + 1 == $numbers[$key + 1]) {
            $end = $numbers[$key + 1];
        } else {
            if ($start == $end) {
                $result[] = $start;
            } else {
                $result[] = $start . '-' . $end;
            }
            $start = $end = $numbers[$key + 1];
        }
    }

    return implode(',', $result);
}

$input = [1, 2, 3, 5, 6, 7, 8, 11,12,34,35];
$output = groupConsecutiveNumbers($input);

echo $output;

?>
