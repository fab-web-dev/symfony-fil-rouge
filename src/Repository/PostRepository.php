<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Post $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Post $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findOldPosts(int $nb = 5): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.slug, p.title, p.createdAt
            FROM App\Entity\Post p
            WHERE p.active = :status
            ORDER BY p.createdAt ASC'
        )
        ->setParameter('status', true)
        ->setMaxResults($nb)
        ;
        return $query->getResult();
    }

    // Je créer une fonction findLastPosts qui possède un paramètre $nb qui est un nombre , le nombre 5 est la valeur par default .
    public function findLastPosts(int $nb = 5)
    {
        // J'utilise le QueryBulder pour constuire ma requete
        // Je donne un alias p pour faire reference aux post 
        return $this->createQueryBuilder('p')
        // andWhere est ma condition qui impose que mon post soit actif
            ->andWhere('p.active = :active')
            // Ajout d'un parametre grace au setParameter qui impose que le post soit active : true
            ->setParameter('active', true)
            // orderBy trie par date de création et par ordre descendant
            ->orderBy('p.createdAt', 'DESC')
            // le setMaxResults nous affichera le nombre maximum de resultats présent dans la variable $nb
            ->setMaxResults($nb)
            // getQuery permet de déclancher la requête SQL
            ->getQuery()
            // getResult pour obtenir le résultat
            ->getResult()
        ;
    }

    public function findRandomPhotos(int $nb = 10): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.image, p.slug
            FROM App\Entity\Post p
            WHERE p.active = :status
            ORDER BY RAND()'
        )
        ->setParameter('status', true)
        ->setMaxResults($nb)
        ;
        return $query->getResult();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
