<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Notifications\CustomResetPassword;

class ForgotPasswordController extends Controller {
    /**
    * Display the form to request a password reset link.
    *
    * @return \Illuminate\View\View
    */

    public function showLinkRequestForm() {
        
        $pageInfo = [
            "meta_title" => "Şifremi Sıfırla",
            "meta_keywords" => "Emlak Sepette,Şifremi Sıfırla",
            "meta_description" => "Emlak Sepette Şifremi Sıfırla, hesabınızı güvende tutmak için kolay ve güvenli bir şekilde şifrenizi yenileyin. 
                Hemen başlayın ve güvenle devam edin!",
            "meta_author" => "Emlak Sepette",
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);
        return view( 'auth.passwords.email',compact('pageInfo') );
    }

    /**
    * Send a reset link to the given user.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    */

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
    
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
    
        if ($response == Password::RESET_LINK_SENT) {
            $user = $this->broker()->getUser($this->credentials($request));
            if ($user) {
                // Create a new instance of CustomResetPassword with the token
                $user->notify(new CustomResetPassword($this->broker()->createToken($user)));
            }
            return $this->sendResetLinkResponse($request, $response);
        }
    
        return $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $request->wantsJson()
                    ? new JsonResponse(['message' => trans($response)], 200)
                    : back()->with('status', trans($response));
    }
    
    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }
    
        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }

    /**
    * Get the broker to be used during password reset.
    *
    * @return \Illuminate\Contracts\Auth\PasswordBroker
    */

    public function broker() {
        return Password::broker();
    }
}
