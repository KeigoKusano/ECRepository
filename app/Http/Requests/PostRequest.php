<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //public function authorize()
    //{
    //    return false;
    //}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product.product_name' => 'required|string|max:100',
            'product.product_description' => 'required|string|max:4000',
            'product.product_price' => 'required|max:100',
            'serch' => 'required',
            //'product.image1' => 'mimes:jpeg,png,jpg,gif,svg',
            //'product.image2' => 'mimes:jpeg,png,jpg,gif,svg',
            //'tag.tag' => 'required|string|max:20',
            //'user.name' => 'required|string|max:10',
            //'user.password' => 'required|string|max:10',
            //'user.email' => 'required|string|max:100',
            'review_user_product.body' => 'required|string',
            'review_user_product.review_amount' => 'required|string',
            'chat_message.message_text' => 'required|string',
        ];
    }
}
