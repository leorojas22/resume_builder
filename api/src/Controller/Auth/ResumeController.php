<?php
namespace App\Controller\Auth;

use App\Repository\ResumeRepository;
use App\Service\Entity\ResumeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class ResumeController extends BaseAuthController
{
    /**
     * @Route("/resume", name="api_resume_create", methods={"POST"})
     */
    public function createResume(Request $request, ResumeService $entityService)
    {
        return $this->createEntity($request, $entityService);
    }

    /**
     * @Route("/resume", name="api_resume_list", methods={"GET"})
     */
    public function getResumes(ResumeRepository $entityRepository)
    {
        return $this->getEntities($entityRepository);
    }

    /**
     * @Route("/resume/{entityId}", name="api_resume_list_one", methods={"GET"})
     */
    public function getResume(ResumeRepository $entityRepository, $entityId)
    {
        return $this->getEntity($entityRepository, $entityId);
    }

    /**
     * @Route("/resume/{entityId}", name="api_resume_update", methods={"PATCH"})
     */
    public function updateResume(Request $request, ResumeService $entityService, ResumeRepository $entityRepository, $entityId)
    {
        return $this->updateEntity($request, $entityService, $entityRepository, $entityId);
    }

    /**
     * @Route("/resume/{entityId}", name="api_resume_delete", methods={"DELETE"})
     */
    public function deleteResume(ResumeService $entityService, ResumeRepository $entityRepository, $entityId)
    {
        return $this->deleteEntity($entityService, $entityRepository, $entityId);
    }
}
