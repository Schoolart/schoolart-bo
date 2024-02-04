<?php
namespace App\DataPersister;
use App\Entity\Admin;
use App\Entity\User;
use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Service\ContactNotification;
use Doctrine\ORM\EntityManagerInterface;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private $userPasswordEncoder;
    private $notify;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordEncoder,ContactNotification $notif)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->notify = $notif;
    }
    public function supports($data): bool
    {
        return  $data instanceof Admin || $data instanceof User || $data instanceof Etudiant || $data instanceof Professeur;
    }
    /**
     * @param User|Etudiant|Admin|Professeur| $data
     */
    public function persist($data)
    {
        if ($data->getPlainPassword()) {
            $data->setPss(base64_encode($data->getPlainPassword()));
            //$this->notify->notification($data,$data->getPassword());
            $data->setPassword(
                $this->userPasswordEncoder->hashPassword($data, $data->getPlainPassword())
            );
            $data->eraseCredentials();
        }
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}