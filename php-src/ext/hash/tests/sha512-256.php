<?php
echo hash('sha512/256', '') . "\n";
echo hash('sha512/256', 'abc') . "\n";
echo hash('sha512/256', 'abcdefghbcdefghicdefghijdefghijkefghijklfghijklmghijklmnhijklmnoijklmnopjklmnopqklmnopqrlmnopqrsmnopqrstnopqrstu') . "\n";
