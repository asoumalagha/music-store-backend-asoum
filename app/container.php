<?php

declare(strict_types=1);


use Asoum\Album\Action\AddNewAlbumAction;
use Asoum\Album\Action\DeleteAlbumAction;
use Asoum\Album\Action\GetAlbumByIdAction;
use Asoum\Album\Action\GetAllAlbumAction;
use Asoum\Album\Action\UpdateAlbumAction;
use Asoum\Album\Model\AlbumModel;
use Asoum\Album\Repository\AlbumRepository;
use Asoum\Band\Action\AddNewBandAction;
use Asoum\Band\Action\AddPersonToBandAction;
use Asoum\Band\Action\DeleteBandAction;
use Asoum\Band\Action\DeletePersonFromBandAction;
use Asoum\Band\Action\GetAllBandAction;
use Asoum\Band\Action\GetBandByIdAction;
use Asoum\Band\Action\GetBandByPersonIdAction;
use Asoum\Band\Action\UpdateBandAction;
use Asoum\Band\Model\BandModel;
use Asoum\Band\Repository\BandRepository;
use Asoum\Person\Action\AddNewPersonAction;
use Asoum\Person\Action\DeletePersonAction;
use Asoum\Person\Action\GetAllPersonAction;
use Asoum\Person\Action\GetPersonByBandIdAction;
use Asoum\Person\Action\GetPersonByIdAction;
use Asoum\Person\Action\UpdatePersonAction;
use Asoum\Person\Model\PersonModel;
use Asoum\Person\Repository\PersonRepository;
use Asoum\Song\Action\AddNewSongAction;
use Asoum\Song\Action\DeleteSongAction;
use Asoum\Song\Action\DeleteUserAction;
use Asoum\Song\Action\GetAllSongAction;
use Asoum\Song\Action\GetSongByAlbumIdAction;
use Asoum\Song\Action\GetSongByIdAction;
use Asoum\Song\Action\GetSongByUserIdAction;
use Asoum\Song\Action\GetUserByIdAction;
use Asoum\Song\Action\UpdateSongAction;
use Asoum\Song\Action\UpdateUserAction;
use Asoum\Song\Model\SongModel;
use Asoum\Song\Repository\SongRepository;
use Asoum\User\Action\AddNewUserAction;
use Asoum\User\Model\UserModel;
use Asoum\User\Repository\UserRepository;
use Asoum\Utility\Action\ExceptionHandlerAction;
use Asoum\Utility\Action\NotAllowedErrorHandlerAction;
use Asoum\Utility\Action\NotFoundHandlerAction;
use Asoum\Utility\Action\PHPErrorHandlerAction;
use Asoum\Utility\Middleware\AlbumValidationMiddleware;
use Asoum\Utility\Middleware\BandValidationMiddleware;
use Asoum\Utility\Middleware\NameValidationMiddleware;
use Asoum\Utility\Middleware\PersonValidationMiddleware;
use Clickalicious\Memcached\Cache;
use Slim\App;
use Slim\Container;


$container = new Container();


