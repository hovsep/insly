<?php
/**
 * Created by PhpStorm.
 * User: hovsep
 * Date: 03.02.19
 * Time: 21:38
 */


//1. Hey! Seems like we have a bunch of binary numbers here. Let's decode them from binary to decimal and then try to extract sensible information.
$input = '01110000 01110010 01101001 01101110 01110100 00100000 01101111 01110101 01110100 00100000 01111001 01101111 01110101 01110010 00100000 01101110 01100001 01101101 01100101 00100000 01110111 01101001 01110100 01101000 00100000 01101111 01101110 01100101 00100000 01101111 01100110 00100000 01110000 01101000 01110000 00100000 01101100 01101111 01101111 01110000 01110011';

$binNumbers = explode(' ', $input);

foreach ($binNumbers as $binNumber) {
    $code = bindec($binNumber);
    echo $binNumber, 'b = ', $code, 'd = ', chr($code), PHP_EOL;
}

echo PHP_EOL;

//2. Says: "print out your name with one of php loops". Ok, no problem :)
$chars = ['h', 'o', 'v', 's', 'e', 'p'];

foreach ($chars as $char) {
    echo $char;
}