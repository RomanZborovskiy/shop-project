<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @api {get} /api/my/profile Отримати профіль користувача
     * @apiName GetProfile
     * @apiGroup Profile
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiDescription Повертає дані авторизованого користувача.
     *
     * @apiSuccess {Boolean} success Статус виконання
     * @apiSuccess {Object} user Дані користувача
     * @apiSuccess {Number} user.id ID користувача
     * @apiSuccess {String} user.name Ім’я користувача
     * @apiSuccess {String} user.email Email користувача
     * @apiSuccess {String} user.created_at Дата створення
     * @apiSuccess {String} user.updated_at Дата оновлення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *       "user": {
     *           "id": 11,
     *           "name": "SuperAdmin",
     *           "email": "superadmin@app.com",
     *           "phone": null,
     *           "status": null,
     *           "email_verified_at": null,
     *           "created_at": "2025-09-25T09:46:46.000000Z",
     *           "updated_at": "2025-09-25T09:46:46.000000Z"
     *       },
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
     * @api {post} /api/my/profile Оновити профіль користувача
     * @apiName UpdateProfile
     * @apiGroup Profile
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiDescription Оновлює дані профілю авторизованого користувача.
     *
     * @apiBody {String} name Ім’я користувача
     * @apiBody {String} email Email користувача
     * @apiBody {String} [password] Новий пароль (опціонально)
     * @apiBody {File} [avatar] Зображення профілю (опціонально, якщо `mediaManage` підтримує)
     *
     * @apiSuccess {Boolean} success Статус виконання
     * @apiSuccess {String} message Повідомлення про результат
     * @apiSuccess {Object} user Оновлені дані користувача
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *      "message": "Профіль оновлено",
     *       "user": {
     *           "id": 11,
     *           "name": "SuperAdmin",
     *           "email": "superadmin@app.com",
     *           "phone": null,
     *           "status": null,
     *           "email_verified_at": null,
     *           "created_at": "2025-09-25T09:46:46.000000Z",
     *           "updated_at": "2025-09-25T09:46:46.000000Z"
     *       },
     * }
     *
     * @apiError Unauthorized Користувач не авторизований
     * @apiErrorExample {json} Помилка 401:
     * HTTP/1.1 401 Unauthorized
     * {
     *   "message": "Unauthenticated."
     * }
     *
     * @apiError ValidationError Помилка валідації
     * @apiErrorExample {json} Помилка 422:
     * HTTP/1.1 422 Unprocessable Entity
     * {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "email": ["Поле email вже використовується."]
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
