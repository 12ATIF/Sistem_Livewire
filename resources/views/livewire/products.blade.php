<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    {{ $isEditMode ? 'Edit Produk' : 'Tambah Produk' }}
                </div>
                <div class="card-body">
                    <form wire:submit="{{ $isEditMode ? 'update' : 'store' }}">
                        
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" wire:model="name"> 
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" class="form-control" wire:model="price">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ $isEditMode ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>

                        @if($isEditMode)
                            <button type="button" wire:click="cancel" class="btn btn-secondary">Batal</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">List Produk</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr wire:key="{{ $product->id }}"> 
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>Rp {{ number_format($product->price) }}</td>
                                <td>
                                    <button wire:click="edit({{ $product->id }})" class="btn btn-warning btn-sm">Edit</button>
                                    
                                    <button 
                                        wire:click="delete({{ $product->id }})"
                                        wire:confirm="Yakin mau hapus produk ini?"
                                        class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>