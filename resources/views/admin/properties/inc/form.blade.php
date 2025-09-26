    {!! Lte3::text('value', $property->value ?? null, [
        'label' => 'Назва властивості',
        'type' => 'text',
    ]) !!}

    {!! Lte3::select2('attribute_id', $property->attribute_id ?? '', $attributes->pluck('name', 'id')->toArray(),[
        'label' => 'Назва атрибута',
        'placeholder' => 'Оберіть атрибут',
    ]) !!}


        
        
          