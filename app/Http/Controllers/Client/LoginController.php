<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\City;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\SubscriptionPlan;
use App\Models\Town;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Models\UserPlan;
use App\Models\Chat;
use App\Models\RoleChanges;

class LoginController extends Controller {
    public function showLoginForm() {
        $cities = City::all()->toArray();

        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];
        
        usort($cities, function($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];
        
            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['title']), $priorityCities);
        
            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }
        
            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }
        
            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }
        
            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['title'], 0, 1), $turkishAlphabet);
        
                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }
        
                return $comparison;
            }
        });
        

        $towns = Town::all()->toArray();

        usort($towns, function($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];
        
            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['sehir_title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['sehir_title']), $priorityCities);
        
            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }
        
            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }
        
            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }
        
            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['sehir_title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['sehir_title'], 0, 1), $turkishAlphabet);
        
                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }
        
                return $comparison;
            }
        });
        
        
        $subscriptionPlans = SubscriptionPlan::all();

        $subscriptionPlans_bireysel = SubscriptionPlan::where( 'plan_type', 'Bireysel' )->get();
        $subscriptionPlans_emlakci = SubscriptionPlan::where( 'plan_type', 'Emlak Ofisi' )->get();
        $subscriptionPlans_banka = SubscriptionPlan::where( 'plan_type', 'Banka' )->get();
        $subscriptionPlans_insaat = SubscriptionPlan::where( 'plan_type', 'İnşaat Ofisi' )->get();
        
        $pageInfo = [
            "meta_title" => "Giriş Yap & Kayıt Ol",
            "meta_keywords" => "Giriş Yap",
            "meta_description" => "Emlak Sepetteye giriş yap",
            "meta_author" => "Emlak Sepette",
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);

        return view( 'client.auth.login', compact("pageInfo", 'cities', 'subscriptionPlans_bireysel', 'towns', 'subscriptionPlans', 'subscriptionPlans_emlakci', 'subscriptionPlans_banka', 'subscriptionPlans_insaat' ) );

    }

    public function login( Request $request ) {
        $credentials = $request->only( 'email', 'password' );
        $user = User::where( 'email', $request->email )->first();
        if ( $user ) {

            if ( $user->status == 0 ) {
                $this->sendVerificationEmail( $user );
                session()->flash( 'warning', 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.' );
                return redirect()->route( 'client.login' );
            } elseif ( $user->status == 5 ) {
                session()->flash( 'error', 'Bu kullanıcının hesabı geçici olarak askıya alınmıştır. Hesabınızın yeniden etkinleştirilmesi için lütfen yöneticinizle iletişime geçin.' );
                return redirect()->route( 'client.login' );
            }elseif ($user->is_blocked == 1) {
                session()->flash( 'error', 'Bu kullanıcının hesabı geçici olarak askıya alınmıştır. Hesabınızın yeniden etkinleştirilmesi için lütfen yöneticinizle iletişime geçin.' );
                    return redirect()->route('client.login');
                
            } elseif ( $user->status == 1 ) {
                if ( Auth::attempt( $credentials , $request->filled('remember')) ) {
                    $user = Auth::user();
                    $updateUser = User::where( 'id', Auth::user()->id )->first();
                    
                    if ( $user->type == 1 && !$user->last_login ) {
                        // Bireysel kullanıcı için ilk giriş hoş geldiniz mesajı
                        DocumentNotification::create( [
                            'user_id' => $user->id,
                            'text' => 'Sayın ' . $user->name . ', Emlak Sepette ailesine hoş geldiniz! İhtiyaçlarınıza uygun emlakları keşfetmek veya güvenli bir şekilde tatil rezervasyonu yapmak için sitemizi kullanabilirsiniz. İyi günler dileriz.',
                            'item_id' => $user->id,
                            'link' => route( 'index' ),
                            'owner_id' => $user->id,
                            'is_visible' => true,
                        ] );

                        // last_login alanını güncelle
                        $updateUser->update( [ 'last_login' => now() ] );
                    } elseif ( $user->type == 2 && !$user->last_login ) {
                        // Kurumsal kullanıcı için ilk giriş hoş geldiniz mesajı
                        DocumentNotification::create( [
                            'user_id' => $user->id,
                            'text' => 'Sayın ' . $user->name . ', Emlak Sepette ailesine hoş geldiniz! Kurumsal hesabınızla projeler veya emlaklarınızı satışa sunabilirsiniz. İhtiyaçlarınıza uygun işlemleri gerçekleştirmek için sitemizi kullanabilirsiniz. İyi çalışmalar dileriz.',
                            'item_id' => $user->id,
                            'link' => route( 'index' ),
                            'owner_id' => $user->id,
                            'is_visible' => true,
                        ] );

                        // last_login alanını güncelle
                        $updateUser->update( [ 'last_login' => now() ] );
                    } elseif ( $user->type != 3 && $user->type != 1 && $user->type != 2 &&  $user->type != 21 && !$user->last_login ) {
                        // Kurumsal alt kullanıcı için hoş geldiniz mesajı
                        DocumentNotification::create( [
                            'user_id' => $user->id,
                            'text' => 'Sayın ' . $user->name . ', Emlak Sepette ailesine hoş geldiniz! Kurumsal hesabınızın verdiği yetkilere göre işlemleri gerçekleştirebilirsiniz. İhtiyaçlarınıza uygun işlemleri gerçekleştirmek için sitemizi kullanabilirsiniz. İyi çalışmalar dileriz.',
                            'item_id' => $user->id,
                            'link' => route( 'index' ),
                            'owner_id' => $user->id,
                            'is_visible' => true,
                        ] );

                        // last_login alanını güncelle
                        $updateUser->update( [ 'last_login' => now() ] );
                    } elseif ( $user->type == 21 && !$user->last_login && $user->type != 1 && $user->type != 2 ) {
                        DocumentNotification::create( [
                            'user_id' => $user->id,
                            'text' => 'Merhaba ' . $user->name . '! Emlak Kulüp ailesine hoş geldiniz! Emlak Sepette projeleri ve konutları koleksiyonunuza ekleyip paylaşarak kazanç elde edebilirsiniz. Sadece sizinle paylaşılan linkler üzerinden yapılan alışverişlerden komisyon alacaksınız. İyi kazançlar dileriz!',
                            'item_id' => $user->id,
                            'link' => route( 'index' ),
                            'owner_id' => $user->id,
                            'is_visible' => true,
                        ] );

                    }
                    $cart = session( 'cart', [] );
                    if ( count( $cart ) != 0 ) {
                        session( [ 'cart' => $cart ] );
                    }

                    if ( $user->type == 3 ) {
                        return redirect()->intended( '/qR9zLp2xS6y/secured/admin' );
                    } elseif ( $user->type != '3' ) {
                        
                        // if ($request->has('backurl')) {
                        //     $backurl = $request->query('backurl');
                        //     $cart = $request->session()->get('cart');
                        //     dd($cart);
                        //     return redirect()->to($request->input('backurl'));
                        // }

                        return redirect()->intended( route( 'index' ) );
                    }

                } else {
                    session()->flash( 'warning', 'Giriş Başarısız. Lütfen bilgilerinizi kontrol ediniz.' );

                    return redirect()->route( 'client.login' );
                }

            }
        } else {
            session()->flash( 'warning', 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.' );

            return redirect()->route( 'client.login' );
        }

    }

    private function sendVerificationEmail( User $user ) {
        $emailTemplate = EmailTemplate::where( 'slug', 'account-confirmation' )->first();

        if ( !$emailTemplate ) {
            return response()->json( [
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203 );
        }

        $content = $emailTemplate->body;

        $variables = [
            'username' => $user->name,
            'companyName' => 'Emlak Sepette',
            'email' => $user->email,
            'token' => $user->email_verification_token,
            'verificationLink' => URL::to( "/verify-email/{$user->email_verification_token}" ),
        ];

        foreach ( $variables as $key => $value ) {
            $content = str_replace( '{{' . $key . '}}', $value, $content );
        }

        try {
            Mail::to( $user->email )->send( new CustomMail( $emailTemplate->subject, $content ) );
            // session()->flash( 'warning', 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.' );
            // return redirect()->route( 'client.login' );

        } catch ( \Exception $e ) {
            session()->flash( 'error', 'Hata' );
            return redirect()->route( 'client.login' );

        }
    }

    public function logout() {
        Auth::logout();
        session()->forget( 'cart' );

        return redirect( '/giris-yap' );
    }

    public function googleLogin() {
        $client = new Client();

        $googleClientId =env('GOOGLE_CLIENT_ID');
        $googleClientSecret =  env('GOOGLE_CLIENT_SECRET');
        $redirectUri =  env("GOOGLE_REDIRECT_URI");

        $authUrl = 'https://accounts.google.com/o/oauth2/auth';

        // Kullanıcının izin vermesi için Google'a yönlendirme
        $authParams = [
            'scope' => 'email profile', // İzin verilecek alanlar
            'response_type' => 'code',
            'client_id' => $googleClientId,
            'redirect_uri' => $redirectUri,
        ];

        $authUrl = $authUrl . '?' . http_build_query($authParams);

        header("Location: $authUrl");
        exit;

    }

    public function redirectGoogle(){
        try {
            // Eğer Google tarafından yönlendirildikten sonra URL'de 'code' parametresi varsa
        if ( isset( $_GET[ 'code' ] ) ) {
            $client = new Client();

            $tokenUrl = 'https://accounts.google.com/o/oauth2/token';

            // 'code' parametresini al
            $code = $_GET[ 'code' ];
            // Erişim belirteci için istek gönder
            $response = $client->post( $tokenUrl, [
                'form_params' => [
                    'code' => $code,
                    'client_id' => env('GOOGLE_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                    'redirect_uri' =>  env("GOOGLE_REDIRECT_URI"),
                    'grant_type' => 'authorization_code',
                ],
            ] );

            $tokenData = json_decode( $response->getBody(), true );

            // Erişim belirteci ve refresh belirtecini al
            $accessToken = $tokenData[ 'access_token' ];

            // Kullanıcı bilgilerini almak için Google API'sine istek yap
                $userInfoUrl = 'https://www.googleapis.com/oauth2/v1/userinfo';
                $userInfoResponse = $client->get($userInfoUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                ]);
        
                $userInfo = json_decode($userInfoResponse->getBody(), true);
                $user = User::where( 'email', $userInfo['email'] )->first();
                if ( $user ) {

                    if ( $user->status == 0 ) {
                        $this->sendVerificationEmail( $user );
                        session()->flash( 'warning', 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.' );
                        return redirect()->route( 'client.login' );
                    } elseif ( $user->status == 5 ) {
                        session()->flash( 'warning', 'Bu kullanıcının hesabı geçici olarak askıya alınmıştır. Hesabınızın yeniden etkinleştirilmesi için lütfen yöneticinizle iletişime geçin.' );
                        return redirect()->route( 'client.login' );
                    } elseif ( $user->status == 1 ) {
                        if ( Auth::login($user) ) {
                            $user = Auth::user();
                            if ( $user->type == 3 ) {
                                return redirect()->intended( '/qR9zLp2xS6y/secured/admin' );
                            } elseif ( $user->type != 1 && $user->type != '3' ) {
                                return redirect()->intended( route( 'index' ) );
                            } else {
                                $cart = session( 'cart', [] );
                                if ( count( $cart ) != 0 ) {
                                    session( [ 'cart' => $cart ] );
                                }
                                return redirect()->intended( '/hesabim' );
                            }
                        }else{
                            session()->flash( 'warning', 'Giriş Başarısız. Lütfen bilgilerinizi kontrol ediniz.' );
        
                            return redirect()->route( 'client.login' );
                        }
        
                    }
                } else {
                    User::create([
                        "email" => $userInfo['email'],
                        "name" => $userInfo['name'],
                        "password" => Hash::make("123"),
                        "type" => 1,
                        "status" => 1,
                    ]);

                    
                    $user = User::where( 'email', $userInfo['email'] )->first();

                    if($user){
                        if ( $user->status == 0 ) {
                            $this->sendVerificationEmail( $user );
                            session()->flash( 'warning', 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.' );
                            return redirect()->route( 'client.login' );
                        } elseif ( $user->status == 5 ) {
                            session()->flash( 'warning', 'Bu kullanıcının hesabı geçici olarak askıya alınmıştır. Hesabınızın yeniden etkinleştirilmesi için lütfen yöneticinizle iletişime geçin.' );
                            return redirect()->route( 'client.login' );
                        } elseif ( $user->status == 1 ) {
                            if ( Auth::login($user) ) {
                                $user = Auth::user();
                                if ( $user->type == 3 ) {
                                    return redirect()->intended( '/qR9zLp2xS6y/secured/admin' );
                                } elseif ( $user->type != 1 && $user->type != '3' ) {
                                    return redirect()->intended( route( 'index' ) );
                                } else {
                                    $cart = session( 'cart', [] );
                                    if ( count( $cart ) != 0 ) {
                                        session( [ 'cart' => $cart ] );
                                    }
                                    return redirect()->intended( '/hesabim' );
                                }
                            }else{
                                session()->flash( 'warning', 'Giriş Başarısız. Lütfen bilgilerinizi kontrol ediniz.' );
            
                                return redirect()->route( 'client.login' );
                            }
            
                        }
                    }
                }
            } else {
                // 'code' parametresi yoksa bir hata durumu olabilir
                echo "Google tarafından yönlendirilmediniz veya izin vermediniz.";
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $reasonPhrase = $response->getReasonPhrase();
                $body = $response->getBody();
        
                // Hata durumunda yapılabilecek işlemler burada
                echo "Hata Kodu: $statusCode\n";
                echo "Hata Açıklaması: $reasonPhrase\n";
                echo "Hata Detayları: $body\n";
            }
        } catch (\Exception $e) {
            // Diğer hata durumlarını ele almak için genel bir Exception sınıfı kullanabilirsiniz
            echo "Bir hata oluştu: " . $e->getMessage();
        }
    }   

    public function loginFacebook(){
        $baseUri = 'https://www.facebook.com/dialog/oauth';

        $params = [
            'client_id' => '373986014992613',
            'redirect_uri' => env('FACEBOOK_REDIRECT'),
            'response_type' => 'code',
            'scope' => 'email', // İzin verilecek alanlar
        ];

        $facebookLoginUrl = $baseUri . '?' . http_build_query( $params );

            return redirect( $facebookLoginUrl );
    }

    public function membershipType(){
        $towns = Town::all()->toArray();
        $cities = City::all();
        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];
        $user = User::where('id',Auth::id())->first();

        usort($towns, function($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];
        
            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['sehir_title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['sehir_title']), $priorityCities);
        
            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }
        
            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }
        
            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }
        
            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['sehir_title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['sehir_title'], 0, 1), $turkishAlphabet);
        
                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }
        
                return $comparison;
            }
        });
        return view('client.membership-type.index',compact('towns','turkishAlphabet','cities','user'));
    }//End

    public function institutionalRegister(Request $request){
        // print_r($request->all());die;
        
        // $rules = [
        //     'name1' => [
        //         function ($attribute, $value, $fail) use ($request) {
        //             if ($request->input('type') == 1 && empty($value)) {
        //                 $fail('İsim alanı zorunludur.');
        //             }
        //         },
        //     ],
        //     'name' => [
        //         function ($attribute, $value, $fail) use ($request) {
        //             if ($request->input('type') == 2 && empty($value)) {
        //                 $fail('İsim alanı zorunludur.');
        //             }
        //         },
        //     ],
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        //     'mobile_phone' =>  'required',
        //     'type' => 'required|in:1,2,21',
        //     'corporate-account-type' => 'required_if:type,2|in:Emlakçı,İnşaat,Banka,Turizm',
        //     'activity' => 'required_if:type,2',
        //     'check-a' => 'required_if:type,1',
        //     'check-d' => 'required_if:type,2',
        //     'check-b' => 'required',
        //     'check-c' => 'required',
        //     'county_id' => "required_if:type,2",
        //     'city_id' => "required_if:type,2",
        //     'neighborhood_id' => "required_if:type,2",
        //     'username' => "required_if:type,2",
        //     'taxOffice' => "required_if:type,2",
        //     "taxOfficeCity" => "required_if:type,2",
        //     'taxNumber' => "required_if:type,2",
        //     'idNumber' => "required_if:account_type,1",
        // ];

        $msgs = [
            // 'email.required' => 'E-posta adresi alanı zorunludur.',
            // 'mobile_phone.required' => 'Cep telefonu zorunludur.',
            // 'check-a.required_if' => "Hesap açmak için Bireysel Hesap Sözleşmesini kabul etmeniz gerekmektedir.",
            'check-d.required_if' => "Hesap açmak için Kurumsal Hesap Sözleşmesini kabul etmeniz gerekmektedir.",
            'check-b.required' => 'Hesap açmak için Kvkk metinini okuyup onaylamanız gerekmektedir.',
            'check-c.required' => 'Hesap açmak için Gizlilik sözleşmesi ve aydınlatma metnini okuyup onaylamanız gerekmektedir.',
            // 'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            // 'email.unique' => 'Bu e-posta adresi başka bir kullanıcı tarafından kullanılıyor.',
            // 'password.required' => 'Şifre alanı zorunludur.',
            // 'password.min' => 'Şifre en az 6 karakter uzunluğunda olmalıdır.',
            'type.required' => 'Kullanıcı türü seçimi zorunludur.',
            'type.in' => 'Geçerli bir kullanıcı türü seçiniz.',
            'corporate-account-type.required_if' => 'Kurumsal hesap türü seçimi zorunludur.',
            'corporate-account-type.in' => 'Geçerli bir kurumsal hesap türü seçiniz.',
            'activity.required_if' => 'Kurumsal hesap aktivitesi seçimi zorunludur.',
            'county_id.required_if' => 'İlçe seçimi zorunludur.',
            'city_id.required_if' => 'Şehir seçimi zorunludur.',
            'neighborhood_id.required_if' => 'Mahalle seçimi zorunludur.',
            'username.required_if' => 'Kullanıcı adı zorunludur.',
            'taxOffice.required_if' => 'Vergi dairesi adı zorunludur.',
            'taxOfficeCity.required_if' => 'Vergi dairesi ili zorunludur.',
            'taxNumber.required_if' => 'Vergi numarası zorunludur.',
            'idNumber.required_if' => 'T.C. kimlik numarası zorunludur.',
            'subscription_plan_id.nullable' => 'Abonelik planı seçimi yapılmışsa geçerli bir abonelik planı seçiniz.',
        ];

        $city = City::where("title", $request->taxOfficeCity)->first();

        if ($request->input("account_type") == "1") {
            $accountType = "Şahıs Şirketi";
        } else {
            $accountType = "Limited veya Anonim Şirketi";
        }

        $user = new RoleChanges();
        $user->user_id                         = User::where('id',Auth::id())->value('id');
        $user->email                           = User::where('id',Auth::id())->value('email');
        $user->mobile_phone                    = User::where('id',Auth::id())->value('mobile_phone');
        $user->name                            = $request->input("name");
        $user->city_id                         = $request->input("city_id");
        $user->county_id                       = $request->input("county_id");
        $user->neighborhood_id                 = $request->input("neighborhood_id");
        $user->phone                           = $request->input("phone") ? $request->input('phone') : "";
        $user->corporate_account_type          = $request->input('corporate-account-type');           
        $user->status                          = 0;

        $user->subscription_plan_id = $request->input("subscription_plan_id");

        $subscriptionPlan = SubscriptionPlan::where("id", $request->input("subscription_plan_id"))->first();

        $user->username                        = $request->input("username");
        $user->account_type                    = $accountType;
        $user->taxOfficeCity                   = $city->id ?? 0;
        $user->taxOffice                       = $request->input("taxOffice");
        $user->taxNumber                       = $request->input("taxNumber");
        $user->idNumber                        = $request->input("idNumber");
        $user->store_name                      = $request->input("store_name");
        $user->save();



        return redirect()->back();
        return redirect()->url('/institutional')->with('success','Başvurunuz başarıyla gönderildi');
    }//End

    // public function addDocument(){
    //     $user = User::where('id',Auth::id())->first();
    //     return view('client.add-document.index',compact('user'));
    // }//End

    // public function addDocumentPost(Request $request){

    //     $user = User::where('id',Auth::id())->first();

    //     $request->validate(
    //         [
    //             'vergi_levhasi' => 'nullable',
    //             'sicil_belgesi' => 'nullable',
    //             'kimlik_belgesi' => 'nullable',
    //             'insaat_belgesi' => 'nullable',
    //         ]
    //     );

    //     $array = [];

    //     if ($request->hasFile('vergi_levhasi')) {
    //         $image = $request->file('vergi_levhasi');
    //         $imageFileName = 'tax_document_' . time() . '.' . $image->getClientOriginalExtension();
    //         $image->storeAs('public/tax_documents', $imageFileName);
    //         $image->move(public_path('tax_documents'), $imageFileName);
    //         $array = array_merge($array, ['tax_document' => $imageFileName]);
    //     }

    //     if ($request->hasFile('sicil_belgesi')) {
    //         $image = $request->file('sicil_belgesi');
    //         $imageFileName = 'record_document_' . time() . '.' . $image->getClientOriginalExtension();
    //         $image->storeAs('public/record_documents', $imageFileName);
    //         $image->move(public_path('record_documents'), $imageFileName);
    //         $array = array_merge($array, ['record_document' => $imageFileName]);
    //     }

    //     if ($request->hasFile('kimlik_belgesi')) {
    //         $image = $request->file('kimlik_belgesi');
    //         $imageFileName = 'identity_document_' . time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('identity_documents'), $imageFileName);
    //         $array = array_merge($array, ['identity_document' => $imageFileName]);
    //     }

    //     if ($request->hasFile('insaat_belgesi')) {
    //         $image = $request->file('insaat_belgesi');
    //         $imageFileName = 'company_document_' . time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('company_documents'), $imageFileName);
    //         $array = array_merge($array, ['company_document' => $imageFileName]);
    //     }

    //     auth()->user()->update($array);

    //     $emailTemplate = EmailTemplate::where('slug', "send-files")->first();

    //     if (!$emailTemplate) {
    //         return response()->json([
    //             'message' => 'Email template not found.',
    //             'status' => 203,
    //             'success' => true,
    //         ], 203);
    //     }

    //     $content = $emailTemplate->body;
    //     $user = User::where("id", auth()->user()->parent_id ?? auth()->user()->id)->first();

    //     $variables = [
    //         'username' => $user->name,
    //         'companyName' => "Emlak Sepette",
    //         "email" => $user->email,
    //         "token" => $user->email_verification_token,
    //     ];

    //     foreach ($variables as $key => $value) {
    //         $content = str_replace("{{" . $key . "}}", $value, $content);
    //     }

    //     // Mail::to($user->email)->send(new CustomMail($emailTemplate->subject, $content));

    //     DocumentNotification::create([
    //         'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
    //         'text' => "Belgeleriniz Emlak Sepette Yönetimine İletildi",
    //         'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
    //         'link' => route('institutional.index'),
    //         'owner_id' => auth()->user()->parent_id ?? auth()->user()->id,
    //         'is_visible' => true,
    //     ]);

    //     $emailAdminTemplate = EmailTemplate::where('slug', "get-files")->first();

    //     if (!$emailAdminTemplate) {
    //         return response()->json([
    //             'message' => 'Email template not found.',
    //             'status' => 203,
    //             'success' => true,
    //         ], 203);
    //     }

    //     $contentAdmin = $emailAdminTemplate->body;

    //     $admins = User::where("type", "3")->get();

    //     foreach ($admins as $key => $admin) {
    //         DocumentNotification::create([
    //             'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
    //             'text' => 'Hesap onayı için yeni bir belge gönderildi. Kullanıcı: ' . auth()->user()->email,
    //             'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
    //             'link' => route('admin.user.show-corporate-account', ['user' => auth()->user()->parent_id ?? auth()->user()->id]),
    //             'owner_id' => 4,
    //             'is_visible' => true,
    //         ]);

    //         $adminVariables = [
    //             'username' => $user->name,
    //             'adminName' => $admin->name,
    //             'companyName' => "Emlak Sepette",
    //             "email" => $user->email,
    //             "token" => $user->email_verification_token,
    //         ];

    //         foreach ($adminVariables as $key => $value) {
    //             $contentAdmin = str_replace("{{" . $key . "}}", $value, $contentAdmin);
    //         }

    //         // Mail::to($admin->email)->send(new CustomMail($emailAdminTemplate->subject, $contentAdmin));
    //     }

    //     return redirect()->back()->with('success','Belgeler yüklendi.');
    // }//End

 }
