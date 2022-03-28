<?php
// CalculatorTest.php
namespace App\Test\TestCase\Support;

use App\Test\Traits\AppTestTrait;

use PHPUnit\Framework\TestCase;

// Oubliez pas d'ajouter extends TestCase
class GetUsersTest extends TestCase
{
    use AppTestTrait;

    public function testUserValidReturnStatement(): void
    {
        // Les valeurs de retour attendues


        // On crée la requête en faisant un appel à la route à tester
        // la fonction createJsonRequest provient du trait AppTestTrait
        $request = $this->createJsonRequest('GET', '/users');
        // On effectue la requête et récupère le résultat
        $response = $this->app->handle($request);
        
        // selectionner le usager 10 dans la réponse
        $user = json_decode($response->getBody()->getContents(), true)[1];
        //print user in the console
        print_r($user);

        $this->assertSame(201, $response->getStatusCode());
    }
}