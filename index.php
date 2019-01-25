<?php
/**
 * Using it:
 */

require 'DesignSelectorMiddleware.php';
//as a middleware, it requires the class Request and Session

//1 - populated the array with the data fetched from the dataBase:
$designs = [
   'design_1' => [
       'design_id' => 1,
       'split_percent' => 25,
       'design_name' => 'Design 1',
   ],
   'design_2' => [
       'design_id' => 2,
       'split_percent' => 50,
       'design_name' => 'Design 2',
   ],
   'design_3' => [
       'design_id' => 3,
       'split_percent' => 25,
       'design_name' => 'Design 3',
   ]
];

//2 - just instantiate the middleware class passing Session and the designs
$designSelector = new DesignSelectorMiddleware($session, $designs);
$designSelector->selectDesign($request);
