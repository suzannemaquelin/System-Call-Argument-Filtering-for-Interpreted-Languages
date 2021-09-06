<?php
var_dump(
    bin2hex(
        openssl_encrypt(
            "this is a test string",
            "bf-ecb",
            "12345678",
            OPENSSL_RAW_DATA | OPENSSL_DONT_ZERO_PAD_KEY
        )
    )
);
var_dump(
    bin2hex(
        openssl_encrypt(
            "this is a test string",
            "bf-ecb",
            "1234567812345678",
            OPENSSL_RAW_DATA
        )
    )
);
?>
