<?php

namespace App\Controllers;

use \Picolo\Application;
use \Symfony\Component\HttpFoundation\Request;
use \Doctrine\DBAL\Exception\ServerException;

class Homepage {
    public function index(Request $request, Application $app) {
        return $app->render('test.twig', ['testVar' => 'test']);
    }
    
    public function test(Request $request, Application $app) {
        $sql = "SELECT * FROM product";
        $items = array();
        try {
            /* @var $app['db'] \Doctrine\DBAL\Connection */
            $items = $app['db']->fetchAll($sql);
        }
        catch (ServerException $e) {
            var_dump($e->getErrorCode());
        }
        catch (\Exception $e) {
            var_dump(get_class($e));
        }

        return $app->json($items);
    }
}
