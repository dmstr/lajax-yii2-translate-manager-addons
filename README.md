Translatemanager Addons
=======================
Addons for lajax/yii2-translatemanager

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist dmstr/lajax-yii2-translate-manager-addons "*"
```

or add

```
"dmstr/lajax-yii2-translate-manager-addons": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, just add the following to your already installed [translatemanager](https://github.com/lajax/yii2-translate-manager) module config  :

 ```php
   'translatemanager' => [
      'tables' => [
          [
              'connection' => 'db',
              'table' => 'example_table_name',
              'columns' => ['column0','column1']
          ]
          // Insert your own tables and column names as in the example above.
      ],
      'scanners' => [
          lajax\translatemanager\services\scanners\ScannerPhpFunction::class,
          lajax\translatemanager\services\scanners\ScannerPhpArray::class,
          lajax\translatemanager\services\scanners\ScannerJavaScriptFunction::class,
          dmstr\lajax\translatemanager\services\scanners\ScannerDatabase::class
      ]
   ]
```
