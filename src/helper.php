<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 19-8-18
 * Time: 下午7:45
 */

if (!function_exists('create_instance_params')) {


    /**
     * @param $class
     * @param array $vars
     * @return object
     * @throws ReflectionException
     */
    function create_instance_params($class, $vars = [])
    {
        $ref = new \ReflectionClass($class);
        if (!$ref->isInstantiable()) {
            throw new Exception("类{$class} 不存在");
        }
        $constructor = $ref->getConstructor();
        if (is_null($constructor)) {
            return new $class;
        }
//        $params        = $constructor->getParameters();
//        $resolveParams = [];
//        foreach ($params as $key => $value) {
//            $name = $value->getName();
//            if (isset($dicVars[$name])) {
//                $resolveParams[] = $vars[$name];
//            } else {
//                $default = $value->isDefaultValueAvailable() ? $value->getDefaultValue() : null;
//                if (is_null($default)) {
//                    if ($value->getClass()) {
//                        $resolveParams[] = create_instance_params($value->getClass()->getName(), $vars);
//                    } else {
//                        throw new Exception("{$name} 没有传值且没有默认值。");
//                    }
//                } else {
//                    $resolveParams[] = $default;
//                }
//            }
//        }
//        var_dump($resolveParams);
        return $ref->newInstanceArgs($vars);
    }

}



if (!function_exists('create_instance_dic')) {


    /**
     * @param $class
     * @param array $dicVars
     * @return object
     * @throws ReflectionException
     */
    function create_instance_dic($class, $dicVars = [])
    {
        $ref = new \ReflectionClass($class);
        if (!$ref->isInstantiable()) {
            throw new Exception("类{$class} 不存在");
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
                        throw new Exception("{$name} 没有传值且没有默认值。");
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
    function create_instance($class)
    {
        $ref = new \ReflectionClass($class);
        if (!$ref->isInstantiable()) {
            throw new Exception("类{$class} 不存在");
        }

        return new $class;

    }
}