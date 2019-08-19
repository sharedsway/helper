<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 19-8-18
 * Time: 下午7:45
 */
use Sharedsway\Common;


if (!function_exists('create_instance_params')) {

    /**
     * @param $class
     * @param array $vars
     * @return object
     * @throws Common\Exception
     */
    function create_instance_params($class, $vars = [])
    {
        try {

            $ref = new \ReflectionClass($class);
            if (!$ref->isInstantiable()) {
                throw new Common\Exception("类{$class} 不存在");
            }
            $constructor = $ref->getConstructor();
            if (is_null($constructor)) {
                return new $class;
            }
            return $ref->newInstanceArgs($vars);
        } catch (ReflectionException $exception) {
            throw new Common\Exception($exception->getMessage());
        }
    }

}



if (!function_exists('create_instance_dic')) {


    /**
     * @param $class
     * @param array $dicVars
     * @return object
     * @throws Common\Exception
     */
    function create_instance_dic($class, $dicVars = [])
    {
        $ref = null;
        try {

            $ref = new \ReflectionClass($class);
        } catch (ReflectionException $exception) {
            throw new Common\Exception($exception->getMessage());
        }
        if (!$ref->isInstantiable()) {
            throw new Common\Exception("类{$class} 不存在");
        }
        $constructor = $ref->getConstructor();
        if (is_null($constructor)) {
            return new $class;
        }
        $params        = $constructor->getParameters();
        $resolveParams = [];
        foreach ($params as $key => $value) {
            $name = $value->getName();
            if (isset($dicVars[$name])) {
                $resolveParams[] = $dicVars[$name];
            } else {
                $default = $value->isDefaultValueAvailable() ? $value->getDefaultValue() : null;
                if (is_null($default)) {
                    if ($value->getClass()) {
                        $resolveParams[] = create_instance_dic($value->getClass()->getName(), $dicVars);
                    } else {
                        throw new Common\Exception("{$name} 没有传值且没有默认值。");
                    }
                } else {
                    $resolveParams[] = $default;
                }
            }
        }
        return $ref->newInstanceArgs($resolveParams);
    }

}

if (!function_exists('create_instance')) {

    /**
     * @param $class
     * @return mixed
     * @throws Common\Exception
     */
    function create_instance($class)
    {
        try {

            $ref = new \ReflectionClass($class);
            if (!$ref->isInstantiable()) {
                throw new Common\Exception("类{$class} 不存在");
            }

            return new $class;
        } catch (ReflectionException $exception) {
            throw new Common\Exception($exception->getMessage());
        }

    }
}