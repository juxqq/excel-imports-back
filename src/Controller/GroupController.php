<?php

namespace App\Controller;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GroupController extends AbstractController
{
    #[Route('/api/groups', name: 'groups', methods: ['GET'])]
    public function getGroupList(GroupRepository $groupRepository): JsonResponse
    {
        return $this->json($groupRepository->findAll(), Response::HTTP_OK);
    }
    #[Route('/api/groups', name: 'importGroups', methods: ['POST'])]
    public function importGroups(Request $request, ValidatorInterface $validator,
                                 EntityManagerInterface $em)
    {
        $file = $request->files->get('file');
        $spreadsheet = IOFactory::load($file);
        $spreadsheet->getActiveSheet()->removeRow(1);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);// here, the read data is turned into an array
        $errors = $validator->validate($sheetData);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        foreach ($sheetData as $Row)
        {
            $group = new Group;
            $groupName = $Row['A'];
            $existingGroup = $em->getRepository(Group::class)->findOneBy(array('nomDuGroupe' => $groupName));
            if(!$existingGroup) {
                $group->setNomDuGroupe($Row['A']);
                $group->setOrigine($Row['B']);
                $group->setVille($Row['C']);
                $group->setAnneeDebut($Row['D']);
                $group->setAnneeSeparation($Row['E']);
                $group->setFondateurs($Row['F']);
                $group->setMembres($Row['G']);
                $group->setCourantMusical($Row['H']);
                $group->setPresentation($Row['I']);

                $em->persist($group);
                $em->flush();
            }
        }
        return $this->json('Groups created', Response::HTTP_CREATED);
    }

    #[Route('/api/groups/{id}', name: 'detailGroup', methods: ['GET'])]
    public function getDetailGroup(Group $group): JsonResponse
    {
        return $this->json($group, Response::HTTP_OK);
    }

   #[Route('/api/groups/{id}', name: 'updateGroup', methods: ['PUT'])]
    public function updateBook(Request $request, SerializerInterface $serializer,
                               Group $currentGroup, EntityManagerInterface $em,
                               ValidatorInterface $validator){
        $updatedGroup = $serializer->deserialize($request->getContent(),
            Group::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentGroup]);
        $errors = $validator->validate($currentGroup);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($updatedGroup);
        $em->flush();
        return $this->json('Groupe modifié.', Response::HTTP_NO_CONTENT);
    }
    #[Route('/api/groups/{id}', name: 'deleteGroup', methods: ['DELETE'])]
    public function deleteBook(Group $group, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($group);
        $em->flush();
        return $this->json('Groupe supprimé.', Response::HTTP_NO_CONTENT);
    }
}
