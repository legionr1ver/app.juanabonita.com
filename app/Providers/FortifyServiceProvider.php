<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Variable;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(100)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('mail', $request->mail)->first();

            if( !$user )
                throw ValidationException::withMessages(['No existe un usuario con el email ingresado.']);

            if( $user->habilitada == 0 )
                throw ValidationException::withMessages(['El usuario no está habilitado.']);

            if( password_verify($user->id_web_usuarios.$request->password, $user->password) )
                return $user;

            $var = Variable::find('clave_maestra');
            if( $var && password_verify($request->password, $var->valor) )
                return $user;

            if( $user->cliente ){

                $regional = User::whereIsNull('id_cli_clientes')
                    ->where('region', $user->cliente->region)
                    ->where('division', $user->cliente->division)
                    ->first();

                if( $regional && password_verify($request->password, $regional->password_m) )
                    return $user;

                $divisional = User::whereIsNull('id_cli_clientes')
                    ->where('region', 0)
                    ->where('division', $user->cliente->division)
                    ->first();

                if( $divisional && password_verify($request->password, $divisional->password_m) )
                    return $user;
            }

            throw ValidationException::withMessages(['Contraseña incorrecta.']);
        });
    }
}
