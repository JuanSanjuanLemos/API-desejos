<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProdutoController extends AbstractController
{
    /**
     * @Route("/api/produto", name="app_get_produto", methods={"GET"})
     */
    public function getProduto(ProdutoRepository $produtoRepository, SerializerService $serializerService): JsonResponse
    {
        $produtos = $produtoRepository->findAll();
        $data = $serializerService->normalize($produtos,null,["groups"=>["api_list"]]);
        return $this->json($data,200);
    }
    /**
     * @Route("/api/produto/{id}", name="app_get_produto_by_id", methods={"GET"})
     */
    public function getProdutoById($id, ProdutoRepository $produtoRepository, SerializerService $serializerService): JsonResponse
    {
        $produto = $produtoRepository->find($id);
        try {
            if(is_null($produto)) throw new Exception("Produto não encontrado!", 404);
            $data = $serializerService->normalize($produto,null,["groups"=>["api_list"]]);
            return $this->json($data,200);

        } catch (Exception $e) {
            return $this->json($e->getMessage(),$e->getCode());
        }
    }
    /**
     * @Route("/api/produto", name="app_post_produto", methods={"POST"})
     */
    public function postProduto(Request $request,EntityManagerInterface $em, SerializerService $serializerService, CategoriaRepository $categoriaRepository): JsonResponse
    {
        $produto = new Produto();
        $dataRequest = $request->request->all();
        $produto->setNome($dataRequest['nome']);
        $produto->setValor($dataRequest['valor']);
        $produto->setLink($dataRequest['link']);
        $produto->setCategoria($categoriaRepository->find($dataRequest['categoria']));
        $em->persist($produto);
        $em->flush();
        $data = $serializerService->normalize($produto,null,["groups"=>["api_list"]]);
        return $this->json($data,201);
    }
    /**
     * @Route("/api/produto/{id}", name="app_put_produto", methods={"PUT"})
     */
    public function putProduto($id, Request $request,EntityManagerInterface $em, SerializerService $serializerService, ProdutoRepository $produtoRepository,CategoriaRepository $categoriaRepository): JsonResponse
    {
        try {

            $produto = $produtoRepository->find($id);
            if(is_null($produto)) throw new Exception("Produto não encontrado!", 404);

            $dataRequest = $request->request->all();
            $produto->setNome($dataRequest['nome']);
            $produto->setValor($dataRequest['valor']);
            $produto->setLink($dataRequest['link']);
            $produto->setCategoria($categoriaRepository->find($dataRequest['categoria']));

            $em->persist($produto);
            $em->flush();

            $data = $serializerService->normalize($produto,null,["groups"=>["api_list"]]);
            return $this->json($data,200);

        } catch (Exception $e) {
            return $this->json($e->getMessage(),$e->getCode());
        }
    }
    /**
     * @Route("/api/produto/{id}", name="app_delete_produto", methods={"DELETE"})
     */
    public function deleteProduto(
        $id,EntityManagerInterface $em, ProdutoRepository $produtoRepository): JsonResponse
    {
        try {
            $produto = $produtoRepository->find($id);
            if(is_null($produto)) throw new Exception("Produto não encontrado!", 404);
            
            $em->remove($produto);
            $em->flush();
            return $this->json("",204);
        } catch (Exception $e) {
            return $this->json($e->getMessage(),$e->getCode());
        }
    }

}
