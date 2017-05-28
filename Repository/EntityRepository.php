<?php

namespace Lernpad\EntityBundle\Repository;

use Doctrine\ORM\EntityRepository as BaseRepository;

class EntityRepository extends BaseRepository
{

    public function findOneOrCreate(array $criteria)
    {
        $entity = $this->findOneBy($criteria);
        if (null === $entity) {
            $class = $this->_class->getName();
            $entity = new $class;
            foreach ($criteria as $key => $value) {
                $fieldName = lcfirst(\Doctrine\Common\Util\Inflector::classify($key));
                call_user_func([$entity, 'set' . ucfirst($fieldName)], $value);
            }
        }
        return $entity;
    }

    public function findLastOrNew(array $criteria)
    {
        $entity = $this->findOneBy($criteria, ['id' => 'DESC']);

        if (null === $entity) {
            $class = $this->_class->getName();
            $entity = new $class;
        }
        return $entity;
    }

}
