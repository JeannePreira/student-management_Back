<?php
namespace App\DataPersister;


use App\Entity\Profil;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class ProfilDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Profil;
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
       
       $users = $data->getUsers();
    //    dd($users);
        $data->setStatut(1);

        foreach($users as $val){
            $val->setDeleted(1);
            $this->manager->persist($val);
        }
        $this->manager->persist($data);
        $this->manager->flush();
    //   dd($data);
        return $data;
    }
}