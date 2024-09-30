<?php
function fibonacci($input)
{
    if ($input == 0) return 0;
    if ($input == 1 || $input == 2) {
        return 1;
    } else {
        return fibonacci($input - 1) + fibonacci($input - 2);
    }
}

function mergeArrays($inputOne, $inputTwo)
{
    $result = NULL;
    for ($i = 0; $i < count($inputOne); $i++) {
        $result[] = $inputOne[$i];
    }
    for ($i = 0; $i < count($inputTwo); $i++) {
        $result[] = $inputTwo[$i];
    }
    return $result;
}

?>
Week 1 - results <br>
Fibonacci <?php echo fibonacci(5); ?> <br/>
Arrays Merge: <?php print_r(mergeArrays(['1', '1', '2'], ['2', '3', '1']));?>
