<?php
namespace App\Service\Entity;

use App\Entity\ResumeSectionItem;
use App\Service\ValidationService;
use App\Repository\ResumeSectionRepository;
use Doctrine\Common\Persistence\ObjectManager;

class ResumeSectionItemService extends BaseEntityService
{
    protected $entityClass = ResumeSectionItem::class;

    protected $resumeSectionRepository;

    public function __construct(ObjectManager $om, ValidationService $validator, ResumeSectionRepository $resumeSectionRepository)
    {
        parent::__construct($om, $validator);

        $this->resumeSectionRepository = $resumeSectionRepository;
    }

    public function setProperties($properties = [])
    {
        if(isset($properties['resumeSection'], $properties['user']) && is_numeric($properties['resumeSection']))
        {
            $resumeSectionId = $properties['resumeSection'];
            $resumeSection = $this->resumeSectionRepository->findOneBy(['id' => $resumeSectionId]);
            if($resumeSection)
            {
                $resumeUser = $resumeSection->getResume()->getUser();
                if($resumeUser == $properties['user'])
                {
                    $properties['resumeSection'] = $resumeSection;
                }
                else
                {
                    unset($properties['resumeSection']);
                }
            }
            else
            {
                unset($properties['resumeSection']);
            }

        }

        return parent::setProperties($properties);
    }
}
