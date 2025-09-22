        {!! Lte3::select2('brand_id', $product->brand_id ?? null, $brands->toArray(), [
            'label' => 'Бренд',
            'placeholder' => 'Оберіть бренд',
        ]) !!}

        {!! Lte3::select2('category_id', $product->category_id ?? null, $categories->toArray(), [
            'label' => 'Категорія',
            'placeholder' => 'Оберіть категорію ',
        ]) !!}
        
        {!! Lte3::text('name', $product->name ?? null, [
            'label' => 'Назва продукту',
            'type' => 'text',
        ]) !!}

         {!! Lte3::number('price', $product->price ?? null, [
            'label' => 'Ціна',
            'step' => 0.01,

        ]) !!}

        {!! Lte3::number('old_price', $product->old_price ?? '', [
            'label' => 'Стара ціна',
            'step' => 0.01,
        ]) !!}

        {!! Lte3::text('quantity', $product->quantity ?? null, [
            'label' => 'Кількість',
            'type' => 'number',
        ]) !!}

        {!! Lte3::text('sku', $product->sku ?? null, [
            'label' => 'артикул',
        ]) !!}

       
        {!! Lte3::select2('status', $product->status ?? null, App\Models\Product::statusesList(), [
            'label' => 'Статус',
            'placeholder' => 'Оберіть статус',
        ]) !!}

        {!! Lte3::textarea('description', $product->description ?? null, [
            'label' => 'Description',
            'rows' => 3,
        ]) !!}


        {!! Lte3::mediaImage('images', null, [
            'label' => 'Додаткові зображення',
            'multiple' => true,
            'help' => 'Можна вибрати кілька файлів'
        ]) !!}

         

    
    
 
        
          