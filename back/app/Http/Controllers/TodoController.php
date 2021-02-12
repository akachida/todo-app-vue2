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
use Illuminate\Support\Facades\Validator;
use \Throwable;

class TodoController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse {
        $all = Todo::orderBy('created_at', 'DESC');

        if ($request->date) {
            try {
                $date = new DateTime($request->date);
                $dateEnd = clone $date;
                $dateEnd->add(new \DateInterval('P1D'));

                $all->whereBetween('created_at', [
                    $date->format('Y-m-d H:i:s'),
                    $dateEnd->format('Y-m-d H:i:s'),
                ]);
            } catch (Throwable $e) {
                return ApiResponse::error($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $allToArray = [];

        foreach ($all->get() as $item) {
            $todo = $item->toArray();
            $todo['status'] = json_decode($item['status']);
            $todo['tags'] = $item->tags()->get(['uuid', 'name', 'color'])->toArray();

            array_push($allToArray, $todo);
        }

        $response = ArrayToResponse::prepare($allToArray);
        return response()->json($response, Response::HTTP_ACCEPTED);
    }

    /**
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'status' => 'required|array',
        ]);

        if ($validator->fails()) {
            $message = '';

            foreach ($validator->getMessageBag()->all() as $message) {
                $message .= $message."\n";
            }

            return ApiResponse::error($message, Response::HTTP_BAD_REQUEST);
        }

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

            if ($request->tags) {
                $todo->tags()->sync($request->tags);
            }

            $newTodo = $todo->toArray();
            $newTodo['status'] = json_decode($todo['status']);
            $newTodo['tags'] = $todo->tags()->get(['uuid', 'name', 'color'])->toArray();

            return ApiResponse::success(ArrayToResponse::prepare($newTodo));
        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param Todo $todo
     *
     * @return JsonResponse
     */
    public function update(Request $request, Todo $todo): JsonResponse {
        if (!$todo) {
            return ApiResponse::error('Tarefa não encontrada', Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'status' => 'required|array',
        ]);

        if ($validator->fails()) {
            $message = '';

            foreach ($validator->getMessageBag()->all() as $message) {
                $message .= $message."\n";
            }

            return ApiResponse::error($message, Response::HTTP_BAD_REQUEST);
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
