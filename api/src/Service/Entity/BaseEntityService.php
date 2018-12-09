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
        $this->setEntity(new $this->entityClass());
        return $this->setProperties($properties);
    }

    public function setProperties($properties = [])
    {
        if($this->getEntity())
        {
            foreach($properties as $property => $value)
            {
                if(strtolower($property) === "id")
                {
                    continue;
                }

                $setterMethod = "set".$property;
                if(method_exists($this->getEntity(), $setterMethod))
                {
                    $this->getEntity()->$setterMethod($value);
                }
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
        if(!is_a($entity, $this->entityClass))
        {
            throw new \Exception("Setting invalid entity.  Expecting entity to be of type: ".$this->entityClass);
        }

        $this->entity = $entity;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function deleteEntity($entity = false)
    {
        if($entity)
        {
            $this->setEntity($entity);
        }


        if($this->getEntity())
        {
            $this->om->remove($this->getEntity());
            $this->om->flush();
            return true;
        }
        else
        {
            $this->errors[] = "You must first set an entity before deleting it!";
        }

        return false;
    }
}
