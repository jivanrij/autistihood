<?php

namespace App\Jobs;

use App\Http\Requests\UpdateProfileRequest;
use App\User;

class UpdateProfile
{
    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var array
     */
    private $attributes;

    public function __construct(User $user, array $attributes = [])
    {
        $this->user = $user;
        $this->attributes = array_only($attributes, ['name', 'email', 'username']);
    }

    public static function fromRequest(User $user, UpdateProfileRequest $request): self
    {
        return new static($user, [
            'name' => $request->name(),
            'email' => $request->email(),
            'username' => $request->username(),
        ]);
    }

    public function handle()
    {
        $this->user->update($this->attributes);
    }
}
