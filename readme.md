System Call Argument Filtering for Interpreted Languages
=======

</a>
This repository contains the code for our prototype implementation of the Saphire Extension,
described in our paper "System Call Argument Filtering for Interpreted Languages" available at 
<a href="https://repository.tudelft.nl">
TU Delft repository
</a>

Saphire Extension is an extension of the Saphire framework described in the paper "Saphire: Sandboxing PHP Applications with Tailored System Call Allowlists" available at <a href="https://www.usenix.org/system/files/sec21summer_bulekov.pdf">
USENIX 2021 Paper
</a>  with code repository at <a href="https://github.com/BUseclab/saphire">
Saphire github
</a>

Saphire is a mechanism for automatically creating and applying system-call
filters for individual scripts in a PHP web-app. Our extension adds policy generation and filtering for system call arguments to the framework.

Here we provide instructions for building and using the Docker image.

Docker Instructions
-------
Create an image with the Dockerfile
```
docker build -t saphire_extension .
```
Create and start a container from this image
```
docker run -it --name saphire_extension -p 9000:80 --cap-add=SYS_PTRACE saphire_extension
```
Saphire consists of three stages. The extension keeps to this division. For the first stage, we provide multiple scripts: a base script, a script to use static analysis and a script for dynamic analysis. We always run the base script and choose one of the two analyses afterwards.

In the docker container:
```
cd /root/vm_scripts
./run_stage1_args_docker_base.sh
./run_stage1_args_docker_{dynamic|static}.sh  /root/stage1_output_{dynamic|static}
./run_stage1_5_docker.sh
```
Copy application phpMyAdmin, Drupal or Joomla to the appropriate folder and run stage 2:
```
rm -rf /var/www/html/{*,.*}
cp -R /root/{phpMyAdmin|Drupal|Joomla}/* /var/www/html
./run_stage2_args_docker.sh /root/stage1_output_{dynamic|static} /root/stage2_output_{pma|drupal|joomla}
```
Run stage 3 to create the filter and start php-fpm:
```
DISABLE_PROTECTION=0 ./run_stage3_docker.sh /root/stage2_output_{pma|drupal|joomla}
```
The webpage can now be found at `http://localhost:9000/`. Login credentials are user: selenium_user with password: selenium_password.

To test the filter:
* phpMyAdmin: install the seleniumIDE in your browser and run the tests located at `testing/pma.side` on github
* Drupal: First activate the simpletest module by navigating to `http://localhost:9000/admin/modules` and check Testing before saving the configuration. Thereafter run `sudo -u www-data php ./scripts/run-tests.sh --url http://localhost --all` at `var/www/html`. Note that this may take several hours.
* Joomla: install the seleniumIDE in your browser, login at `localhost:9000/administrator/`, and run the tests located at `testing/Joomla.side` on github
