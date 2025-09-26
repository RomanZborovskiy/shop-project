        {!! Lte3::text('name', $user->name ?? null, [
            'label' => 'Ім’я',
            'type' => 'text',
        ]) !!}

        {!! Lte3::text('email', $user->email ?? null, [
            'label' => 'email',
            'type' => 'email',
        ]) !!}

        {!! Lte3::number('phone', $user->phone ?? null, [
            'label' => 'Номер телефону',

        ]) !!}

        {!! Lte3::mediaImage('avatar', $user->avatar_url ?? null, [
            'label' => 'Аватарка',
            'help' => 'Оберіть файл зображення',
        ]) !!}

        {!! Lte3::select2('role',$userRole ?? null, $roles->toArray(),         
            [
                'label' => 'Роль',
                'placeholder' => 'Оберіть роль',
            ]
        ) !!}

        {!! Lte3::select2('status', $puser->status ?? null, App\Models\User::statusList(), [
            'label' => 'Статус',
            'placeholder' => 'Оберіть статус',
        ]) !!}

        {!! Lte3::text('password',  null, [
            'label' => 'Новий пароль',
            'type' => 'password',
        ]) !!}

        {!! Lte3::text('password_confirmation',  null, [
            'label' => 'Підтвердження пароля',
            'type' => 'password',
        ]) !!}

         {!! Lte3::btnSubmit('Зберегти') !!}   