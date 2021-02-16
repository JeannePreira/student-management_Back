<?php
namespace App\DataPersister;



use App\Entity\ProfilSortie;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class ProfilSortieDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof ProfilSortie;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibelle($data->getLibelle());
        $dataUser = $this->manager->persist($data);
        $this->manager->flush($dataUser);
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setStatut(1);
           
            $this->manager->persist($data);
            $this->manager->flush();

            return $data;
    }
}