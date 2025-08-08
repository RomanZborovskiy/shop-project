
        {!! Lte3::text('name', $category->name ?? null, [
            'label' => 'Заголовок посту',
            'type' => 'text',
        ]) !!}

        {!! Lte3::select2('type', $category->type ?? null, App\Models\Category::typesList(), [
            'label' => 'Вид',
            'placeholder' => 'Оберіть вид',
        ]) !!}

        
        
          