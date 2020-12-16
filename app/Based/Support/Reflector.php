<?php

namespace App\Based\Support;

class Reflector
{
    /**
     * Создать массив: аргумент => значение
     * @param string $class
     * @param string $method
     * @param array $data
     * @return array
     * @throws \ReflectionException
     */
    public static function createArrayForExecuteMethod(string $class, string $method, array $data)
    {
        $reflection = new \ReflectionMethod($class, $method);

        $params = $reflection->getParameters();
        $args = [];
        foreach ($params as $param) {
            $paramName = $param->getName();

            if (!isset($data[$paramName])) {
                if ($param->isOptional()) {
                    $value = null;
                }

                throw new \LogicException('Не указан '. $paramName);
            } else {
                $value = $data[$paramName];
            }

            $args[$paramName] = $value;
        }

        return $args;
    }

    /**
     * @param object|string $object
     * @return array
     * @throws \Exception
     */
    public static function getTypesHintsForProperties($object): array
    {
        $reflection = new \ReflectionClass($object);
        $result = [];
        foreach ($reflection->getMethods() as $method) {
            if (substr($method->getName(), 0, 3) !== 'set' ||
                !isset($method->getParameters()[0]) ||
                !$method->getParameters()[0]->getType()) {
                continue;
            }

            $propertyName = self::translateSetterToProperty($method->getName());

            $result[$propertyName] = $method->getParameters()[0]->getType()->getName();
        }

        return $result;
    }

    /**
     * @param object|string $object
     * @param string $type
     * @return array
     * @throws \ReflectionException
     */
    public static function getMethodsByReturnType($object, string $type): array
    {
        $reflection = new \ReflectionClass($object);
        $methods = [];

        foreach ($reflection->getMethods() as $method) {
            if ($method->getReturnType() === null) {
                continue;
            }

            if ($method->getReturnType()->getName() == $type) {
                $methods[] = $method->getName();
            }
        }

        return $methods;
    }

    /**
     * @param string$setter
     * @return string
     */
    private static function translateSetterToProperty(string $setter): string
    {
        $property = str_replace('set', '', $setter);

        return lcfirst($property);
    }
}
