<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Title('Manajemen Produk')] 
class Products extends Component
{
    // Properties dengan Validasi
    #[Validate('required|min:3', message: 'Nama produk minimal 3 karakter')]
    public $name = '';

    #[Validate('required|numeric|min:0', message: 'Harga harus berupa angka positif')] 
    public $price = '';

    public $productId = null;
    public $isEditMode = false;

    // Read Data
    public function render()
    {
        return view('livewire.products', [
            'products' => Product::latest()->get()
        ])->layout('layouts.app');
    }

    // Create Data
    public function store()
    {
        $validated = $this->validate();

        Product::create($validated);

        $this->resetForm();
        session()->flash('message', '✅ Produk berhasil ditambahkan!');
    }

    // Prepare Edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        $this->productId = $id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->isEditMode = true;
    }

    // Update Data
    public function update()
    {
        $validated = $this->validate();

        $product = Product::findOrFail($this->productId);
        $product->update($validated);

        $this->resetForm();
        session()->flash('message', '✅ Produk berhasil diupdate!');
    }

    // Cancel Button
    public function cancel()
    {
        $this->resetForm();
    }

    // Delete Data
    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', '✅ Produk berhasil dihapus!');
    }

    // Reset Form Helper
    private function resetForm()
    {
        $this->reset(['name', 'price', 'productId', 'isEditMode']);
        $this->resetValidation();
    }
}