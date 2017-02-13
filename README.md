# Asset Helper Beta 1.0 for CakePHP 3

Easy manage asset css & js on your project

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require c181/Asset
```

#### Add folder **asset** under **webroot** CakePHP 3 Project, in asset folder you can add bootstrap, jquery, font-awesome, etc.
```
cakephp
    - webroot
        - asset
            - bootstrap
                - css
                    - bootstrap.min.css
                - fonts
                - js
                    - bootstrap.min.js
            - jquery
                - js
                    - jquery.min.js
```

#### Use the plugin
**Loading on your Bootstrap.php**

```
Plugin::load('Asset', ['bootstrap' => true, 'routes' => false]);
```

**Loading plugin on your project on AppView.php**

```
public function initialize()
    {
        $this->loadHelper('Asset.Asset');
        $this->loadHelper('Asset.Cdnjs');
    }
```

**Use on Template**

* CSS = <?= $this->Asset->css('asset_folder_css_name', 'css_file')?>
* JS = <?= $this->Asset->script('asset_folder_js_name', 'js_file')?>
* HTML5Shiv = <?= $this->Cdnjs->library(['cdn_url_html5shive'])?>


```
<?= $this->Html->docType() ?>
<html>
<head>
	<?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        My Site:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
	<?= $this->Asset->css('bootstrap', 'bootstrap.min') . "\n" ?>
	<?php
    $cdn = [
        'https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js',
    ]
    ?>
    <?= $this->Cdnjs->library($cdn) . "\n" ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

	<?= $this->Flash->render() ?>
    <div class="container">
        <?= $this->fetch('content') ?>
    </div>

<?= $this->Asset->script('jquery','jquery.min') . "\n" ?>
<?= $this->Asset->script('bootstrap','bootstrap.min') . "\n" ?>
</body>
</html>
```

Thank you


