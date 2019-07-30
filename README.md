# Safe2Pay
SDK do Safe2Pay para a linguagem PHP

## Instalação

```bash
composer require lakow/safe2pay
```

## Pagamento via boleto

```php
use Safe2Pay\Safe2Pay;
use Safe2Pay\PaymentType;

$token = 'XXXXXXXXXXXXXXXXXXXXXXX';

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
```
