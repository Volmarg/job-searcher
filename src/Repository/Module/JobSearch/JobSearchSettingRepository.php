<?php

namespace App\Repository\Module\JobSearch;

use App\Entity\Module\JobSearch\JobSearchSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method JobSearchSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobSearchSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobSearchSetting[]    findAll()
 * @method JobSearchSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobSearchSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobSearchSetting::class);
    }

    /**
     * @param JobSearchSetting $searchSetting
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveSettings(JobSearchSetting $searchSetting): void {
        $this->_em->persist($searchSetting);
        $this->_em->flush();
    }

    /**
     * @param string $id
     * @throws ORMException
     */
    public function removeSettingForId(string $id): void {

        $setting = $this->find($id);

        if( !is_null($setting) ){
            $this->_em->remove($setting);
            $this->_em->flush();
            return;
        }

        throw new NotFoundHttpException("No search setting was found for id {$id}.");
    }

    /**
     * This function will remove search settings for given ids if such exist
     * @param array $ids
     * @throws ORMException
     */
    public function removeSettingsForIds(array $ids): void {

        $queryBuilder = $this->createQueryBuilder('qb');
        $queryBuilder->select('s')
            ->from(JobSearchSetting::class, "s")
            ->where("s.id IN (:ids)")
            ->setParameter(":ids", $ids, Connection::PARAM_STR_ARRAY);

        $query = $queryBuilder->getQuery();

        $searchSettings = $query->getResult();

        foreach( $searchSettings as $searchSetting ){
            $this->_em->remove($searchSetting);
        }
        $this->_em->flush();
    }

    /**
     * This function will return SearchSettings
     * @return JobSearchSetting[]
     */
    public function getAllSearchSettings(): array {
        $searchSettings = $this->findAll();
        return $searchSettings;
    }
}
