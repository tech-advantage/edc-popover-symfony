# edc-popover-symfony

The popover for Symfony shows the published documentation from [edc](https://www.easydoccontents.com "Easy Doc Contents") developed by TECH advantage.

This project is based on Bootstrap Popover 4 and JQuery 3+.

## edc Version

Current release is compatible with edc v3.0+

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

### Add the popover in your web page

#### First possibility

This solution is the easiest because you declare the contextual help with one call. The code merge the HTML and Javascript in one place.

##### Add Boostrap and JQuery in your application

You have to add Bootstrap and JQuery in the head of your template. 

**Warning**: The bootstrap and popover have to be include before the first call of edc popover else the popover will not display

**Example**

```twig
<html>
<head>
    <meta charset="UTF-8">
    <title>{% block title %}Welcome!{% endblock %}</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    {% block stylesheets %}
        <!-- Bootstrap 4 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <!-- Edc Popover -->
        <link rel="stylesheet" href="{{ asset('bundles/edcpopover/css/edc-popover.css') }}"/>
    {% endblock %}
    {% block javascripts_head %}
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Bootstrap and the Popover -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <!-- Edc Popover -->
        <script src="{{ asset('bundles/edcpopover/js/edc-popover.js') }}"></script>
    {% endblock %}

</head>
<body>
% block body %}
{% endblock %}
% block javascripts %}
{% endblock %}
</body>
</html>
```
##### Edit the twig

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

#### Second  possibility

This second solution is a little more complicated but is the most efficient way to load pages. This approach relies on 2 calls to the macro to separate HTML and Javascript.

##### Add Boostrap and JQuery in your application

You have to add Bootstrap and JQuery in your template page in javascript block (or declare it in encore). 

**Warning**: The bootstrap and popover have to be include before the first call of edc popover else the popover will not display

**Example**

```twig
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    
        {% block stylesheets %}
            <!-- Bootstrap 4 -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
            <!-- Edc Popover -->
            <link rel="stylesheet" href="{{ asset('bundles/edcpopover/css/edc-popover.css') }}"/>
        {% endblock %}
    </head>
    <body>
        {% block body %}
        {% endblock %}

        {% block javascripts %}
            <!-- JQuery -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <!-- Bootstrap and the Popover -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <!-- Edc Popover -->
            <script src="{{ asset('bundles/edcpopover/js/edc-popover.js') }}"></script>
        {% endblock %}

        {# block to declare the popover #}
        {% block edcpopover %}
        {% endblock %}
    </body>
</html>
```

##### Edit the twig

You have to import the edc popover macro in your page:

```php
{%  import "@EdcPopover/popover/edc-popover.html.twig" as popover %}
```

Then insert the HTML popover part in your page:

```twig
<div>
My functionality {{ popover.edc_help_html(contextHelp) }}
</div>
```

And the Javascript part in the dedicated block:

```twig
{% block edcpopover %}
    {{ popover.edc_help_javascript(docContextHelp) }}
{% endblock %}
```

**Example**

```twig
% extends "base.html.twig" %}
{%  import "@EdcPopover/popover/edc-popover.html.twig" as popover %}
{% block title %}edc Example{% endblock %}

{# The body content #}
{% block body %}
    <h1 class="title"><img src="{{ asset('assets/edc.png') }}"></h1>
    
    <div>
        This is an example to add the edc popover in your page.<br/>
        The help -> {{ popover.edc_help_html(contextHelp) }}
    </div>
{% endblock %}

{# Declare each popover for the javascript #}
{% block edcpopover %}
    {{ popover.edc_help_javascript(docContextHelp) }}
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
{
    "repositories": [
        {
            "type": "path",
            "url": "../edc-popover-symfony"
        }
    ]
}
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

## License

MIT
