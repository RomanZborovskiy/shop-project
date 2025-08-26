    {!! Lte3::text('subject', $leadMessage->subject ?? null, [
        'label' => 'Тема',
        'type' => 'text',
    ]) !!}

    {!! Lte3::textarea('body', $leadMessage->body ?? null, [
        'label' => 'Текст листа',
        'rows' => 3,
    ]) !!}

    {!! Lte3::datetimepicker('scheduled_at', $leadMessage->scheduled_at ?? now(), [
        'label' => 'Дата/час запуску (необовʼязково)',
        'format' => 'Y-m-d H:i:s',
        'help' => 'Дата на диний момент',
    ]) !!}

    {!! Lte3::btnSubmit('Зберегти') !!}
          