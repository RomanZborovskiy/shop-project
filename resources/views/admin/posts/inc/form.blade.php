         {!! Lte3::select2('category_id', $post->category_id ?? null, $categories->pluck('name', 'id')->toArray(), [
                'label' => 'Категорія',
            ]) !!}

        {!! Lte3::text('name', $post->name ?? null, [
            'label' => 'Заголовок посту',
            'type' => 'text',
        ]) !!}

        {!! Lte3::text('description', $post->description ?? null, [
            'label' => 'Опис',
            'type' => 'text',
        ]) !!}

         {!! Lte3::textarea('text', $post->price ?? null, [
            'label' => 'Текст',
            'rows' => 3,

        ]) !!}

        {!! Lte3::text('tags', $post->tags ?? null, [
            'label' => 'Теги',
            'type' => 'text',
        ]) !!}

        
        
          