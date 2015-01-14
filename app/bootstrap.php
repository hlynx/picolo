<?php
use \Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Picolo\Application();

// Determining application environment
// Apache: SetEnv APP_ENV dev
// Nginx:  fastcgi_param APP_ENV dev
$app['env'] = getenv('APP_ENV')?:'prod';
$app['debug'] = $app['env'] == 'dev';

// Loading configs from cache and saving cache if none existent
$cacheFile = $app->getCacheDir().'config.'.$app['env'].'.php';
if(($app['env'] == 'dev') || !file_exists($cacheFile)) {
    $configDir = $app->getRootDir().'config'.DIRECTORY_SEPARATOR;
    $config = array_merge(
        Yaml::parse($configDir.'settings.yml'),
        Yaml::parse($configDir.'routing.yml')
        // Other configs
    );
    
    $app['config'] = array_merge((array)$config['all'], (array)$config[$app['env']]);
    
    // DANGER!!! Watch after var_export - it may cut long arrays
    file_put_contents($cacheFile, '<?php return ' . var_export($app['config'], true) . ';');
}
else {
    $app['config'] = require_once $cacheFile;
}
unset($cacheFile, $configDir, $config);

// Setting db
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $app->getConfig('database')
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Setting template engine
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app->getRootDir().'templates'.DIRECTORY_SEPARATOR,
    'twig.options' => array(
        'cache' => $app->getCacheDir().'twig'.DIRECTORY_SEPARATOR,
        'debug' => $app['debug']
    ),
));

// Setting routing
foreach($app->getConfig('routing') as $name=>$params)
    $app->get($params['path'], $params['controller'])->bind($name);

/*
$app->get('{url}', function($url) {
    var_dump($url);
});
 */

return $app;
