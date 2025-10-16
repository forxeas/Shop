<div class="container">
    <h1 class="mb-4 text-dark-emphasis border-bottom pb-2">Редактирование продукта</h1>
    <div class="d-flex justify-content-between align-items-center">
        <livewire:admin.helper.select-role/>
        <livewire:admin.helper.search-field/>
    </div>

    <x-admin.table>
        <x-slot:head>
            <tr>
                <th>
                    <a href="" class="text-decoration-none text-dark" wire:click.prevent="changeOrderBy('products.id')">
                        <x-admin.sort-arrow
                            field="ID"
                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('products.name')">
                        <x-admin.sort-arrow
                            field="Название продукта"
                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('products.price')">
                        <x-admin.sort-arrow
                            field="Цена продукта"
                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('users.name')">
                        <x-admin.sort-arrow
                            field="Автор"
                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    <a href="" class="text-decoration-none text-dark"
                       wire:click.prevent="changeOrderBy('categories.name')">
                        <x-admin.sort-arrow
                            field="Название категории"
                            :name="$fieldName" :directory="$fieldDirectory" :list="$arrayFields"/>
                    </a>
                </th>
                <th>
                    Редактировать
                </th>
                <th>
                    Удалить
                </th>
            </tr>
        </x-slot>
        <x-slot:body>
            @foreach($items as $product)
                <tr>
                    <td> {{ $product->id }}</td>
                    <td>
                        <a href="{{ route('product', $product->slug) }}" class="nav-link">
                            {{ $product->name }}
                        </a>
                    </td>
                    <td> {{ $product->price }} </td>
                    <td> {{ $product->user->name }} </td>
                    <td> {{ $product->category->name }} </td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('admin.product.edit', $product->slug) }}"
                           wire:navigate>
                            Редактировать
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-danger" wire:click="delete({{ $product->id }})">Удалить</button>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.table>

    {{ $items->links() }}
</div>
