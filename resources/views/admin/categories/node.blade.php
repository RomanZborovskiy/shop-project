<li>
    {{ $category->name }}

    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Редагувати</a>
    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline-block">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Видалити категорію?')">Видалити</button>
    </form>

    @if($category->children->count())
        <ul>
            @foreach($category->children as $child)
                @include('admin.categories.node', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>