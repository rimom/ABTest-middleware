<?php
/**
 * @author Rimom Costa <rimomcosta@gmail.com>
 */

//data fetched from the DB
$designs = [
    'design_1' => [
        'design_id' => 1,
        'split_percent' => 25,
        'design_name' => 'Design 1',
        'probability' => 0,
    ],
    'design_2' => [
        'design_id' => 2,
        'split_percent' => 50,
        'design_name' => 'Design 2',
        'probability' => 0,
    ],
    'design_3' => [
        'design_id' => 3,
        'split_percent' => 25,
        'design_name' => 'Design 3',
        'probability' => 0,
    ],
];

//create range probability for each design
/**
 * |<-design 1->||<-----design 2----->||<-design 3->|
 * 0------------25--------------------75------------100
 * |<----25%--->||<--------50%------->||<----25%--->|
 */
$range = 0;
foreach ($designs as &$design) {
    $design['rangeStart'] = $range;
    $design['rangeEnd'] = $range + $design['split_percent']-1;
    $range = $design['rangeEnd'] +1;
}
 
//test the probability of each design
for($i=0; $i < 100000; $i++) {
    
    //throw the dices...
    $diceValue = random_int(0,99);

    foreach($designs as &$design) {
        //check if the dice value is within the range of each specific design
        if ($diceValue >= $design['rangeStart'] && $diceValue <= $design['rangeEnd']) {
            $designSelected =  $design['design_id'];
            $design['probability']++;
        }
    }
}

//show results
echo 'In a test with 100000 users: ' . PHP_EOL;
for ($i=1; $i<=count($designs); $i++) {
    $probability = round($designs['design_'.$i]['probability']/1000);
    echo 'Design ' . $i . ' selected in ' . $probability . '% of the cases' . PHP_EOL;
}

/**
 * It should displays:
 * 
 * In a test with 100000 users: 
 * Design 1 selected in 25% of the cases
 * Design 2 selected in 50% of the cases
 * Design 3 selected in 25% of the cases
 */
