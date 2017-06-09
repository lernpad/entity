<?php

namespace Lernpad\EntityBundle\Repository;

use Doctrine\ORM\EntityRepository as BaseRepository;

class EntityRepository extends BaseRepository
{

    public function findOneOrCreate(array $criteria, array $orderBy = null)
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

}
