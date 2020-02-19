<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findUserById($idUser,$idClient)
    {
        return $this->createQueryBuilder('user')
            ->innerJoin('user.client', 'c')
            ->where('c.id = :idClient')
            ->andWhere('user.id = :idUser')
            ->setParameter('idUser', $idUser)
            ->setParameter('idClient', $idClient)
            ->select('user.id, user.email, user.password, user.registeredAt, user.adress, user.birthDate')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findUsersByClient($idClient)
    {
        return $this->createQueryBuilder('user')
            ->innerJoin('user.client', 'c')
            ->where('c.id = :idClient')
            ->setParameter('idClient', $idClient)
            ->select('user.id, user.email, user.password, user.registeredAt, user.adress, user.birthDate')
            ->getQuery()
            ->getResult()
        ;
    }
    
}
