#!/bin/sh

/root/php-src/sapi/cgi/php-cgi -C    -d "output_handler=" -d "open_basedir=" -d "disable_functions=" -d "output_buffering=Off" -d "error_reporting=E_ALL&~E_NOTICE" -d "display_errors=1" -d "display_startup_errors=1" -d "log_errors=0" -d "html_errors=0" -d "track_errors=1" -d "report_memleaks=1" -d "report_zend_debug=0" -d "docref_root=" -d "docref_ext=.html" -d "error_prepend_string=" -d "error_append_string=" -d "auto_prepend_file=" -d "auto_append_file=" -d "ignore_repeated_errors=0" -d "precision=14" -d "memory_limit=128M" -d "log_errors_max_len=0" -d "opcache.fast_shutdown=0" -d "opcache.file_update_protection=0" -d "zend_extension=xdebug.so" -d "session.auto_start=0" -d "zlib.output_compression=Off" -d "mbstring.func_overload=0" -d "file_uploads=1" -d "comment=debug builds show some additional E_NOTICE errors" -d "upload_max_filesize=1024" -d "session.save_path=" -d "session.name=PHPSESSID" -d "session.use_strict_mode=0" -d "session.use_cookies=1" -d "session.use_only_cookies=0" -d "session.upload_progress.enabled=1" -d "session.upload_progress.cleanup=0" -d "session.upload_progress.prefix=upload_progress_" -d "session.upload_progress.name=PHP_SESSION_UPLOAD_PROGRESS" -d "session.upload_progress.freq=1%" -d "session.save_handler=files" -f "/root/php-src/ext/session/tests/rfc1867_no_name.php" 2>&1 < "/root/php-src/ext/session/tests//phpt.6277d02f72509"
