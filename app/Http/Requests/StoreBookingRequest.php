<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'slot' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
        ];
    }
    
    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'service_id.required' => 'ID услуги обязателен для заполнения',
            'service_id.exists' => 'Указанный ID услуги не существует',
            'date.required' => 'Дата обязательна для заполнения',
            'date.date' => 'Дата должна быть в формате даты',
            'slot.required' => 'Временной слот обязателен для заполнения',
            'name.required' => 'Имя обязательно для заполнения',
            'phone.required' => 'Телефон обязателен для заполнения',
        ];
    }
}