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
