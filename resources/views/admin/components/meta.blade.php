<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">SEO метатеги</h5>
    </div>
    <div class="card-body">

        {!! Lte3::text('seo[keywords]', $model->seo?->tags['title'] ?? null, [
            'label' => 'title',
            'type' => 'text',
        ]) !!}

        {!! Lte3::text('seo[title]', $model->seo?->tags['keywords'] ?? null, [
            'label' => 'title',
            'type' => 'text',
        ]) !!}

        {!! Lte3::textarea('seo[description]', $model->seo?->tags['description'] ?? null, [
            'label' => 'Текст',
            'rows' => 3,

        ]) !!}
    </div>
</div>