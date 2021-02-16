<?php
namespace App\DataPersister;



use App\Entity\GroupeCompetence;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class GroupeCompetenceDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof GroupeCompetence;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibelle($data->getLibelle());
        $competence = $this->manager->persist($data);
        $this->manager->flush($competence);
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setStatut(1);
        $this->manager->persist($data);
        // dd($data);
            $this->manager->flush();

            return $data;
    }
}