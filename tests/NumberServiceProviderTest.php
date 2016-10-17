<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Providers\NumberServiceProvider;
use Illuminate\Support\ServiceProvider;

class NumberServiceProviderTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @var Mockery\Mock
     */
    protected $application_mock;
    /**
     * @var NumberServiceProvider
     */
    protected $service_provider;

    public function setUp()
    {
        putenv('DB_DATABASE=laratest2');

        $this->setUpMocks();

        $this->service_provider = new NumberServiceProvider($this->application_mock);

        parent::setUp();
    }

    protected function setUpMocks()
    {
        $this->application_mock = Mockery::mock(\Laravel\Lumen\Application::class);
    }

    /**
     * @test
     */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->service_provider);
    }



    /**
     * Testing number service provider for every method
     *
     * @return void
     */
    public function testNumber()
    {
        $number = \App\Models\Number::where(['number' => 77]);
        $number->delete();

        $this->service_provider->createObjectFromInteger(77);
        $this->seeInDatabase('number', ['number' => 77]);

        $this->service_provider->createObjectFromInteger(77);
        $this->seeInDatabase('number', ['number' => 77, 'count' => 1]);


        \App\Models\Number::truncate();

        $this->service_provider->createObjectFromInteger(1);
        $this->service_provider->createObjectFromInteger(2);
        $this->service_provider->createObjectFromInteger(3);

        $ob = $this->service_provider->getRecentNumbers(1);

        $this->assertCount(1, $ob);

        $ob = $this->service_provider->getTopNumbers();

        $this->assertCount(3, $ob);
    }
}
