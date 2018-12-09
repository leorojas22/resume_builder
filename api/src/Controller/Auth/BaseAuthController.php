<?php
namespace App\Controller\Auth;


use App\Service\Entity\BaseEntityService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityRepository;

abstract class BaseAuthController extends AbstractController
{
    protected function createEntity(Request $request, BaseEntityService $entityService)
    {
        $postData = $request->request->all();
        $postData['user'] = $this->getUser();

        if($entityService->create($postData)->save())
        {
            return $this->json([
                'data' => $entityService->getEntity()
            ], 200, [], [
                'groups' => ['api']
            ]);
        }
        else
        {
            return $this->json([
                'errors' => $entityService->getErrors()
            ], 400);
        }
    }


    protected function getEntities(EntityRepository $entityRepository)
    {
        $entities = $entityRepository->findBy(['user' => $this->getUser()]);

        return $this->json([
            'data' => $entities
        ], 200, [], [
            'groups' => ['api']
        ]);
    }

    protected function getEntity(EntityRepository $entityRepository, $entityId)
    {
        $entity = $entityRepository->findOneBy(['user' => $this->getUser(), 'id' => $entityId]);

        return $this->json([
            'data' => $entity
        ], 200, [], [
            'groups' => ['api']
        ]);
    }


    protected function updateEntity(Request $request, BaseEntityService $entityService, EntityRepository $entityRepository, $entityId)
    {
        $entity = $entityRepository->findOneBy(['user' => $this->getUser(), 'id' => $entityId]);

        if($entity)
        {
            $entityService->setEntity($entity);

            $patchedData = $request->request->all();
            $patchedData['user'] = $this->getUser();

            if($entityService->setProperties($patchedData)->save())
            {
                return $this->json([
                    'data' => $entityService->getEntity()
                ], 200, [], [
                    'groups' => ['api']
                ]);
            }
            else
            {
                return $this->json([
                    'errors' => $entityService->getErrors()
                ], 400);
            }
        }
        else
        {
            return $this->json([
                'errors' => ['Entity not found for user.']
            ], 404);
        }
    }

    protected function deleteEntity(BaseEntityService $entityService, EntityRepository $entityRepository, $entityId)
    {
        $entity = $entityRepository->findOneBy(['user' => $this->getUser(), 'id' => $entityId]);

        if($entity)
        {
            if($entityService->deleteEntity($entity))
            {
                return $this->json([
                    'result' => true
                ], 200);
            }
            else
            {
                return $this->json([
                    'errors' => $entityService->getErrors()
                ], 400);
            }
        }
        else
        {
            return $this->json([
                'errors' => ['Entity not found for user.']
            ], 404);
        }
    }



}

