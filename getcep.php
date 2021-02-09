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