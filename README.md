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
```

You can generate it with `symfony console config:dump techad_edc_popover` or `php bin/console config:dump techad_edc_popover`

Override only the value you want to modify.

| Node | Properties | Default | Description |
|--|--|--|--|
| server | url | http://localhost | the edc web help url |
| server | help_context | help | the url context |

### Add the contextual documentation in your web page

### Get the contextual documentation in the Controller

To get the contextual documentation (brick help), you have to call the method:

```php
$contextHelp = $this->edcHelp->getContextHelp('MainKey', 'SubKey', 'OptionalLanguageCode');
```

Then add the context help in the parameter to render it.

**Example**

```php
<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Techad\EdcPopoverBundle\Service\EdcHelp;

class IndexController extends AbstractController
{
    /**
     * @var EdcHelp
     */
    private $edcHelp;


    public function __construct(EdcHelp $edcHelp)
    {
        $this->edcHelp = $edcHelp;
    }

    /**
     * @Route("/")
     */
    public function index()
    {
        /* Get the contextual documentation for the main key: 'fr.techad.edc', sub key: 'documentation_type' and in french: 'fr'*/
        $contextHelp = $this->edcHelp->getContextHelp('fr.techad.edc', 'documentation_type', 'fr');
        return $this->render('index.html.twig', [
            'contextHelp' => $contextHelp,
            'data1' => 'Your data',
            'label' => 'Your label...'
        ]);
    }
}
```

#### Add the popover in your web page

You have to import the edc popover macro in your page:

```php
{%  import "@EdcPopover/popover/edc-popover.html.twig" as popover %}
```

Then insert the popover in your page:

```twig
<div>
My functionality {{ popover.edc_help(contextHelp) }}
</div>
```

**Example**

```twig
% extends "base.html.twig" %}
{%  import "@EdcPopover/popover/edc-popover.html.twig" as popover %}
{% block title %}edc Example{% endblock %}

{% block body %}
    <h1 class="title"><img src="{{ asset('assets/edc.png') }}"></h1>
    
    <div>
        This is an example to add the edc popover in your page.<br/>
        The help -> {{ popover.edc_help(contextHelp) }}
    </div>
{% endblock %}

```

### Customise the popover

To customise the popover, you have to define some global variables in twig. Add the following content in the **edc.yaml** file:

```yaml
twig:
  globals:
      popover:
        summary: true
        icon: 'fa fa-question'
        placement: 'bottom'
        trigger: 'hover'
        animation: true
        container: 'body'
        delay_show: 100
        delay_hide: 5000
``` 

| Variable | Default | Description |
|--|--|--|
| summary | true | Display the popover. If false, create a link on the first article of the contextual help |
| icon | fa fa-question-circle | Equivalent class of your preferred icon bank (font awesome, ...). |
| placement | bottom | Set the position of the popover.  Based on the bootstrap popover, available values are auto, top, bottom, left or right |
| trigger | focus | Set the trigger popover. Based on the bootstrap popover, available values are click, hover or focus. | 
| animation | true | Apply fade animation |
| container | body | Appends the popover to a specific element. See Bootstrap documentation for more information |
| delay_show | 100 | Delay showing the popover (ms). Apply for hover |
| delay_hide | 100 | Delay hiding the popover (ms) |

A default ccs file (edc-popover.css) is delivered and available in public/bundles/edcpopover/css. You can override class to define your own style. 

## Create your environment

Only if you want to contribute or modify this bundle.

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

Create a folder named **doc** inside the YOUR_PATH_HERE then copy into it the exported documentation from your [demo website](https://demo.easydoccontents.com) .

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

### Use the bundle in your application

If you want to include the edc popover under development in your application to valid it directly in real context, you have to declare this repository as an external repositories.
In **composer.json**, you have to add:

```json

    "repositories": [
        {
            "type": "path",
            "url": "../edc-popover-symfony"
        }
    ]
``` 
And add the plugin in your application with the command:
    
```shell script
composer require techad/edc-popover-bundle
```
    
**Example**

```json
{
    "type": "project",
    "license": "proprietary",
    "require": {
        "php": "^7.1.3"
    },
    "repositories": [
     {
         "type": "path",
         "url": "../edc-popover-symfony"
     }
    ]
}
```

### Tips

**Copy the assets from this bundle to your application**

If you add or edit the content of the folder: public (css file for example), you have to update the assets copy with `symfony console assets:install` or `php bin/console assets:install`
**Warning**: This command has to be type in the root folder of your application.
