<?php
namespace App\Controller\Auth;

use App\Repository\ResumeSectionItemRepository;
use App\Service\Entity\ResumeSectionItemService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class ResumeSectionItemController extends BaseAuthController
{
    /**
     * @Route("/resume-section-item", name="api_resume_section_item_create", methods={"POST"})
     */
    public function createResumeSectionItem(Request $request, ResumeSectionItemService $entityService)
    {
        return $this->createEntity($request, $entityService);
    }

    /**
     * @Route("/resume-section-item", name="api_resume_section_item_list", methods={"GET"})
     */
    public function getResumeSectionItems(ResumeSectionItemRepository $entityRepository)
    {
        return $this->getEntities($entityRepository);
    }

    /**
     * @Route("/resume-section-item/{entityId}", name="api_resume_section_item_list_one", methods={"GET"})
     */
    public function getResumeSectionItem(ResumeSectionItemRepository $entityRepository, $entityId)
    {
        return $this->getEntity($entityRepository, $entityId);
    }

    /**
     * @Route("/resume/{entityId}", name="api_resume_update", methods={"PATCH"})
     */
    public function updateResumeSectionItem(Request $request, ResumeSectionItemService $entityService, ResumeSectionItemRepository $entityRepository, $entityId)
    {
        return $this->updateEntity($request, $entityService, $entityRepository, $entityId);
    }

    /**
     * @Route("/resume/{entityId}", name="api_resume_delete", methods={"DELETE"})
     */
    public function deleteResumeSectionItem(ResumeSectionItemService $entityService, ResumeSectionItemRepository $entityRepository, $entityId)
    {
        return $this->deleteEntity($entityService, $entityRepository, $entityId);
    }
}
