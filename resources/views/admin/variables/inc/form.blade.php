        {!! Lte3::text('key', $variable->key ?? null, [
            'label' => 'Ключ',
            'type' => 'text',
        ]) !!}

        {!! Lte3::text('value', $variable->value ?? null, [
            'label' => 'Значення',
            'type' => 'text',
        ]) !!}