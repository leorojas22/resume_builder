<?php
namespace App\Controller\Auth;

use App\Repository\PhoneRepository;
use App\Service\Entity\PhoneService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class PhoneController extends BaseAuthController
{
    /**
     * @Route("/phone", name="api_phone_create", methods={"POST"})
     */
    public function createPhone(Request $request, PhoneService $phoneService)
    {
        return $this->createEntity($request, $phoneService);
    }

    /**
     * @Route("/phone", name="api_phone_list", methods={"GET"})
     */
    public function getPhones(PhoneRepository $phoneRepository)
    {
        return $this->getEntities($phoneRepository);
    }

    /**
     * @Route("/phone/{phoneId}", name="api_phone_list_one", methods={"GET"})
     */
    public function getPhone(PhoneRepository $phoneRepository, $phoneId)
    {
        return $this->getEntity($phoneRepository, $phoneId);
    }

    /**
     * @Route("/phone/{phoneId}", name="api_phone_update", methods={"PATCH"})
     */
    public function updatePhone(Request $request, PhoneService $phoneService, PhoneRepository $phoneRepository, $phoneId)
    {
        return $this->updateEntity($request, $phoneService, $phoneRepository, $phoneId);
    }

    /**
     * @Route("/phone/{phoneId}", name="api_phone_delete", methods={"DELETE"})
     */
    public function deletePhone(PhoneService $phoneService, PhoneRepository $phoneRepository, $phoneId)
    {
        return $this->deleteEntity($phoneService, $phoneRepository, $phoneId);
    }
}