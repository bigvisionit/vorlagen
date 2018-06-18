<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TestRepository extends EntityRepository
{
    public function findAllOrderedByFirstname()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT t FROM AppBundle:Test t ORDER BY t.firstname ASC'
            )
            ->getResult();
    }
}