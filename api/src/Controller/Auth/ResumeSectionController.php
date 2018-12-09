<?php
namespace App\Controller\Auth;

use App\Repository\ResumeSectionRepository;
use App\Service\Entity\ResumeSectionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class ResumeSectionController extends BaseAuthController
{
    /**
     * @Route("/resume-section", name="api_resume_section_create", methods={"POST"})
     */
    public function createResumeSection(Request $request, ResumeSectionService $entityService)
    {
        return $this->createEntity($request, $entityService);
    }

    /**
     * @Route("/resume-section", name="api_resume_section_list", methods={"GET"})
     */
    public function getResumeSections(ResumeSectionRepository $entityRepository)
    {
        return $this->getEntities($entityRepository);
    }

    /**
     * @Route("/resume-section/{entityId}", name="api_resume_section_list_one", methods={"GET"})
     */
    public function getResumeSection(ResumeSectionRepository $entityRepository, $entityId)
    {
        return $this->getEntity($entityRepository, $entityId);
    }

    /**
     * @Route("/resume/{entityId}", name="api_resume_update", methods={"PATCH"})
     */
    public function updateResumeSection(Request $request, ResumeSectionService $entityService, ResumeSectionRepository $entityRepository, $entityId)
    {
        return $this->updateEntity($request, $entityService, $entityRepository, $entityId);
    }

    /**
     * @Route("/resume/{entityId}", name="api_resume_delete", methods={"DELETE"})
     */
    public function deleteResumeSection(ResumeSectionService $entityService, ResumeSectionRepository $entityRepository, $entityId)
    {
        return $this->deleteEntity($entityService, $entityRepository, $entityId);
    }
}
