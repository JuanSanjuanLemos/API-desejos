<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CategoriaController extends AbstractController
{
    /**
     * @Route("/api/categoria", name="app_get_categoria", methods={"GET"})
     */
    public function getCategorias(CategoriaRepository $categoriaRepository, SerializerService $serializerService): JsonResponse
    {
        $categorias = $categoriaRepository->findAll();
    
        $data = $serializerService->normalize($categorias,null,['groups'=>['api_list']]);

        return $this->json($data, 200);
    }
    /**
     * @Route("/api/categoria/{id}", name="app_get_categoria_by_id", methods={"GET"})
     */
    public function getCategoriaById($id, CategoriaRepository $categoriaRepository, SerializerService $serializerService): JsonResponse
    {
        $categoria = $categoriaRepository->find($id);
        $data = $serializerService->normalize($categoria,null,['groups'=>['api_list']]);

        return $this->json($data, 200);
    }
    /**
     * @Route("/api/categoria", name="app_post_categoria", methods={"POST"})
     */
    public function postCategoria(Request $request, EntityManagerInterface $em, SerializerService $serializerService): JsonResponse
    {
        $data= $request->request->all();
        $categoria = new Categoria;
        $categoria->setDescricao($data['descricao']);
        $em->persist($categoria);
        $em->flush();
        $data = $serializerService->normalize($categoria,null,['groups'=>['api_list']]);
        return $this->json($data,201);
    }
    /**
     * @Route("/api/categoria/{id}", name="app_put_categoria", methods={"PUT","PATCH"})
     */
    public function putCategoria($id, Request $request,CategoriaRepository $categoriaRepository, EntityManagerInterface $em, SerializerService $serializerService): JsonResponse
    {
        $data= $request->request->all();
        $categoria =$categoriaRepository->find($id);
        $categoria->setDescricao($data['descricao']);
        $em->persist($categoria);
        $em->flush();
        $data = $serializerService->normalize($categoria,null,['groups'=>['api_list']]);
        return $this->json($data,200);
    }
    /**
     * @Route("/api/categoria/{id}", name="app_delete_categoria", methods={"DELETE"})
     */
    public function deleteCategoria($id, CategoriaRepository $categoriaRepository, EntityManagerInterface $em, SerializerService $serializerService): JsonResponse
    {
        $categoria =$categoriaRepository->find($id);
        $em->remove($categoria);
        $em->flush();
        return $this->json("",204);
    }
}
