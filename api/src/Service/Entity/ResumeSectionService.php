<?php
namespace App\Service\Entity;

use App\Entity\ResumeSection;
use App\Service\ValidationService;
use App\Repository\ResumeRepository;
use Doctrine\Common\Persistence\ObjectManager;

class ResumeSectionService extends BaseEntityService
{
    protected $entityClass = ResumeSection::class;

    protected $resumeRepository;

    public function __construct(ObjectManager $om, ValidationService $validator, ResumeRepository $resumeRepository)
    {
        parent::__construct($om, $validator);

        $this->resumeRepository = $resumeRepository;
    }

    public function setProperties($properties = [])
    {
        if(isset($properties['resume'], $properties['user']) && is_numeric($properties['resume']))
        {
            $resumeId = $properties['resume'];
            $properties['resume'] = $this->resumeRepository->findOneBy(['user' => $properties['user'], 'id' => $resumeId]);
        }

        return parent::setProperties($properties);
    }
}
