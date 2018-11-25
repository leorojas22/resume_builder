<?php
namespace App\Controller\Auth;

use App\Service\Entity\AddressService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/address", name="api_address_create", methods={"POST"})
     */
    public function createAddress(Request $request, AddressService $addressService)
    {
        $postData = $request->request->all();
        $postData['user'] = $this->getUser();

        if($addressService->create($postData)->save())
        {
            return $this->json([
                'address' => $addressService->getEntity()
            ], 200, [], [
                'groups' => ['api']
            ]);
        }
        else
        {
            return $this->json([
                'errors' => $addressService->getErrors()
            ], 400);
        }
    }
}
