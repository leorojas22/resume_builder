<?php
namespace App\Service\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use App\Service\ValidationService;



abstract class BaseEntityService
{
    protected $entityClass;
    protected $om;
    protected $validator;
    protected $errors = [];
    protected $entity;

    public function __construct(ObjectManager $om, ValidationService $validator)
    {
        $this->om = $om;
        $this->validator = $validator;

        if(empty($this->entityClass))
        {
            throw new \Exception("Missing entity class.");
        }
    }

    public function create($properties = [])
    {
        $this->entity = new $this->entityClass();
        foreach($properties as $property => $value)
        {
            $setterMethod = "set".$property;
            if(method_exists($this->entity, $setterMethod))
            {
                $this->entity->$setterMethod($value);
            }
        }

        return $this;
    }

    public function save()
    {
        if(!empty($this->entity))
        {
            $isValid = !$this->errors && $this->validator->validate($this->entity);
            if($isValid)
            {
                // Save entity
                $this->om->persist($this->entity);
                $this->om->flush();

                // Reset the errors array after saving is successful
                $this->errors = [];

                return true;
            }
            else
            {
                $this->errors = array_merge($this->errors, $this->validator->getErrors());
            }
        }
        else
        {
            $this->errors[] = "The entity being saved was empty.";
        }

        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setEntity($entity)
    {
        if(is_a($entity, $this->entityClass))
        {
            throw new \Exception("Setting invalid entity.  Expecting entity to be of type: ".$this->entityClass);
        }

        $this->entity = $entity;
    }

    public function getEntity()
    {
        return $this->entity;
    }
}
