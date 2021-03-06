<?php

namespace App\Repository;

use App\Entity\SearchSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method SearchSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchSetting[]    findAll()
 * @method SearchSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchSetting::class);
    }

    /**
     * @param SearchSetting $searchSetting
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveSettings(SearchSetting $searchSetting): void {
        $this->_em->persist($searchSetting);
        $this->_em->flush();
    }

    /**
     * @param string $id
     * @throws ORMException
     */
    public function removeSettingForId(string $id): void {

        $settings = $this->_em->getRepository(SearchSetting::class)->find($id);

        if( !empty($settings) ){
            $setting = reset($settings);
            $this->_em->remove($setting);
            $this->_em->flush();
            return;
        }

        throw new \Exception("No search setting was found for id {$id}.", 400);
    }

    /**
     * This function will remove search settings for given ids if such exist
     * @param array $ids
     * @throws ORMException
     */
    public function removeSettingsForIds(array $ids): void {

        $queryBuilder = $this->createQueryBuilder('qb');
        $queryBuilder->select('s')
            ->from(SearchSetting::class, "s")
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
     * @return SearchSetting[]
     */
    public function getAllSearchSettings(): array {
        $searchSettings = $this->_em->getRepository(SearchSetting::class)->findAll();
        return $searchSettings;
    }
}