//Logger
$container['logger'] = function ($container) {
    $settings = $container['config']['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

//Database
$container['database'] = function ($container) {
    $settings = $container['config']['db'];
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $settings['host'],
        $settings['dbname'],
        'utf8mb4'
    );
    $pdo = new PDO($dsn, $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

//Memcached
$container['cache'] = function () {
    $cache = new Cache('127.0.0.1');
    return $cache;
};

//Error handling
$container['errorHandler'] = function ($container) {
    return new ExceptionHandlerAction($container['logger']);
};

$container['notAllowedHandler'] = function ($container) {
    return new NotAllowedErrorHandlerAction($container['logger']);
};

$container['notFoundHandler'] = function ($container) {
    return new NotFoundHandlerAction($container['logger']);
};

$container['phpErrorHandler'] = function ($container) {
    return new PHPErrorHandlerAction($container['logger']);
};

//Middleware

$container[NameValidationMiddleware::class] = function ($container){
    return new NameValidationMiddleware();
};

$container[BandValidationMiddleware::class] = function ($container){
    return new BandValidationMiddleware();
};

$container[PersonValidationMiddleware::class] = function ($container){
    return new PersonValidationMiddleware();
};

$container[AlbumValidationMiddleware::class] = function ($container){
    return new AlbumValidationMiddleware();
};

//Person settings
$container[PersonRepository::class] = function ($container) {
    return new PersonRepository($container['database']);
};

$container[PersonModel::class] = function ($container) {
    return new PersonModel(
        $container['logger'],
        $container[PersonRepository::class]
    );
};


//Person actions
$container[GetAllPersonAction::class] = function ($container) {
    return new GetAllPersonAction($container[PersonModel::class]);
};

$container[GetPersonByIdAction::class] = function ($container) {
    return new GetPersonByIdAction($container[PersonModel::class]);
};

$container[GetPersonByBandIdAction::class] = function ($container) {
    return new GetPersonByBandIdAction($container[PersonModel::class]);
};

$container[AddNewPersonAction::class] = function ($container) {
    return new AddNewPersonAction($container[PersonModel::class]);
};

$container[UpdatePersonAction::class] = function ($container) {
    return new UpdatePersonAction($container[PersonModel::class]);
};

$container[DeletePersonAction::class] = function ($container) {
    return new DeletePersonAction($container[PersonModel::class]);
};

//Band settings

$container[BandRepository::class] = function ($container) {
    return new BandRepository(
        $container['database']
    );
};

$container[BandModel::class] = function ($container) {
    return new BandModel(
        $container['logger'],
        $container[BandRepository::class]
    );
};

//Band actions
$container[GetAllBandAction::class] = function ($container) {
    return new GetAllBandAction($container[BandModel::class]);
};

$container[GetBandByIdAction::class] = function ($container) {
    return new GetBandByIdAction($container[BandModel::class]);
};

$container[GetBandByPersonIdAction::class] = function ($container) {
    return new GetBandByPersonIdAction($container[BandModel::class]);
};

$container[AddNewBandAction::class] = function ($container) {
    return new AddNewBandAction($container[BandModel::class]);
};

$container[AddPersonToBandAction::class] = function ($container) {
    return new AddPersonToBandAction($container[BandModel::class]);
};

$container[UpdateBandAction::class] = function ($container) {
    return new UpdateBandAction($container[BandModel::class]);
};

$container[DeleteBandAction::class] = function ($container) {
    return new DeleteBandAction($container[BandModel::class]);
};

$container[DeletePersonFromBandAction::class] = function ($container) {
    return new DeletePersonFromBandAction($container[BandModel::class]);
};

//Album settings
$container[AlbumModel::class] = function ($container) {
    return new AlbumModel(
        $container['logger'],
        $container[AlbumRepository::class]
    );
};

$container[AlbumRepository::class] = function ($container) {
    return new AlbumRepository(
        $container['database']
    );
};

//Album actions
$container[GetAllAlbumAction::class] = function ($container) {
    return new GetAllAlbumAction($container[AlbumModel::class]);
};

$container[GetAlbumByIdAction::class] = function ($container) {
    return new GetAlbumByIdAction($container[AlbumModel::class]);
};

$container[AddNewAlbumAction::class] = function ($container) {
    return new AddNewAlbumAction($container[AlbumModel::class]);
};

$container[UpdateAlbumAction::class] = function ($container) {
    return new UpdateAlbumAction($container[AlbumModel::class]);
};

$container[DeleteAlbumAction::class] = function ($container) {
    return new DeleteAlbumAction($container[AlbumModel::class]);
};

//Song settings

$container[SongModel::class] = function ($container) {
    return new SongModel(
        $container['logger'],
        $container[SongRepository::class]
    );
};

$container[SongRepository::class] = function ($container) {
    return new SongRepository(
        $container['database']
    );
};

//Song actions

$container[GetAllSongAction::class] = function ($container) {
    return new GetAllSongAction($container[SongModel::class]);
};

$container[GetSongByIdAction::class] = function ($container) {
    return new GetSongByIdAction($container[SongModel::class]);
};

$container[GetSongByAlbumIdAction::class] = function ($container) {
    return new GetSongByAlbumIdAction($container[SongModel::class]);
};

$container[GetSongByUserIdAction::class] = function ($container) {
    return new GetSongByUserIdAction($container[SongModel::class]);
};

$container[AddNewSongAction::class] = function ($container) {
    return new AddNewSongAction($container[SongModel::class]);
};

$container[UpdateSongAction::class] = function ($container) {
    return new UpdateSongAction($container[SongModel::class]);
};

$container[DeleteSongAction::class] = function ($container) {
    return new DeleteSongAction($container[SongModel::class]);
};

//User settings

$container[UserModel::class] = function ($container) {
    return new UserModel(
        $container['logger'],
        $container[UserRepository::class]
    );
};

$container[UserRepository::class] = function ($container) {
    return new UserRepository(
        $container['database']
    );
};

//User actions

$container[GetUserByIdAction::class] = function ($container) {
    return new GetUserByIdAction($container[UserModel::class]);
};

$container[AddNewUserAction::class] = function ($container) {
    return new AddNewUserAction($container[UserModel::class]);
};

$container[UpdateUserAction::class] = function ($container) {
    return new UpdateUserAction($container[UserModel::class]);
};

$container[DeleteUserAction::class] = function ($container) {
    return new DeleteUserAction($container[SongModel::class]);
};

//App
$container[App::class] = function ($container) {
    return new App($container);
};

return $container;


