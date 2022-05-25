<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    public function destroy(User $user, File $file)
    {
        return $user->id === $file->user_id;
    }
    public function createLink(User $user, File $file)
    {
        return $user->id === $file->user_id;
    }
}
