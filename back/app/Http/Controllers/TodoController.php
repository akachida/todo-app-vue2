<?php


namespace App\Http\Controllers;


use App\Helpers\ApiResponse;
use App\Helpers\ArrayToResponse;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use \DateTime;
use \Throwable;

class TodoController extends Controller
{
    /**
     * Lista todas as tarefas
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse {
        $all = Todo::orderBy('created_at', 'DESC');

        if ($request->date) {
            try {
                $date = new DateTime($request->date);
                $all->whereBetween('created_at', [
                    $date->format('Y-m-d').' 00:00:00',
                    $date->format('Y-m-d').' 23:59:59',
                ]);
            } catch (Throwable $e) {
                return ApiResponse::error($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $all = $all->get()->toArray();

        foreach ($all as $key => $item) {
            $all[$key]['status'] = json_decode($item['status']);
        }

        $response = ArrayToResponse::prepare($all);
        return response()->json($response, Response::HTTP_ACCEPTED);
    }

    /**
     * Exibe os dados de uma tarefa em específica
     *
     * @param Request $request
     * @param Todo $todo
     *
     * @return JsonResponse
     */
    public function show(Request $request, Todo $todo): JsonResponse {
        if (!$todo) {
            return ApiResponse::error('Tarefa não encontrada', Response::HTTP_NOT_FOUND);
        }

        $response = ArrayToResponse::prepare($todo->toArray());

        return response()->json($response, Response::HTTP_ACCEPTED);
    }

    /**
     * Cria uma nova tarefa
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse {
        // @TODO: Params Validation
        try {
            $todo = new Todo();
            $todo->uuid = Uuid::uuid4();
            $todo->title = $request->title;
            $todo->status = Json::encode($request->status);

            if ($request->description) {
                $todo->description = $request->description;
            }

            if ($request->createdAt) {
                try {
                    $todo->created_at = (new DateTime($request->createdAt))->format('Y-m-d H:i:s');
                } catch (Throwable $e) {
                    return ApiResponse::error($e->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }

            $todo->save();

            return ApiResponse::success('Tarefa cadastrada com sucesso');
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualiza uma tarefa específica
     *
     * @param Request $request
     * @param Todo $todo
     *
     * @return JsonResponse
     */
    public function update(Request $request, Todo $todo): JsonResponse {
        // @TODO: Params Validation
        if (!$todo) {
            return ApiResponse::error('Tarefa não encontrada', Response::HTTP_NOT_FOUND);
        }

        try {
            $todo->title = $request->title;

            if ($todo->description) {
                $todo->description = $request->description;
            }

            if ($todo->status) {
                $todo->status = Json::encode($request->status);
            }

            $todo->save();

            return ApiResponse::success('Tarefa atualizada com sucesso');
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deleta uma tarefa específica
     *
     * @param Todo $todo
     *
     * @return JsonResponse
     */
    public function destroy(Todo $todo): JsonResponse {
        try {
            $todo->delete();

            return ApiResponse::success('Tarefa removida com sucesso');
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
