<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $data['name'] = $this->argument('name');
        if (empty($data['name'])) {
            $data['name'] = $this->ask('What is the name?');
        }
        $data['email'] = $this->argument('email');
        if (empty($data['email'])) {
            $data['email'] = $this->ask('What is the email?');
        }
        $data['password'] = $this->argument('password');
        if (empty($data['password'])) {
            $data['password'] = $this->secret('What is the password?');
        }

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Rules\Password::defaults()],
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            foreach ($errors as $error) {
                $this->error($error);
            }
        } else {
            $data = $validator->validated();
            $data['password'] = Hash::make($data['password']);

            DB::beginTransaction();
            try {
                $user = User::create($data);
                event(new Registered($user));
                $this->info('The user was created successful!');
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error($e->getMessage());
            }
        }
        return 0;
    }
}
