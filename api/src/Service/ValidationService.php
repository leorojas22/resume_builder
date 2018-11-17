<?php
namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;


class ValidationService
{
    private $validator;
    private $errors = [];

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($entity)
    {
        $this->errors = [];

        $entityErrors = $this->validator->validate($entity);
        if(count($entityErrors) == 0)
        {
            return true;
        }
        else
        {
            foreach($entityErrors as $error)
            {
                $this->errors[] = $error->getMessage();
            }
        }

        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
