<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;

// Init Silex
$app = new Silex\Application();
$app['config'] = $config;
$app['debug']  = $config['debug'];

// Services
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '../app/views',
));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
        'driver'    => 'pdo_mysql',
        'host'      => $config['db_host'],
        'dbname'    => $config['db_name'],
        'user'      => $config['db_user'],
        'password'  => $config['db_pass'],
        'charset'   => 'utf8'
    ),
));
$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
    'swiftmailer.options' => array(
        'host'       => 'smtp.gmail.com',
        'port'       => 465,
        'username'   => '',
        'password'   => '',
        'encryption' => 'ssl',
        'auth_mode'  => 'login'
    )
));

// Before
$app->before(function() use ($app) {
    $app['twig']->addGlobal('title','CS-MVC, Light & Powerful');
});

//Object Response
$app['db']->setFetchMode(PDO::FETCH_OBJ);

//Init Models
$articles_model = new Articles_Model($app['db']);
