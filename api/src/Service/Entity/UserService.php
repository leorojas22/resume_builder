<?php
namespace App\Service\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\ValidationService;
use App\Entity\User;

class UserService extends BaseEntityService
{
    private $passwordEncoder;
    protected $entityClass = User::class;

    public function __construct(ObjectManager $om, ValidationService $validator, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($om, $validator);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create($properties = [])
    {
        parent::create($properties);
        $password             = isset($properties['password']) ? $properties['password'] : "";
        $passwordConfirmation = isset($properties['password_confirmation']) ? $properties['password_confirmation'] : "";

        $errors = [];
        if($password != $passwordConfirmation)
        {
            $errors[] = "Password does not match the password confirmation.";
        }

        if(strlen($password) < 6)
        {
            $errors[] = "Password should be at least 6 characters.";
        }

        if(!$errors)
        {
            $encodedPassword = $this->passwordEncoder->encodePassword($this->getEntity(), $password);
            $this->getEntity()->setPassword($encodedPassword);
        }

        $this->errors = $errors;

        return $this;
    }

}
