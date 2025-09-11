<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @api {get} /api/profile Отримати профіль користувача
     * @apiName GetProfile
     * @apiGroup Profile
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiSuccess {Boolean} success Статус запиту
     * @apiSuccess {Object} user Дані користувача
     * @apiSuccess {Number} user.id ID користувача
     * @apiSuccess {String} user.name Ім’я користувача
     * @apiSuccess {String} user.email Email
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "user": {
     *     "id": 1,
     *     "name": "Vei Tom",
     *     "email": "veitom@example.com"
     *   }
     * }
     *
     * @apiError Unauthorized Користувач не авторизований
     * @apiErrorExample {json} Помилка 401:
     * HTTP/1.1 401 Unauthorized
     * {
     *   "message": "Unauthenticated."
     * }
     */
    public function show()
    {
        return response()->json([
            'success' => true,
            'user' => Auth::user(),
        ]);
    }

    /**
     * @api {put} /api/profile Оновити профіль користувача
     * @apiName UpdateProfile
     * @apiGroup Profile
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiBody {String} name Ім’я користувача
     * @apiBody {String} email Email
     * @apiBody {String} [password] Новий пароль
     * @apiBody {File} [avatar] Аватар (опціонально, multipart/form-data)
     *
     * @apiSuccess {Boolean} success Статус запиту
     * @apiSuccess {String} message Повідомлення
     * @apiSuccess {Object} user Оновлені дані користувача
     * @apiSuccess {Number} user.id ID користувача
     * @apiSuccess {String} user.name Ім’я користувача
     * @apiSuccess {String} user.email Email
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Профіль оновлено",
     *   "user": {
     *     "id": 1,
     *     "name": "Іван Петренко",
     *     "email": "ivan@example.com"
     *   }
     * }
     *
     * @apiError Unauthorized Користувач не авторизований
     * @apiErrorExample {json} Помилка 401:
     * HTTP/1.1 401 Unauthorized
     * {
     *   "message": "Unauthenticated."
     * }
     *
     * @apiError ValidationError Невалідні дані
     * @apiErrorExample {json} Помилка 422:
     * HTTP/1.1 422 Unprocessable Entity
     * {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "email": ["Поле email вже зайняте."]
     *   }
     * }
     */
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        $user->mediaManage($request); 

        return response()->json([
            'success' => true,
            'message' => 'Профіль оновлено',
            'user' => $user,
        ]);
    }
}
