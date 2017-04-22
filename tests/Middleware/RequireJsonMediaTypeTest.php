<?php


namespace Tests\Middleware;


use App\Middleware\RequireJsonMediaType;
use PHPUnit\Framework\TestCase;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class RequireJsonMediaTypeTest extends TestCase
{
    /** @var RequireJsonMediaType */
    protected $middleware;

    /** @var Request */
    protected $request;

    protected function setUp()
    {
        $environment = Environment::mock();

        $this->middleware = new RequireJsonMediaType;
        $this->request    = Request::createFromEnvironment($environment);
    }

    public function testReturnsResponse()
    {
        $response =
            $this->middleware->__invoke($this->request->withHeader('Content-Type', 'unkown/type'), new Response);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testChecksContentTypeHeader()
    {
        $response =
            $this->middleware->__invoke($this->request->withHeader('Content-Type', 'unkown/type'), new Response);

        $json = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('errors', $json);
    }

    public function testChecksAcceptHeader()
    {
        $response = $this->middleware->__invoke($this->request->withHeader('Accept', 'unkown/type'), new Response);

        $json = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('errors', $json);
    }

    public function testAcceptsJson()
    {
        $request = $this->request
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json');


        $response = $this->middleware->__invoke($request, new Response);

        $this->assertEmpty((string)$response->getBody());
    }

    public function testReturnsStatusCode415()
    {
        $response =
            $this->middleware->__invoke($this->request->withHeader('Content-Type', 'unkown/type'), new Response);

        $this->assertEquals(415, $response->getStatusCode());
    }

    public function testErrorResponseContainsDetails()
    {
        $response =
            $this->middleware->__invoke($this->request->withHeader('Content-Type', 'unkown/type'), new Response);

        $json = json_decode((string)$response->getBody(), true);

        $error = $json['errors'][0];

        $this->assertArrayHasKey('errors', $json);

        $this->assertEquals('Unsupported media type', $error['title']);
        $this->assertContains('Content-Type', $error['detail']);
    }

}