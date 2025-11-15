<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Mail\VerifyMailer;
use App\Models\CartItem;
use App\Models\User;
use Auth;
use Cookie;
use Hash;
use Mail;
use Random\RandomException;
use RuntimeException;
use Session;

class VerifyMailService
{
    /**
     * @throws RandomException
     */
    public function mountMail(): array
    {
        $code = random_int(1000, 9999);
        session::put('verify_code', $code);

        $data = session::pull('registerData') ?? [];
        Mail::to($data['data']['email'])->queue(new VerifyMailer($code));
        return ['code' => $code, 'data' => $data];
    }

    public function verifyMail(array $data, string $uuid, string $userUuid): void
    {
        if($uuid !== $userUuid) {
            throw new RuntimeException('Invalid credentials');
        }

        $user = User::create(
            [
                'name' => $data['data']['name'],
                'email' => $data['data']['email'],
                'password' => Hash::make($data['data']['password'])
            ]
        );

        if(Cookie::has('cartGuestId')) {
            $cart_id = Cookie::get('cartGuestId');
            CartItem::query()
                ->where('guest_id', $cart_id)
                ->delete();
            Cookie::queue(Cookie::forget('cartGuestId'));
        }

        Auth::login($user, $data['remember']);
        session::flash('success', 'Вы успешно cоздали аккаунт!');
    }

    public function resend(array $data): int
    {
        $code = random_int(1000, 9999);
        Mail::to($data['data']['email'])->queue(new VerifyMailer($code));
        return $code;
    }
}