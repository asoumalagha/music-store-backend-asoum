<?php

declare(strict_types=1);

use Asoum\Album\Action\GetAlbumByIdAction;
use Asoum\Album\Action\GetAllAlbumAction;
use Asoum\Album\Action\AddNewAlbumAction;
use Asoum\Album\Action\DeleteAlbumAction;
use Asoum\Album\Action\UpdateAlbumAction;
use Asoum\Band\Action\AddNewBandAction;
use Asoum\Band\Action\AddPersonToBandAction;
use Asoum\Band\Action\DeleteBandAction;
use Asoum\Band\Action\DeletePersonFromBandAction;
use Asoum\Band\Action\GetAllBandAction;
use Asoum\Band\Action\GetBandByIdAction;
use Asoum\Band\Action\GetBandByPersonIdAction;
use Asoum\Band\Action\UpdateBandAction;
use Asoum\Person\Action\AddNewPersonAction;
use Asoum\Person\Action\DeletePersonAction;
use Asoum\Person\Action\GetAllPersonAction;
use Asoum\Person\Action\GetPersonByIdAction;
use Asoum\Person\Action\GetPersonByBandIdAction;
use Asoum\Person\Action\UpdatePersonAction;
use Asoum\Utility\Middleware\AlbumValidationMiddleware;
use Asoum\Utility\Middleware\BandValidationMiddleware;
use Asoum\Utility\Middleware\NameValidationMiddleware;
use Asoum\Song\Action\GetSongByIdAction;
use Asoum\Song\Action\GetSongByAlbumIdAction;
use Asoum\Song\Action\GetAllSongAction;
use Asoum\Song\Action\AddNewSongAction;
use Asoum\Song\Action\DeleteSongAction;
use Asoum\Song\Action\UpdateSongAction;
use Asoum\Utility\Middleware\PersonValidationMiddleware;

//Routes related to Person

$app->get('/person', GetAllPersonAction::class);
$app->get('/person/{id:[0-9]+}', GetPersonByIdAction::class);
$app->get('/person/{id:[0-9]+}/band', GetBandByPersonIdAction::class);


$app->post('/person', AddNewPersonAction::class)
    ->add(NameValidationMiddleware::class);


$app->put('/person/{id:[0-9]+}', UpdatePersonAction::class)
    ->add(NameValidationMiddleware::class);


$app->delete('/person/{id:[0-9]+}', DeletePersonAction::class);

//Routes related to Band

$app->get('/band', GetAllBandAction::class);
$app->get('/band/{id:[0-9]+}', GetBandByIdAction::class);
$app->get('/band/{id:[0-9]+}/person', GetPersonByBandIdAction::class);

$app->post('/band/{id:[0-9]+}/person', AddPersonToBandAction::class)
    ->add(PersonValidationMiddleware::class); //IMPLEMENT
$app->post('/band', AddNewBandAction::class)
    ->add(NameValidationMiddleware::class);


$app->put('/band/{id:[0-9]+}', UpdateBandAction::class)
    ->add(NameValidationMiddleware::class);

$app->delete('/band/{id:[0-9]+}', DeleteBandAction::class);
$app->delete('/band/{id:[0-9]+}/person', DeletePersonFromBandAction::class)
    ->add(PersonValidationMiddleware::class);

//Routes related to Album

$app->get('/album', GetAllAlbumAction::class);
$app->get('/album/{id:[0-9]+}', GetAlbumByIdAction::class);

$app->post('/album', AddNewAlbumAction::class)
    ->add(NameValidationMiddleware::class)
    ->add(BandValidationMiddleware::class);


$app->put('/album/{id:[0-9]+}', UpdateAlbumAction::class)
    ->add(NameValidationMiddleware::class)
    ->add(BandValidationMiddleware::class);


$app->delete('/album/{id:[0-9]+}', DeleteAlbumAction::class);

//Routes related to Song
$app->get('/song', GetAllSongAction::class);
$app->get('/song/{id:[0-9]+}', GetSongByIdAction::class);
$app->get('/album/{id:[0-9]+}/song', GetSongByAlbumIdAction::class);

$app->post('/song', AddNewSongAction::class)
    ->add(NameValidationMiddleware::class)
    ->add(AlbumValidationMiddleware::class);

$app->put('/song/{id:[0-9]+}', UpdateSongAction::class)
    ->add(NameValidationMiddleware::class)
    ->add(AlbumValidationMiddleware::class);

$app->delete('/song/{id:[0-9]+}', DeleteSongAction::class);