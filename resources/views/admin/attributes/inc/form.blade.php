
        {!! Lte3::text('name', $post->name ?? null, [
            'label' => 'Назва атрибуту',
            'type' => 'text',
        ]) !!}

        {!! Lte3::select2('category_id', $product->category_id ?? null, $categories->pluck('name', 'id')->toArray(), [
                'label' => 'Категорія',
            ]) !!}


        
        
          