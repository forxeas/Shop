<div class="container">
    <x-app.success />
    <div class="mb-4">
        <h1> Пользователи сайта </h1>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <livewire:admin.helper.select-role />
        <livewire:admin.helper.search-field />
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                <a href="" class="text-decoration-none text-dark" wire:click.prevent="changeOrderBy('users.id')">
                    <x-admin.sort-arrow
                        field="ID"
                        :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                </a></th>
            <th>
                <a href="" class="text-decoration-none text-dark" wire:click.prevent="changeOrderBy('users.name')">
                    <x-admin.sort-arrow
                        field="Имя"
                        :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                </a></th>
            <th>
                <a href="" class="text-decoration-none text-dark" wire:click.prevent="changeOrderBy('users.role')">
                    <x-admin.sort-arrow
                        field="Роль"
                        :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                </a></th>
            <th>
                <a href="" class="text-decoration-none text-dark" wire:click.prevent="changeOrderBy('products_count')">
                    <x-admin.sort-arrow
                        field="Кол-во товаров у продавца"
                        :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                </a></th>
            <th>
                Редактировать
            </th>
            <th>
                Удалить
            </th>
        </tr>

        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td> {{ $user->name }} </td>
                <td> {{ $user->role }} </td>
                <td> {{ $user->products()->count() }} </td>
                <td>
                    <a class="btn btn-warning" href="{{ route('admin.user.edit', $user->slug) }}" wire:navigate>
                        Редактировать
                    </a>
                </td>
                <td>
                    <button class="btn btn-danger" wire:click="deleteUser({{ $user->id }})">Удалить</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
