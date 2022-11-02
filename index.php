<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/model/Contatos.php';

$app = AppFactory::create();
$contatos = new Contatos();


function verifPOST(array $data): int
{
    $all = [
        array_key_exists("nomecontato", $data),
        array_key_exists("emailcontato", $data),
        array_key_exists("telcontato", $data),
    ];

    return count(array_unique($all)) === 1 && $all[0];
}

// GET

$app->get('/contatos/', function (Request $request, Response $response) use ($contatos) {
    $query = $contatos->read();
    $response->getBody()->write(json_encode($query, JSON_UNESCAPED_UNICODE));
    return $response;
});

$app->get('/contatos/{id}', function (Request $request, Response $response, array $args) use ($contatos) {
    $id = $args['id'];
    $query = $contatos->readWithId($id);
    $response->getBody()->write(json_encode($query, JSON_UNESCAPED_UNICODE));
    return $response;
});

// POST
$app->post('/contatos', function (Request $request, Response $response) use ($contatos) {

    $dados = file_get_contents('php://input');
    $array = json_decode($dados, true);
    $message = "";
    if (verifPOST($array)){ // ALL TRUE
        $contatos->setNomeContato($array["nomecontato"]);
        $contatos->setEmailContato($array["emailcontato"]);
        $contatos->setTelContato($array["telcontato"]);

        $contatos->write($contatos);

        $message = "DATA WRITE " . json_encode($array);
    }else {
        $message = "INVALID DATA";
    }
    $response->getBody()->write($message);
    return $response;
});

// PUT
$app->put('/contatosPut/{id}', function (Request $request, Response $response, array $args) use ($contatos) {
    $id = $args['id'];
    $dados = file_get_contents('php://input');
    $array = json_decode($dados, true);
    $contatos->setIdContato($id);
    $contatos->setNomeContato($array["nomecontato"]);
    $contatos->setEmailContato($array["emailcontato"]);
    $contatos->setTelContato($array["telcontato"]);

    $contatos->update($contatos);
    $response->getBody()->write("DATA UPDATE {$id} : " . json_encode($array));
    return $response;
});

$app->delete('/contatosDelete/{id}', function (Request $request, Response $response, array $args) use ($contatos) {
    $id = $args['id'];
    $contatos->delete($id);
    $response->getBody()->write("DELETED!");
    return $response;
});


$app->run();