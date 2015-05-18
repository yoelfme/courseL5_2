<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseSeeder extends Seeder
{
    protected static $pool = array();

	abstract public function getModel();
	abstract public function getDummyData(Generator $faker, array $customValues = array());

	protected function createMultiple($total, array $customValues = array())
	{
		for ($i=0; $i < $total; $i++) { 
			$this->create($customValues);
		}
	}

	protected function create(array $customValues = array())
	{
        $values = $this->getDummyData(Faker::create(), $customValues);
        $values = array_merge($values, $customValues);

        return $this->addToPool($this->getModel()->create($values));
	}

    protected function createFrom($seeder, array $customValues = array())
    {
        $seeder = new $seeder;
        return $seeder->create($customValues);
    }

    protected function getRandom($model)
    {
        if(! $this->collectionExists($model)) {
            throw new Exception("The $model collection does not exist");
        }

        return static::$pool[$model]->random();
    }

    protected function addToPool($entity)
    {
        $reflection = new ReflectionClass($entity);
        $class = $reflection->getShortName();

        if(! $this->collectionExists($class))
        {
            static::$pool[$class] = new Collection();
        }

        static::$pool[$class]->add($entity);

        return $entity;
    }

    protected function collectionExists($class)
    {
        return isset(static::$pool[$class]);
    }

}