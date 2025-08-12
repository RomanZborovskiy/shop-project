        {!! Lte3::text('name', Auth::user()->name ?? null, [
            'label' => 'Ім’я',
            'type' => 'text',
        ]) !!}

        {!! Lte3::text('email', Auth::user()->email ?? null, [
            'label' => 'email',
            'type' => 'email',
        ]) !!}

        {!! Lte3::mediaImage('avatar', Auth::user()->avatar_url ?? null, [
            'label' => 'Аватарка',
            'help' => 'Оберіть файл зображення',
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
        
          