<?php
/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 09/12/2015
 * Time: 10:59
 */

namespace Padosoft\LaravelComposerSecurity\Test;

use Illuminate\Console\Command;

use \Mockery as m;
use \Illuminate\Support\Facades\File;
use \Padosoft\LaravelComposerSecurity\SensiolabHelper;
use \GuzzleHttp\Client;
use \GuzzleHttp\Exception;
use \GuzzleHttp\Exception\ClientException;
use \GuzzleHttp\Exception\RequestException;
use \GuzzleHttp\Handler\MockHandler;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Psr7\Request;
use \GuzzleHttp\HandlerStack;

class SensiolabHelperTest extends \Padosoft\LaravelTest\TestBase
{

    protected $guzzle;
    protected $command;
    protected $mockCommand;
    protected $mockResponse;
    protected $mockRequest;

    /**
     * 
     */

    public function setUp()
    {
        $this->guzzle = new Client();

        $this->mockCommand = m::mock('Illuminate\Console\Command');
        $this->mockCommand->shouldReceive('option')->with('verbose')->andReturn(true);
        $this->mockCommand->shouldReceive('line');
        $this->mockCommand->shouldReceive('error');
        $this->mockCommand->shouldReceive('info');
        $this->mockCommand->shouldReceive('comment');

        $mockMessageInterface = m::mock('\Psr\Http\Message\MessageInterface');
        $mockMessageInterface->shouldReceive('getContents');

        $this->mockResponse = m::mock('\Psr\Http\Message\ResponseInterface');
        $this->mockResponse->shouldReceive('getStatusCode');
        $this->mockResponse->shouldReceive('getHeaders')->andReturn([]);
        $this->mockResponse->shouldReceive('getBody')->andReturn($mockMessageInterface);

        $this->mockRequest = m::mock('\Psr\Http\Message\RequestInterface');
        $this->mockRequest->shouldReceive('getHeaders')->andReturn([]);
        $this->mockRequest->shouldReceive('getBody');


        parent::setUp();
    }

    /** @test
     *  Utilizzo i lfile composer.lock presente nella directory con vulnerabilità note per testare
     *  la connettività a sensiolabs, confronto poi la risposta di sensiolabs con il file risposta.json
     *  per controallare che non vi siano differenze di risposta del web service nel tempo
     */
    public function testGetSensiolabVulnerabilties()
    {
        $sensiolabHelper = new SensiolabHelper($this->guzzle,$this->mockCommand);
        $response = $sensiolabHelper->getSensiolabVulnerabilties(__DIR__.'/test_file/composer_ko/composer.lock');
        $this->assertArrayHasKey('version',$response[array_keys($response)[0]]);
        $this->assertArrayHasKey('advisories',$response[array_keys($response)[0]]);
        $this->assertArrayHasKey('title',$response[array_keys($response)[0]]['advisories'][array_keys($response[array_keys($response)[0]]['advisories'])[0]]);
        $this->assertArrayHasKey('link',$response[array_keys($response)[0]]['advisories'][array_keys($response[array_keys($response)[0]]['advisories'])[0]]);
        $this->assertArrayHasKey('cve',$response[array_keys($response)[0]]['advisories'][array_keys($response[array_keys($response)[0]]['advisories'])[0]]);
    }

    /** @test
     */
    public function testGetSensiolabVulnerabiltiesClientException()
    {
        $mockClientException = m::mock('\GuzzleHttp\Exception\ClientException');
        $mockClientException->shouldReceive('getResponse')->times(3)->andReturn($this->mockResponse);
        $mockClientException->shouldReceive('getRequest')->once()->andReturn($this->mockRequest);

        $mockGuzzleClientException = m::mock('\GuzzleHttp\Client');
        $mockGuzzleClientException->shouldReceive('request')->once()->andThrow($mockClientException);

        $sensiolabHelperClientException = new SensiolabHelper($mockGuzzleClientException,$this->mockCommand);
        $response = $sensiolabHelperClientException->getSensiolabVulnerabilties(__DIR__.'/test_file/composer_ko/composer.lock');
        $this->assertEquals(null,$response);

    }

    /** @test     */
    public function testGetSensiolabVulnerabiltiesRequestException()
    {
        $mockRequestException = m::mock('\GuzzleHttp\Exception\RequestException');
        $mockRequestException->shouldReceive('getResponse')->times(3)->andReturn($this->mockResponse);
        $mockRequestException->shouldReceive('getRequest')->once()->andReturn($this->mockRequest);
        $mockRequestException->shouldReceive('hasResponse')->once()->andReturn(true);

        $mockGuzzleRequestException = m::mock('\GuzzleHttp\Client');
        $mockGuzzleRequestException->shouldReceive('request')->once()->andThrow($mockRequestException);

        $sensiolabHelperRequestException = new SensiolabHelper($mockGuzzleRequestException,$this->mockCommand);
        $response = $sensiolabHelperRequestException->getSensiolabVulnerabilties(__DIR__.'/test_file/composer_ko/composer.lock');
        $this->assertEquals(null,$response);
    }

    /** @test
     */
    public function testParseVulnerability()
    {
        $response = json_decode(File::get(__DIR__.'/risposta.json'),true);
        $tableVulnerabilities = [];
        $sensiolabHelper = new SensiolabHelper($this->guzzle,$this->mockCommand);
        foreach ($response as $key => $vulnerability) {

            foreach($sensiolabHelper->parseVulnerability($key, $vulnerability) as $vul) {
                $tableVulnerabilities[]=$vul;
            }
        }
        $this->assertEquals(File::get(__DIR__.'/parseVulnerability.json'), json_encode($tableVulnerabilities));

    }

    /** @test
     *
     */
    public function testExceptionWithMockHandler()
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            //new Response(200, ['X-Foo' => 'Bar']),
            //new Response(202, ['Content-Length' => 0]),
            new RequestException("Error Communicating with Server", new Request('GET', 'test')),
            new ClientException("Client error",new Request('GET', 'test'),new Response(202, []),null,[])
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $sensio = new SensiolabHelper($client,$this->mockCommand);
        $this->assertEquals(null,$sensio->getSensiolabVulnerabilties(__DIR__.'/test_file/composer_ko/composer.lock'));
        $this->assertEquals(null,$sensio->getSensiolabVulnerabilties(__DIR__.'/test_file/composer_ko/composer.lock'));

    }


    public function tearDown() {
        \Mockery::close();
    }
}
