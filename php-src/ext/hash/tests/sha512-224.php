<?php
echo hash('sha512/224', '') . "\n";
echo hash('sha512/224', 'abc') . "\n";
echo hash('sha512/224', 'abcdefghbcdefghicdefghijdefghijkefghijklfghijklmghijklmnhijklmnoijklmnopjklmnopqklmnopqrlmnopqrsmnopqrstnopqrstu') . "\n";
