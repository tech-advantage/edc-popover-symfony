# edc-popover-symfony
Popover for Symfony project

## Prequisite

Install [composer](https://getcomposer.org/) and set it in your system path.


## How to use it?

### Add the bundle in your application

To add the plugin in your application, type:

```shell script
composer require techad/edc-popover-bundle
```

### Define the configuration

To configure, you have to add a file in your packages folder (config/packages) named edc.yaml

```yaml
techad_edc_popover:
  server:
    url: 'http://my-app'
    help_context: "help"
  popover:
    summary: true
```

Override only the value you want to modify.

| Node | Properties | Default | Description |
|--|--|--|--|
| server | url | http://localhost | the edc web help url |
| server | help_context | help | the url context |
| popover | summary | true | the popover will be displayed on click |

## Create your environment

### Install the environment

You have to clone this repository and go to the root folder. 

```shell script
git clone https://github.com/tech-advantage/edc-popover-symfony
cd  edc-popover-symfony
```

Type the following command:

```shell script
composer install
```

All dependencies will be installed.

### Install the documentation server

Download and install [nginx](http://nginx.org/en/download.html) and declare the following configuration:

```text
worker_processes  1;

events {
    worker_connections  1024;
}

http {
    include       mime.types;
    default_type  application/octet-stream;
    sendfile        on;
    server {
        listen 8888 default_server;
        root YOUR_PATH_HERE;

        server_name _;
	}
}
```

Create a folder named **doc** inside the YOUR_PATH_HERE then copy into it the exported documentation.


### Run the tests

**Warning**: Before to run the tests, you have to install and configure the documentation server.

To run the tests to valid your environment, type the following command:

**Under Windows**

```shell script
vendor\bin\simple-phpunit.bat
```

**Under Linux**

```shell script
vendor/bin/simple-phpunit
```

