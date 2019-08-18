<?php namespace Sharedsway\Helper\Test\Unit;

use Sharedsway\Helper\Test\UnitTester;

class CreateInstanceCest
{
    public function _before(UnitTester $I)
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
    }

    // tests
    public function createInstance(UnitTester $I)
    {

        $I->assertInstanceOf(Hello::class, create_instance(Hello::class));
        $I->assertInstanceOf(World::class, create_instance(World::class));
    }

    public function createInstanceDic(UnitTester $I)
    {
        /** @var Hello $hello */
        $hello = create_instance_dic(Hello::class);
        $I->assertInstanceOf(Hello::class, $hello);
        $I->assertEquals('Jim', $hello->getName());


        $helloTony = create_instance_dic(Hello::class, ['name' => 'Tony']);
        $I->assertInstanceOf(Hello::class, $helloTony);
        $I->assertEquals('Tony', $helloTony->getName());


        /** @var World $world */
        $world = create_instance_dic(World::class, ['hasDead' => true]);
        $I->assertEquals('no',$world->getEnv());
        $I->assertEquals(5,$world->getPersonCount());
        $I->assertTrue($world->getHasDead());

    }

    public function createInstanceParams(UnitTester $I)
    {
        /** @var Hello $hello */
        $hello = create_instance_params(Hello::class);
        $I->assertInstanceOf(Hello::class, $hello);
        $I->assertEquals('Jim', $hello->getName());


        $helloTony = create_instance_params(Hello::class, ['Tony']);
        $I->assertInstanceOf(Hello::class, $helloTony);
        $I->assertEquals('Tony', $helloTony->getName());


        /** @var World $world */
        $world = create_instance_params(World::class, []);
        $I->assertEquals('no',$world->getEnv());
        $I->assertEquals(5,$world->getPersonCount());
        $I->assertFalse($world->getHasDead());

        /** @var World $world */
        $world = create_instance_params(World::class, ['perfect',100,true]);
        $I->assertEquals('perfect',$world->getEnv());
        $I->assertEquals(100,$world->getPersonCount());
        $I->assertTrue($world->getHasDead());
    }

}

class Hello
{
    protected $name;

    public function __construct($name = 'Jim')
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}

class World
{
    protected $env;
    protected $personCount;
    protected $hasDead;

    public function __construct($env = "no", $personCount = 5, $hasDead = false)
    {
        $this->env         = $env;
        $this->personCount = $personCount;
        $this->hasDead     = $hasDead;
    }

    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }

    /**
     * @return int
     */
    public function getPersonCount(): int
    {
        return $this->personCount;
    }

    public function getHasDead()
    {
        return $this->hasDead;

    }
}

