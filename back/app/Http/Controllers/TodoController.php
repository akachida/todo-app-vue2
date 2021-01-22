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
use \Throwable;

class TodoController extends Controller
{
    /**
     * Lista todas as tarefas
     * @return JsonResponse
     */
    public function list(): JsonResponse {
        $all = Todo::orderBy('created_at', 'DESC')
                ->get()
                ->toArray();

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

        $response = ArrayToResponse::prepare($todo);

        return response()->json($todo->toArray(), Response::HTTP_ACCEPTED);
    }

    /**
     * Creia uma nova tarefa
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

            $todo->save();

            return ApiResponse::success('Tarefa cadastrada com sucesso');
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualia uma tarefa específica
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
