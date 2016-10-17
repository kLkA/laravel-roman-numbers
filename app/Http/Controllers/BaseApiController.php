<?php
namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Laravel\Lumen\Application;


class BaseApiController extends Controller
{
    protected $request;

    public function __construct(Application $app, \Dingo\Api\Http\Request $request = null)
    {
        static $dependencies;

        // Get parameters
        if ($dependencies === null)
        {
            $reflector = new \ReflectionClass(__CLASS__);
            $constructor = $reflector->getConstructor();
            $dependencies = $constructor->getParameters();
        }

        foreach ($dependencies as $dependency)
        {
            // Process only omitted optional parameters
            if (${$dependency->name} === null)
            {
                // Assign variable
                ${$dependency->name} = $app->make($dependency->getClass()->name);
            }
        }


        $this->request = $request;
    }

    use Helpers;
}