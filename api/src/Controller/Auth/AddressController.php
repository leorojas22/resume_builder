<?php
namespace App\Controller\Auth;

use App\Service\Entity\AddressService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\AddressRepository;
use App\Service\Entity\BaseEntityService;

/**
 * @IsGranted("ROLE_USER")
 */
class AddressController extends BaseAuthController
{
    /**
     * @Route("/address", name="api_address_create", methods={"POST"})
     */
    public function createAddress(Request $request, AddressService $addressService)
    {
        return $this->createEntity($request, $addressService);
    }




    /**
     * @Route("/address", name="api_address_list", methods={"GET"})
     */
    public function getAddress(AddressRepository $addressRepository)
    {
        $address = $addressRepository->findOneBy(['user' => $this->getUser()]);

        return $this->json([
            'address' => $address
        ], 200, [], [
            'groups' => ['api']
        ]);
    }

    /**
     * @Route("/address", name="api_address_update", methods={"PATCH"})
     */
    public function updateAddress(Request $request, AddressService $addressService, AddressRepository $addressRepository)
    {
        $address = $addressRepository->findOneBy(['user' => $this->getUser()]);

        if($address)
        {
            $addressService->setEntity($address);

            $patchedData = $request->request->all();
            $patchedData['user'] = $this->getUser();

            if($addressService->setProperties($patchedData)->save())
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
        else
        {
            return $this->json([
                'errors' => ['Address not found for user.']
            ], 404);
        }
    }
}
