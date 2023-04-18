<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    //陣列左邊是json出現的值 右邊則是資料庫的值
        return 
        [   //取得Book的id
            'id' => $this->getKey(), 
            //要顯示的是 UserModel,裡面的資料 必須要有belongTO  HasOne 之類的關係
            // make 相當於去 new 出來的意思 ,我new出 UserResoure 裏面參數
            //$this->whenLoaded('user'),$this 指的是Book
            // whenLoaded 裡面的參數相當於 Book 跟 User 裏面對應關係, 也就是 user() 這個method
            'creator' => UserResource::make($this->whenLoaded('user')),
            'name' => $this->name,
            'author' => $this->author,
        
        ];
    }
}
