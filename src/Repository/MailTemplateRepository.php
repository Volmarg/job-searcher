<?php

namespace App\Repository;

use App\Entity\MailTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method MailTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method MailTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method MailTemplate[]    findAll()
 * @method MailTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MailTemplate::class);
    }

    /**
     * @param MailTemplate $mailTemplate
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveMailTemplate(MailTemplate $mailTemplate): void {
        $this->_em->persist($mailTemplate);
        $this->_em->flush();
    }

    /**
     * @param string $id
     * @throws ORMException
     */
    public function removeMailTemplateForId(string $id): void {

        $mailTemplate = $this->_em->getRepository(MailTemplate::class)->find($id);

        if( !empty($mailTemplate) ){
            $this->_em->remove($mailTemplate);
            $this->_em->flush();
            return;
        }

        throw new \Exception("No mail template was found for id {$id}.", 400);

    }
}
