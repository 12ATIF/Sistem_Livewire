<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Title; // Fitur v3 untuk set judul halaman
use Livewire\Attributes\Rule; // Fitur v3 untuk validasi

#[Title('Manajemen Produk')] 
class Products extends Component
{
    // 1. Definisikan Properties
    #[Rule('required|min:3')] 
    public $name = '';

    #[Rule('required|numeric')] 
    public $price = '';

    public $productId = null; // Untuk menyimpan ID saat Edit
    public $isEditMode = false; // Penanda mode Tambah atau Edit

    // 2. Read Data (Render)
    public function render()
    {
        return view('livewire.products', [
            'products' => Product::latest()->get()
        ]);
    }

    // 3. Create Data
    public function store()
    {
        $this->validate(); // Validasi sesuai Rule di atas

        Product::create([
            'name' => $this->name,
            'price' => $this->price,
        ]);

        $this->reset(); // Kosongkan form
        session()->flash('message', 'Produk berhasil ditambahkan!');
    }

    // 4. Persiapan Edit (Ambil data ke form)
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        $this->productId = $id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->isEditMode = true; // Ubah mode jadi Edit
    }

    // 5. Update Data
    public function update()
    {
        $this->validate();

        $product = Product::findOrFail($this->productId);
        $product->update([
            'name' => $this->name,
            'price' => $this->price,
        ]);

        $this->reset(); // Kembali ke mode awal & kosongkan form
        session()->flash('message', 'Produk berhasil diupdate!');
    }

    // 6. Tombol Batal
    public function cancel()
    {
        $this->reset();
    }

    // 7. Delete Data
    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Produk dihapus!');
    }
}