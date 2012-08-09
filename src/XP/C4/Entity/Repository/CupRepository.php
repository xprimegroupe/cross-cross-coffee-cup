<?php

namespace XP\C4\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CupRepository extends EntityRepository
{

    public function getPreviousCups($current_cup, $limit = 1)
    {
        //-- previous CUP
        $dql = 'SELECT c.id FROM XP\C4\Entity\Cup c WHERE c.created_at < :created_at AND c.id != :id ORDER BY c.created_at DESC';
        $query = $this->_em->createQuery($dql);
        $query->setParameter('created_at', $current_cup->getCreatedAt()->format('Y-m-d H:i:s'));
        $query->setParameter('id', $current_cup->getId());
        $query->setMaxResults($limit);

        return $query->getResult();
    }

    public function getNextCups($current_cup, $limit = 1)
    {
        //-- next CUP
        $dql = 'SELECT c.id FROM XP\C4\Entity\Cup c WHERE c.created_at > :created_at AND c.id != :id ORDER BY c.created_at ASC';
        $query = $this->_em->createQuery($dql);
        $query->setParameter('created_at', $current_cup->getCreatedAt()->format('Y-m-d H:i:s'));
        $query->setParameter('id', $current_cup->getId());
        $query->setMaxResults($limit);
        
        return $query->getResult();
    }

}