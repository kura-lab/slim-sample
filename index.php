<?php
require 'vendor/autoload.php';

Predis\Autoloader::register();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app = new Slim\Slim(array(
  'view' => new Slim\Views\Twig()
));
$view = $app->view();
$view->parserExtensions = array(
  new \Slim\Views\TwigExtension(),
);

$redis = new Predis\Client(
  array(
    "scheme" => "tcp",
    "host" => "127.0.0.1",
    "port" => 6379
  )
);

$app->get('/hello/:name', function($name) use($app){

  $logPath = '/tmp/mono.log';
  $logger = new Logger('foo_test');
  $logger->pushHandler(new StreamHandler($logPath, Logger::DEBUG));
  // $logger->info()
  $logger->addInfo('info_bar');

  // $logger->notice()
  $logger->addNotice('notice_bar');

  // $logger->warning(), $logger->warn()
  $logger->addWarning('warning_bar');

  // $logger->error(), $logger->err()
  $logger->addError('error_bar');

  // $logger->critical(), $logger->crit()
  $logger->addCritical('critical_bar');

  // $logger->alert()
  $logger->addAlert('alert_bar');

  // $logger->emergency(), $logger->emerg()
  $logger->addEmergency('emergency_bar');

  $app->render('index.html', array('name' => $name));
});

$app->get('/redis', function() use($redis) {

  // PING
  echo $redis->ping();

  $redis->set('key', 'value');
  $value = $redis->get('key');

  echo "key: " . $value;
});

$app->run();
