<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name_de' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'description_de' => ['required', 'string', 'min:10'],
            'description_ar' => ['required', 'string', 'min:10'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'old_price' => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'condition' => ['required', 'in:new,used,refurbished'],
            'brand' => ['nullable', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'images.*' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048', // 2MB
                'dimensions:min_width=500,min_height=500'
            ],
            'specifications' => ['nullable', 'array'],
            'specifications.*.key' => ['required', 'string', 'max:100'],
            'specifications.*.value' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Bitte wählen Sie eine Kategorie aus.',
            'category_id.exists' => 'Die ausgewählte Kategorie existiert nicht.',
            'name_de.required' => 'Der deutsche Produktname ist erforderlich.',
            'name_ar.required' => 'Der arabische Produktname ist erforderlich.',
            'price.required' => 'Der Preis ist erforderlich.',
            'price.numeric' => 'Der Preis muss eine Zahl sein.',
            'price.min' => 'Der Preis muss mindestens 0 sein.',
            'old_price.gt' => 'Der alte Preis muss höher als der aktuelle Preis sein.',
            'images.*.image' => 'Die Datei muss ein Bild sein.',
            'images.*.mimes' => 'Nur JPEG, PNG, JPG und WebP Bilder sind erlaubt.',
            'images.*.max' => 'Die Bildgröße darf 2MB nicht überschreiten.',
            'images.*.dimensions' => 'Das Bild muss mindestens 500x500 Pixel groß sein.',
        ];
    }

    protected function prepareForValidation()
    {
        // XSS Protection - HTML Purification
        $this->merge([
            'name_de' => strip_tags($this->name_de),
            'name_ar' => strip_tags($this->name_ar),
            'description_de' => $this->sanitizeHtml($this->description_de),
            'description_ar' => $this->sanitizeHtml($this->description_ar),
        ]);
    }

    private function sanitizeHtml($html)
    {
        // Allow only safe HTML tags
        return strip_tags($html, '<p><br><strong><em><ul><ol><li>');
    }
}
