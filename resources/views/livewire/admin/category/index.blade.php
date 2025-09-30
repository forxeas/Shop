<div class="container">
    <x-app.success />

        <h1 class="mb-4">Категории товаров</h1>

    <div class="d-flex justify-content-between align-items-center">
        <livewire:admin.helper.select-role />
        <livewire:admin.helper.search-field  />
    </div>

    <x-admin.table >
        <x-slot:head >
            <tr>
                <th>
                    <a href="" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('categories.id')">
                        <x-admin.sort-arrow field="ID"
                                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('categories.name')">
                        <x-admin.sort-arrow field="Название категории"
                                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('products_count')">
                        <x-admin.sort-arrow field="Кол-во товаров"
                                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    Редактировать
                </th>
                <th>
                    Удаление
                </th>
            </tr>
        </x-slot:head>

        <x-slot:body >
            @foreach($items as $category)
                <tr>
                    <td> {{ $category->id }}</td>
                    <td> {{ $category->name }}</td>
                    <td> {{ $category->products_count }}</td>
                    <td>
                        <a href="{{ route('admin.category.edit', $category->slug) }}" class="btn btn-warning">
                            Редактирование
                        </a> </td>
                    <td>
                        <button wire:click="delete({{ $category->id}})" class="btn btn-danger">
                            Удалить
                        </button>
                    </td>
                </tr>
            @endforeach
        </x-slot:body>
    </x-admin.table>

    {{ $items->links() }}
</div>
