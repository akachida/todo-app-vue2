<?php


namespace App\Http\Controllers;


use App\Helpers\ApiResponse;
use App\Helpers\ArrayToResponse;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use \Throwable;

class TagController extends Controller
{
    /**
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'color' => 'required|max:7',
        ]);

        if ($validator->fails()) {
            $message = '';

            foreach ($validator->getMessageBag()->all() as $message) {
                $message .= $message."\n";
            }

            return ApiResponse::error($message, Response::HTTP_BAD_REQUEST);
        }

        try {
            $tag = new Tag();
            $tag->uuid = Uuid::uuid4();
            $tag->name = $request->name;
            $tag->color = $request->color;
            $tag->save();

            return ApiResponse::success(ArrayToResponse::prepare($tag->toArray()));
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param Tag $tag
     *
     * @return JsonResponse
     */
    public function update(Request $request, Tag $tag): JsonResponse {
        if (!$tag) {
            return ApiResponse::error('Tag não encontrada', Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'color' => 'required|max:7',
        ]);

        if ($validator->fails()) {
            $message = '';

            foreach ($validator->getMessageBag()->all() as $message) {
                $message .= $message."\n";
            }

            return ApiResponse::error($message, Response::HTTP_BAD_REQUEST);
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
