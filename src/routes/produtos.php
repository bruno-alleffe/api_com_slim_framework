<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Produto;

// Rotas para produtos
/*
ORM -> Object Relational Mapper (Mapeador de objeto relacional)
Illuminate -> é o motor da base de dados do Laravel sem o Laravel
Eloquent ORM
*/
$container = $app->getContainer();

$app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
    // Sample log message
    $container->get('logger')->info("Slim-Skeleton '/' route");

    // Render index view
    return $container->get('renderer')->render($response, 'index.phtml', $args);
});

$app->group('/api/v1', function(){
    
    // Lista produtos
    $this->get('/produtos/lista', function(Request $request, Response $response){
        
        $produtos = Produto::get();
        return $response->withJson( $produtos );

    });

    // Adicona produtos
    $this->post('/produtos/adiciona', function(Request $request, Response $response){
        
        $dados = $request->getParsedBody();

        //Validar

        $produto = Produto::create( $dados );
        return $response->withJson( $produto );

    });


    // Recupera produto para um determinado ID
    $this->get('/produtos/lista/{id}', function(Request $request, Response $response, array $args){
        
        $produto = Produto::findOrFail( $args['id'] );
        return $response->withJson( $produto );

    });

    
    // Atualiza produto para um determinado ID
    $this->put('/produtos/atualiza/{id}', function(Request $request, Response $response, array $args){
        
        $dados = $request->getParsedBody();
        $produto = Produto::findOrFail( $args['id'] );
        $produto->update( $dados );
        return $response->withJson( $produto );

    });

    // Remove produto para um determinado ID
    $this->delete('/produtos/remove/{id}', function(Request $request, Response $response, array $args){
        
        $produto = Produto::findOrFail( $args['id'] );
        $produto->delete();
        return $response->withJson( $produto );

    });

    

});
