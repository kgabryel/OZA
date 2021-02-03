<?php

use App\Controller\AlertsController;
use App\Controller\FBController;
use App\Controller\HomeController;
use App\Controller\Lists\Lists\FullController;
use App\Controller\Lists\Lists\QuickController;
use App\Controller\Measures\MainMeasuresController;
use App\Controller\Measures\MeasuresController;
use App\Controller\Measures\SubMeasuresController;
use App\Controller\ProductsController;
use App\Controller\SecurityController;
use App\Controller\ShoppingController;
use App\Controller\ShopsController;
use App\Controller\Lists\Positions\QuickController as QuickPositionController;
use App\Controller\Lists\Positions\FullController as FullPositionController;
use App\Controller\StuffsController;
use App\Controller\SuppliesController;
use App\Services\Routing\Group;
use App\Services\Routing\Info;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();

$loginGroup = new Group($collection, 'login.', '/login');
$loginGroup->setController(SecurityController::class)
    ->add('show', new Route('/'), new Info(['GET'], 'showLogin'))
    ->add('login', new Route('/'), new Info(['POST'], 'login'));

$registerGroup = new Group($collection, 'register.', '/register');
$registerGroup->setController(SecurityController::class)
    ->add('show', new Route('/'), new Info(['GET'], 'showRegister'))
    ->add('register', new Route('/'), new Info(['POST'], 'register'));

$fbGroup = new Group($collection, 'fb.', '/fb');
$fbGroup->setController(FBController::class)
    ->add('auth', new Route('/auth'), new Info(['GET'], 'auth'))
    ->add('login', new Route('/login'), new Info(['GET'], 'login'));

$homeGroup = new Group($collection, 'home.', '/');
$homeGroup->setController(HomeController::class)
    ->addCreate()
    ->addDelete()
    ->add('index', new Route('/'), new Info(['GET'], 'index'));

$logoutGroup = new Group($collection, 'logout', '/logout');
$logoutGroup->setController(SecurityController::class)
    ->add('', new Route('/'), new Info(['GET'], 'logout'));

$measuresGroup = new Group($collection, 'measures.', '/measures');
$measuresGroup->setController(MeasuresController::class)
    ->addIndex()
    ->add(
        'main.show',
        new Route('/main'),
        new Info(['GET'], 'show', MainMeasuresController::class)
    )
    ->add(
        'main.create',
        new Route('/main'),
        new Info(['POST'], 'create', MainMeasuresController::class)
    )
    ->add(
        'sub.show',
        new Route('/sub'),
        new Info(['GET'], 'show', SubMeasuresController::class)
    )
    ->add(
        'sub.create',
        new Route('/sub'),
        new Info(['POST'], 'create', SubMeasuresController::class)
    )
    ->addInfo()
    ->addShow()
    ->addUpdate()
    ->addDelete();

$quickListsGroup = new Group($collection, 'quick-lists.', '/quick-lists');
$quickListsGroup->setController(QuickController::class)
    ->addIndex()
    ->addCreate()
    ->addDelete()
    ->addEdit()
    ->addShow()
    ->addUpdate()
    ->add('shoEdit', new Route('/{id}/edit'), new Info(['GET'], 'edit'));

$quickListPositionsGroup = new Group($collection, 'quick-list-positions.', '/quick-list-positions');
$quickListPositionsGroup->setController(QuickPositionController::class)
    ->addDelete()
    ->add('check', new Route('/{id}/check'), new Info(['POST'], 'check'))
    ->add('uncheck', new Route('/{id}/uncheck'), new Info(['POST'], 'unCheck'));

$listPositionsGroup = new Group($collection, 'list-positions.', '/list-positions');
$listPositionsGroup->setController(FullPositionController::class);
$listPositionsGroup->addDelete()
    ->add('alerts', new Route('/{id}/alerts'), new Info(['GET'], 'alerts'))
    ->add('info', new Route('/{id}'), new Info(['GET'], 'info'))
    ->add('check', new Route('/{id}/check'), new Info(['POST'], 'check'))
    ->add('uncheck', new Route('/{id}/uncheck'), new Info(['POST'], 'unCheck'));

$shops = new Group($collection, 'shops.', '/shops');
$shops->setController(ShopsController::class)
    ->addIndex()
    ->addCreate()
    ->addShow()
    ->addUpdate()
    ->addDelete();

$products = new Group($collection, 'products.', '/products');
$products->setController(ProductsController::class)
    ->addIndex()
    ->addCreate()
    ->addInfo()
    ->add(
        'name',
        new Route('/{id}/name'),
        new Info(['GET'], 'getName')
    )
    ->add(
        'measures',
        new Route('/{id}/measures'),
        new Info(['GET'], 'getMeasures')
    )
    ->add(
        'products',
        new Route('/{id}/products'),
        new Info(['GET'], 'getProducts')
    )
    ->addShow()
    ->addUpdate()
    ->addDelete();

$stuffs = new Group($collection, 'stuffs.', '/stuffs');
$stuffs->setController(StuffsController::class)
    ->addIndex()
    ->addCreate()
    ->addInfo()
    ->add(
        'measures',
        new Route('/{id}/measures'),
        new Info(['GET'], 'getMeasures')
    )
    ->addShow()
    ->addUpdate()
    ->addDelete();

$ShoppingGroup = new Group($collection, 'shopping.', '/shopping');
$ShoppingGroup->setController(ShoppingController::class)
    ->add(
        'list',
        new Route('/list/{id}'),
        new Info(['GET'], 'createFromList')
    )
    ->addIndex()
    ->addCreate()
    ->addDelete();

$alertsGroup = new Group($collection, 'alerts.', '/alerts');
$alertsGroup->setController(AlertsController::class)
    ->addIndex()
    ->addShow()
    ->addCreate()
    ->addDelete()
    ->addUpdate()
    ->add(
        'activate,',
        new Route('/{id}/activate'),
        new Info(['POST'], 'activate')
    )
    ->add(
        'deactivate,',
        new Route('/{id}/deactivate'),
        new Info(['POST'], 'deactivate')
    );

$productsListsGroup = new Group($collection, 'lists.', '/lists');
$productsListsGroup->setController(FullController::class)
    ->add('alerts', new Route('/{id}/alerts'), new Info(['GET'], 'alerts'))
    ->addIndex()
    ->addCreate()
    ->addEdit()
    ->add(
        'find-products',
        new Route('/find'),
        new Info(['GET'], 'findProducts')
    )
    ->addDelete()
    ->addUpdate()
    ->addShow();
$supplies = new Group($collection, 'supply.', '/supply');
$supplies->setController(SuppliesController::class)
    ->addIndex()
    ->addCreate()
    ->addShow()
    ->addUpdate()
    ->addDelete()
    ->add(
        'alerts.delete',
        new Route('/alerts/{id}'),
        new Info(['DELETE'], 'deleteAlert')
    )
    ->add(
        'alerts.create',
        new Route('/alerts/{id}'),
        new Info(['POST'], 'createAlert')
    );
return $collection;
