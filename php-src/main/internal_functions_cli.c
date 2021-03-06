/* -*- C -*-
   +----------------------------------------------------------------------+
   | PHP Version 7                                                        |
   +----------------------------------------------------------------------+
   | Copyright (c) 1997-2018 The PHP Group                                |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Authors: Andi Gutmans <andi@zend.com>                                |
   |          Zeev Suraski <zeev@zend.com>                                |
   +----------------------------------------------------------------------+
 */

/* $Id$ */

#include "php.h"
#include "php_main.h"
#include "zend_modules.h"
#include "zend_compile.h"
#include <stdarg.h>
#include <stdlib.h>
#include <stdio.h>

#include "ext/date/php_date.h"
#include "ext/libxml/php_libxml.h"
#include "ext/openssl/php_openssl.h"
#include "ext/pcre/php_pcre.h"
#include "ext/sqlite3/php_sqlite3.h"
#include "ext/zlib/php_zlib.h"
#include "ext/bcmath/php_bcmath.h"
#include "ext/bz2/php_bz2.h"
#include "ext/calendar/php_calendar.h"
#include "ext/ctype/php_ctype.h"
#include "ext/curl/php_curl.h"
#include "ext/dom/php_dom.h"
#include "ext/exif/php_exif.h"
#include "ext/fileinfo/php_fileinfo.h"
#include "ext/filter/php_filter.h"
#include "ext/ftp/php_ftp.h"
#include "ext/gettext/php_gettext.h"
#include "ext/hash/php_hash.h"
#include "ext/iconv/php_iconv.h"
#include "ext/json/php_json.h"
#include "ext/mbstring/mbstring.h"
#include "ext/mcrypt/php_mcrypt.h"
#include "ext/mysqli/php_mysqli.h"
#include "ext/pcntl/php_pcntl.h"
#include "ext/pdo/php_pdo.h"
#include "ext/pdo_mysql/php_pdo_mysql.h"
#include "ext/pdo_pgsql/php_pdo_pgsql.h"
#include "ext/pdo_sqlite/php_pdo_sqlite.h"
#include "ext/pgsql/php_pgsql.h"
#include "ext/phar/php_phar.h"
#include "ext/posix/php_posix.h"
#include "ext/reflection/php_reflection.h"
#include "ext/session/php_session.h"
#include "ext/simplexml/php_simplexml.h"
#include "ext/soap/php_soap.h"
#include "ext/sockets/php_sockets.h"
#include "ext/spl/php_spl.h"
#include "ext/standard/php_standard.h"
#include "ext/sysvsem/php_sysvsem.h"
#include "ext/sysvshm/php_sysvshm.h"
#include "ext/tokenizer/php_tokenizer.h"
#include "ext/xml/php_xml.h"
#include "ext/xmlreader/php_xmlreader.h"
#include "ext/xmlrpc/php_xmlrpc.h"
#include "ext/xmlwriter/php_xmlwriter.h"
#include "ext/xsl/php_xsl.h"
#include "ext/zip/php_zip.h"
#include "ext/mysqlnd/php_mysqlnd.h"


static zend_module_entry *php_builtin_extensions[] = {
	phpext_date_ptr,
	phpext_libxml_ptr,
	phpext_openssl_ptr,
	phpext_pcre_ptr,
	phpext_sqlite3_ptr,
	phpext_zlib_ptr,
	phpext_bcmath_ptr,
	phpext_bz2_ptr,
	phpext_calendar_ptr,
	phpext_ctype_ptr,
	phpext_curl_ptr,
	phpext_dom_ptr,
	phpext_exif_ptr,
	phpext_fileinfo_ptr,
	phpext_filter_ptr,
	phpext_ftp_ptr,
	phpext_gettext_ptr,
	phpext_hash_ptr,
	phpext_iconv_ptr,
	phpext_json_ptr,
	phpext_mbstring_ptr,
	phpext_mcrypt_ptr,
	phpext_mysqlnd_ptr,
	phpext_mysqli_ptr,
	phpext_pcntl_ptr,
	phpext_spl_ptr,
	phpext_pdo_ptr,
	phpext_pdo_mysql_ptr,
	phpext_pdo_pgsql_ptr,
	phpext_pdo_sqlite_ptr,
	phpext_pgsql_ptr,
	phpext_phar_ptr,
	phpext_posix_ptr,
	phpext_reflection_ptr,
	phpext_session_ptr,
	phpext_simplexml_ptr,
	phpext_soap_ptr,
	phpext_sockets_ptr,
	phpext_standard_ptr,
	phpext_sysvsem_ptr,
	phpext_sysvshm_ptr,
	phpext_tokenizer_ptr,
	phpext_xml_ptr,
	phpext_xmlreader_ptr,
	phpext_xmlrpc_ptr,
	phpext_xmlwriter_ptr,
	phpext_xsl_ptr,
	phpext_zip_ptr,

};

#define EXTCOUNT (sizeof(php_builtin_extensions)/sizeof(zend_module_entry *))

PHPAPI int php_register_internal_extensions(void)
{
	return php_register_extensions(php_builtin_extensions, EXTCOUNT);
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
