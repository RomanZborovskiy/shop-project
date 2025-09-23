<div class="m-3">
    <button class="btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#filters">
        Використати фільтр
    </button>
</div>
<div class="collapse" id="filters">
    <div class="card">
        <div class="card-body">
            {!! Lte3::formOpen([
                'action' => route('users.index'),
                'method' => 'GET'
            ]) !!}

            {!! Lte3::text('search', request('search'), [
                'label' => 'Ім’я або Email'
            ]) !!}

            {!! Lte3::select2('roles[]', request('roles', []), $roles->toArray(), [
                'label' => 'Ролі',
                'placeholder' => 'Оберіть ролі',
                'multiple' => true
            ]) !!}

            {!! Lte3::datepicker( null, request('registered_at') ?? null, [
                'label' => 'Дата реєстрації',
                'format' => 'd-m-Y',
            ]) !!}

            {!! Lte3::select2('sort_by', request('sort_by'), [
                '' => 'Сортувати...',
                'name' => 'Ім’я',
                'created_at' => 'Дата реєстрації'
            ], [
                'label' => 'Поле сортування',
            ]) !!}

            {!! Lte3::select2('direction', request('direction'), [
                ''      => 'Сортувати...',
                'asc' => 'За зростанням',
                'desc' => 'За спаданням',
            ], [
                'label' => 'Напрямок',
            ]) !!}

            {!! Lte3::btnSubmit('Фільтрувати') !!}
        {!! Lte3::formClose() !!}
        </div>
    </div>
</div>
