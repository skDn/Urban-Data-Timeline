<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 18.10.2015 ?.
 * Time: 21:34 ?.
 */
$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
$decoder = json_decode($json, true);

var_dump($decoder);

echo $decoder['b'];

?>