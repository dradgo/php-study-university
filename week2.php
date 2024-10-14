<?php
$highTemps = array(
    68, 70, 72, 58, 60, 79, 82, 73, 75, 77, 73, 58, 63, 79, 78,
    68, 72, 73, 80, 79, 68, 72, 75, 77, 73, 78, 82, 85, 89, 83
);
function topFive($param) {
    arsort($param);
    return array_slice($param, 0, 5);
}
function downFive($param) {
    asort($param);
    return array_slice($param, 0, 5);
}
function averageTmp($param) {
    $count = 0;
    $sum = 0;
    foreach ($param as $key => $value) {
        $count++;
        $sum += $value;
    }
    return (1.0 * $sum) / $count;
}

function clearPhoneNumber($param) {
    $pattern = "/[^0-9]/";
    return preg_replace($pattern, "", $param);
}

function lastPartOfUrl($param) {
    $parts = explode("/", $param);
    return end($parts);
}

echo print_r(downFive($highTemps));
echo '<br>';
echo print_r(topFive($highTemps));
echo '<br>';
echo averageTmp($highTemps);
echo '<br>';
echo clearPhoneNumber("+7 (900) 000-00-00");
echo '<br>';
echo lastPartOfUrl("http://www.wm-school.ru/7478639");
echo '<br>';

?>