<div class="container">
    <x-app.success />

    <div class="mb-4">
        <h1 class="mb-4 text-dark-emphasis border-bottom pb-2">Пользователи сайта</h1>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <livewire:admin.helper.select-role />
        <livewire:admin.helper.search-field />
    </div>

    <x-admin.table>
        <x-slot:head>
            <tr>
                <th>
                    <a href="#" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('users.id')">
                        <x-admin.sort-arrow field="ID"
                                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="#" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('users.name')">
                        <x-admin.sort-arrow field="Имя"
                                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="#" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('users.role')">
                        <x-admin.sort-arrow field="Роль"
                                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="#" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('products_count')">
                        <x-admin.sort-arrow field="Кол-во товаров у продавца"
                                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>Редактировать</th>
                <th>Удалить</th>
            </tr>
        </x-slot:head>

        <x-slot:body>
            @foreach($items as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->products_count }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('admin.user.edit', $user->slug) }}" wire:navigate>
                            Редактировать
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-danger" wire:click="delete({{ $user->id }})">Удалить</button>
                    </td>
                </tr>
            @endforeach
        </x-slot:body>
    </x-admin.table>

    {{ $items->links() }}
</div>
