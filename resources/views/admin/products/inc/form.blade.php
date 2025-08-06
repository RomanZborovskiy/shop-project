        {!! Lte3::select2('brand_id', null, $brands->toArray(), [
            'label' => 'Бренд',
            'placeholder' => 'Оберіть бренд',
        ]) !!}


        {!! Lte3::select2('category_id', null, $categories->toArray(), [
            'label' => 'Категорія',
            'placeholder' => 'Оберіть категорію',
        ]) !!}

        {!! Lte3::text('name', null, [
            'label' => 'Назва продукту',
            'type' => 'text',
        ]) !!}

         {!! Lte3::number('price', '', [
            'label' => 'Ціна',
            'step' => 0.01,

        ]) !!}

        {!! Lte3::number('old_price', '', [
            'label' => 'Стара ціна',
            'step' => 0.01,
        ]) !!}

        {!! Lte3::text('quantity', 'null', [
            'label' => 'Кількість',
            'type' => 'number',
        ]) !!}

        {!! Lte3::text('sku', '', [
            'label' => 'артикул',
        ]) !!}

       
        {!! Lte3::select2('status', null, App\Models\Product::statusesList(), [
            'label' => 'Статус',
            'placeholder' => 'Оберіть статус',
        ]) !!}

        {!! Lte3::textarea('description', '', [
            'label' => 'Description',
            'rows' => 3,
        ]) !!}
        
        
          