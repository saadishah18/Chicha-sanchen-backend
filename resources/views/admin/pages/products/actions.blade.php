<a title="Edit product" href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-info btn-circle">
    <i class="fas fa-pencil-alt"></i>
</a>

<a title="{{ $product->is_featured == 1 ? 'Featured' : 'Featur' }} product" data-id="{{ $product->id }}" href="#"
   class="btn {{ $product->is_featured == 1 ? 'btn-info' : 'btn-primary' }} btn-circle toggle_approve">
    <i class="fas {{ $product->is_featured == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
</a>

<a title="{{ $product->is_active ? 'Deactive' : 'Active' }} product" data-id="{{ $product->id }}" href="#"
   class="btn {{ $product->is_active ? 'btn-success' : 'btn-danger' }} btn-circle toggle_approve">
    <i class="fas {{ $product->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
</a>

<a href="#" title="Delete Products" data-id="{{ $product->id }}"
   class="btn btn-danger btn-circle delete_product_from_list">
    <i class="fas fa-trash"></i>
</a>

<a href="{{route('admin.products.assign-add-on',[$product->id])}}" title="Assign add ons" data-id="{{ $product->id }}"
   class="btn btn-dark btn-circle assin add ons">
    <i class="fas fa-arrow-alt-circle-up"></i>
</a>

