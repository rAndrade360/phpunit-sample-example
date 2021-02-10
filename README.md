# Testes em PHP com PHPUnit

O PHPUnit é um famoso Framework de testes em PHP que está há muito tempo no mercado e tem uma longa história para contar.

Hoje, dediquei algumas horas para aprender como ele funciona e fazer um exemplo simples para colocar a mão na massa.

## Ferramentas utilizadas no exemplo

### [GuzzleHttp](https://docs.guzzlephp.org/en/stable/index.html)

O GuzzleHttp é uma biblioteca para requisições Http bem simples e fácil de usar. Vale muito a pena conferir!

[PHPUnit](https://phpunit.de/)

Esse é o queridinho! O famoso Framework de testes para PHP

## Hands On

Para testar o framework, me utilizei de uma ideia bem simples: um buscador de CEP. Para isso usei a API do [ViaCep](https://viacep.com.br/).

A classe principal é a seguinte:

```php
<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GetCep {
  public $statusCode;

  public function execute($cep){
    $client = new Client([
      'base_uri' => 'https://viacep.com.br/ws/',
      'timeout'  => 2.0,
    ]);
    $uri = $cep.'/json';
    try {
      $response = $client->request('GET', $uri);
      $this->statusCode = $response->getStatusCode();
      return $response->getBody()->getContents();

    } catch (RequestException $ex) {
      $this->statusCode = $ex->getResponse()->getStatusCode();
    }
    
  }

  public function getStatusCode(){
    return $this->statusCode;
  }
}
```

A função dela é basicamente receber o CEP como string, fazer uma consulta ao ViaCEP e retornar os dados do CEP. Além disso, tem o atributo statusCode, que armazena o status Http da requisição.

E por fim, temos nosso arquivo de testes:

```php
<?php declare(strict_types=1);

require __DIR__.'/../getcep.php';

require __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class getcepTest extends TestCase {
  public function testCep(){
    //Assegura que a requisição vai retornar status ok!
    $getcep = new GetCep();
    $getcep->execute('65380000');
    $statusCode = $getcep->getStatusCode();
    $this->assertEquals(200, $statusCode);
  }

  public function testFailCep(){
    // Assegura que, passando um cep errado, o status retornado não será 200
    $getcep = new GetCep();
    $getcep->execute('6538000');
    $statusCode = $getcep->getStatusCode();
    $this->assertNotEquals(200, $statusCode);
  }
}
```

No exemplo, eu testo duas situações. Uma onde a requisição ocorreria com sucesso ao enviar um cep válido, e outra onde eu teria uma falha por causa de um cep inválido.

## Código fonte do exemplo

[rAndrade360/phpunit-sample-example](https://github.com/rAndrade360/phpunit-sample-example)
