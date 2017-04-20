<?php

$loader = require_once __DIR__.'/vendor/autoload.php';

$loader->addPsr4('ImageOptimizer\\', __DIR__.'/ImageOptimizer');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/views', [
        'cache' => __DIR__ .'/cache'
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

$container['optimizer'] = function ($container) {
    $optimizer = new \ImageOptimizer\OptimizerFactory(array(
        'ignore_errors' => false,
    ));

    return $optimizer->get();
};

$app->get('/', function (Request $request, Response $response) {
    return $this->view->render($response, 'index.twig', array());
})->setName('index');

$app->post('/', function (Request $request, Response $response){
    $input_path = __DIR__ . '\input\\';
    if ($this->request->getParam('action') == 'getAllFiles') {
        $this->optimizer->cleanFolder($input_path);
        $path = $this->request->getParam('path');
        $check = $this->optimizer->checkPath($path, $input_path);
        if (is_array($check)) {
            die(json_encode(array('status' => true, 'files' => $check)));
        } elseif ($check) {
            die(json_encode(array('status' => true, 'files' => $this->optimizer->getAllFiles($path.'\\', $input_path))));
        } else {
            die(json_encode(array('status' => false, 'error' => 'The folder or file is not found or can\'t be optimized.')));
        }
    } elseif ($this->request->getParam('action') == 'next') {
        $files = json_decode($this->request->getParam('files'), true);
        $new_size = $this->optimizer->patch($files[0]);
        die(json_encode(array('status' => true, 'size' => $new_size)));
    } elseif ($this->request->getParam('action') == 'download') {
        $file_name = 'images.zip';
        $path = __DIR__ . '\downloads\\';
        $this->optimizer->createZip($file_name, $path, $input_path);
        die(json_encode(array('zipfile' => dirname($_SERVER[REQUEST_URI]).'/downloads/'.$file_name)));
    }
});

$app->run();