<?php
namespace App\DataPersister;



use App\Entity\Competence;
use App\Repository\UserRepository;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GroupeCompetenceRepository;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class CompetenceDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(EntityManagerInterface $manager, CompetenceRepository $competenceRepo, GroupeCompetenceRepository $grpecompetenceRepo)
    {
        $this->manager = $manager;
        $this->competenceRepo = $competenceRepo;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Competence;
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
        // $competence = $this->competenceRepo->findOneById($data);
        // $competence->getGroupeCompetence();
        $data->setStatut(1);
        
        // dd($competence);
            $this->manager->persist($data);
            $this->manager->flush();

            return $data;
    }
}