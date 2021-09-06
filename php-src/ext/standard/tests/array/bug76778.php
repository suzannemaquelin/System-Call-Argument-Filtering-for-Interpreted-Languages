<?php
try {
    array_reduce(
        [1],
        function ($carry, $item) {
            throw new Exception;
        },
        range(1, 3)
    );
} catch (Exception $e) {
}
?>
===DONE===
