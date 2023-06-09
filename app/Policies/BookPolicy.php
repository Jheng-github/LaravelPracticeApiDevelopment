<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    //確認權限,觀看所有書籍
    //hasPermissionToViewAnyBook 來自 UserModel
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionToViewAnyBook();
    }

    /**
     * Determine whether the user can view the model.
     */
    //確認權限，也能觀看其他人書籍
    public function view(User $user, Book $book): bool
    {
        return $user->hasPermissionToViewBook();
        //如果只能觀看自己書籍要參考下面
        // return $user->id === $book->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //擁有權限可以創造一本書
        //在BookController 確認UserModel有沒有創造書本的權限
        //hasPermissionToCreateBook 針對管理者/一般使用者 回傳ture or false
        return $user->hasPermissionToCreateBook();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Book $book): bool
    {
        //只有自己本身可以修改自己的書本
        //或者管理員才可以擁有所有權限
        //透過getkey 方式取得User的id
        return $user->getkey() === $book->user_id || $user->isadmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Book $book): bool
    {
        //只有自己本身可以刪除自己的書本
        //或者管理員才可以擁有所有權限
        //透過getkey 方式取得User的id
        return $user->getkey() === $book->user_id || $user->isadmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Book $book): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Book $book): bool
    {
        //
    }
}
