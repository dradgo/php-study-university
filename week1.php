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
    $innerMap = array();
    $result = array();
    foreach ($inputOne as $key => $value) {
        if(!array_key_exists($value, $innerMap)) {
            $innerMap[$value] = 1;
            $result[] = $value;
        }
    }
    foreach ($inputTwo as $key => $value) {
        if(!array_key_exists($value, $innerMap)) {
            $innerMap[$value] = 1;
            $result[] = $value;
        }
    }
    return $result;
}

function intersectArrays($inputOne, $inputTwo)
{
    $innerMap = array();
    $resultMap = array();
    $result = array();
    foreach ($inputOne as $key => $value) {
        if(!array_key_exists($value, $innerMap)) {
            $innerMap[$value] = 1;
        }
    }
    foreach ($inputTwo as $key => $value) {
        if(array_key_exists($value, $innerMap)) {
            if(!array_key_exists($value, $resultMap)) {
                $resultMap[$value] = 1;
                $result[] = $value;
            }
        }
    }
    return $result;
}
?>
Week 1 - results <br>
Fibonacci <?php echo fibonacci(5); ?> <br/>
Arrays Merge: <?php print_r(mergeArrays(array('1', '1', '2', '4', '7'), array('2', '3', '1', '9', '6', '4')));?> <br>
<hr>
Arrays Intersect: <?php print_r(intersectArrays(array('1', '1', '2', '3', '4', '7', '11'), array('2', '3', '1', '7')));?>
