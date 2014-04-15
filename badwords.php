<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$badWords = array(
    'ass' => 'a!@',
    'fuck' => 'f&#k',
    'shit' => 's@%t',
    'pussy' => 'p#%!y',
    'cunt' => 'c#$t',
    'cock' => 'c#@k',
    'dick' => 'd!@k',
    'twat' => 't$#t'
    
);

$text = 'You are a fuck ass punk fucker pussy eater!';

echo  str_replace(array_keys($badWords), array_values($badWords), $text);

