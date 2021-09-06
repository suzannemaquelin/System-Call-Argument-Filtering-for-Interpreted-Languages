CREATE USER 'extended_saphire_user'@localhost IDENTIFIED BY 'extended_saphire_password';
GRANT ALL PRIVILEGES ON *.* TO 'extended_saphire_user'@'localhost' IDENTIFIED BY 'extended_saphire_password' WITH GRANT OPTION;
FLUSH PRIVILEGES;
CREATE DATABASE Joomla;
CREATE DATABASE drupal;