<?php

var_dump(
    (new class {
        function test(){
            return compact('this');
        }
    })->test()
);

var_dump(
    (new class {
        function test(){
            return compact([['this']]);
        }
    })->test()
);

var_dump(
    (new class {
        function test(){
            return (function(){ return compact('this'); })();
        }
    })->test()
);

?>
