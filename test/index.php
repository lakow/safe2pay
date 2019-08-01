<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 

require __DIR__ . '/../vendor/autoload.php';

use Safe2Pay\Safe2Pay;
use Safe2Pay\PaymentType;

$token = '00CB173A9AB442BDA92EC1B8DEE1EC0C';

$safe2Pay = new Safe2Pay($token);
$safe2Pay->isSandbox(true);

$customer = $safe2Pay->customer()
    ->create([
        'name' => 'Joao da Silva',
        'document' => '00000000000',
        'email' => 'joao@email.com'
    ])
    ->setAddress([
        'zip_code' => '81270600',
        'street' => 'Rua João Bettega',
        'number' => '1000',
        'neighborhood' => 'Cidade Industrial',
        'city' => 'Curitiba',
        'uf' => 'PR'
    ]);

$orders = $safe2Pay->orders()
    ->addItem('001', 'Camiseta', '25.00')
    ->addItem('002', 'Calça', '25.00')
    ->setCustomer($customer)
    ->payment(
        PaymentType::BANK_SLIP, [
            'duo_date' => (new \DateTime('now'))->format('d/m/Y'), 
            'instruction' => 'Instrução de Exemplo',
            'messages' => ['teste 1', 'teste 2']
        ]
    )
    ->notification('https://www.site.com.br/callback')
    ->execute();


echo '<pre>';

echo 'Response: ';
print_r($orders->getResponse());
echo '<br>';

echo 'Has Error: ';
print_r($orders->hasError());
echo '<br>';

echo 'Error: ';
print_r($orders->errorMessage());
