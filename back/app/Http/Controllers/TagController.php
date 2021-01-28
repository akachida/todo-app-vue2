<?php


namespace App\Http\Controllers;


use App\Helpers\ApiResponse;
use App\Helpers\ArrayToResponse;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use \Throwable;

class TagController extends Controller
{
    /**
     * Lista todas as tags
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse {
        $all = Tag::orderBy('created_at', 'DESC')->get()->toArray();
        $response = ArrayToResponse::prepare($all);
        return response()->json($response, Response::HTTP_ACCEPTED);
    }

    /**
     * Exibe os dados de uma tag em específica
     *
     * @param Request $request
     * @param Tag $tag
     *
     * @return JsonResponse
     */
    public function show(Request $request, Tag $tag): JsonResponse {
        if (!$tag) {
            return ApiResponse::error('Tag não encontrada', Response::HTTP_NOT_FOUND);
        }

        $response = ArrayToResponse::prepare($tag->toArray());

        return response()->json($response, Response::HTTP_ACCEPTED);
    }

    /**
     * Cria uma nova tag
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse {
        // @TODO: Params Validation
        try {
            $tag = new Tag();
            $tag->uuid = Uuid::uuid4();
            $tag->name = $request->name;
            $tag->color = $request->color;
            $tag->save();

            return ApiResponse::success('Tag cadastrada com sucesso');
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualiza uma tag específica
     *
     * @param Request $request
     * @param Tag $tag
     *
     * @return JsonResponse
     */
    public function update(Request $request, Tag $tag): JsonResponse {
        // @TODO: Params Validation
        if (!$tag) {
            return ApiResponse::error('Tag não encontrada', Response::HTTP_NOT_FOUND);
        }

        try {
            $tag->name = $request->name;
            $tag->color = $request->color;
            $tag->save();

            return ApiResponse::success('Tag atualizada com sucesso');
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deleta uma tag específica
     *
     * @param Tag $tag
     *
     * @return JsonResponse
     */
    public function destroy(Tag $tag): JsonResponse {
        try {
            $tag->delete();

            return ApiResponse::success('Tag removida com sucesso');
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
