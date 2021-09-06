<?php
$q = new SplQueue();
try {
    $q->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
} catch (Exception $e) {
    echo 'unexpected exception: ' . $e->getMessage() . "\n";
}
try {
    $q->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
} catch (Exception $e) {
    echo 'expected exception: ' . $e->getMessage() . "\n";
}
?>
===DONE===
