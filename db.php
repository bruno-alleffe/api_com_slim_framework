<?php
if (PHP_SAPI != 'cli') {
   exit('Rodar via CLI');
}

require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
$dependencies = require __DIR__ . '/src/dependencies.php';
$dependencies($app);


// $db = $container->get('db');
$db = $dependencies($app)->get('db');

$schema = $db->schema();
$tabela = 'produtos';

$schema->dropIfExists( $tabela );

//Criar a tabela produtos
$schema->create($tabela, function($table){
    $table->increments('id');
	$table->string('titulo', 100);
	$table->text('descricao');
    $table->decimal('preco', 11, 2);
    $table->string('fabricante', 60);
    $table->timestamps();
	
});

//Preenche a tabela
$db->table($tabela)->insert([
    'titulo' => 'Smartphone Motorola Moto G6 32GB Dual Chip',
    'descricao' => 'Android Oreo - 8.0 Tela 5.7" Octa-Core 1.8GHz 4G Câmera 12 + 5MP (Dual Traseira) - Índigo',
    'preco' => 877.00,
    'fabricante' => 'Motorola',
    'created_at' => '2021-07-27',
    'updated_at' => '2021-07-27'
]);

$db->table($tabela)->insert([
    'titulo' => 'Iphone X Cinza Espacial 64GB',
    'descricao' => 'Tela 5.8" IOS 12 4G WI-FI Câmera 12MP - Apple',
    'preco' => 4777.00,
    'fabricante' => 'Apple',
    'created_at' => '2022-05-30',
    'updated_at' => '2022-05-30',
]);
