<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Verification;
use App\Mail\Welcome;
use App\Models\User;
use Auth;
use Hash;
use Http;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Symfony\Component\HttpFoundation\IpUtils;
use URL;
use Validator;

class AuthController extends Controller
{
    //regex: ^(.{0,7}|[^0-9]*|[^A-Z]*|[^a-z]*|[a-zA-Z0-9]*)$

    public function register(Request $request)
    {
        //validar la solicitud
        $validate = Validator::make($request->all(),
        [
            'username'=>'required',
            'email'=>'required|email|unique',
            'password' => [
                'required',
                'string',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'g-recaptcha-response' => 'required'
        ],
    [
            'username.required' => 'El nombre de usuario es requerido',
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'Ingrese un correo electrónico válido',
            'password.required' => 'La contraseña es requerida',
            'password.min'=>'La contraseña debe ser de al menos 8 caracteres',
            'g-recaptcha-response.required' => 'Por favor, compruebe que no es un robot'
    ]
    );

    $recaptchaResponse = $request->input('g-recaptcha-response');

    $body = [
        'secret'=>config('services.recaptcha.secret'),
        'response'=>$recaptchaResponse,
        'remoteip'=>IpUtils::anonymize($request->ip())
    ];

    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', $body);

    $result = json_decode($response);

    if($response->successful() && $result->success == true)
    {
       
    }
    else
    {
        return Redirect::back()->withErrors(['recaptcha'=>'ReCaptcha no válido, intente de nuevo'])->withInput();
    }

    if($validate->fails())
    {
    return Redirect::back()->withErrors($validate);
    }

    $user=User::create([
        'username'=>$request->username,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
    ]);

    $signed = URL::signedRoute(
        'activate',
        ['user'=>$user->id]
    );
    Mail::to($user->email)->send(new Welcome($signed));
    return redirect()->route('confirm');
    }

    public function activate(Request $request)
    {
        //Verificar que el link sea válido
        if(!$request->hasValidSignature())
        {
          return view('mails.invalid');
        }

        $user = User::find($request->user);
        if (!$user) {
            return view('notfound');
        }

        $user->update(['is_active' => true]);
        return view('emails.active');
    }

    public function login(Request $request)
    {
        $validate= Validator::make($request->all(),
        [
             'email' => 'required|email',
             'password' => 'required',
             'g-recaptcha-response' => 'required'
        ]
        );
 
        //validar recaptcha
        $recaptchaResponse = $request->input('g-recaptcha-response');

        $body = [
            'secret'=>config('services.recaptcha.secret'),
            'response'=>$recaptchaResponse,
            'remoteip'=>IpUtils::anonymize($request->ip())
        ];
    
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', $body);
    
        $result = json_decode($response);
    
        if($response->successful() && $result->success == true)
        {
           
        }
        else
        {
            return Redirect::back()->withErrors(['recaptcha'=>'ReCaptcha no válido, intente de nuevo'])->withInput();
        }
    
        //validar credenciales
        if($validate->fails()){
            return Redirect::back()->withErrors($validate);
        }

        //Identificar al usuario
         $user=User::where('email', $request->email)->first();
        
         //Verificar que sea una cuenta activa
         if(!$user->is_active)
         {
            return Redirect::back()->withErrors('Debe activar su cuenta antes de iniciar sesión');
         }

         //Generar código de verificación
         $code = mt_rand(1111,9999);
         $hashedcode= Hash::make($code);
        
         $user->verified_code = $hashedcode;
         $user->save();

         Mail::to($user->email)->send(new Verification());

         return view('verifycode');
    }

    public function verify(Request $request)
    {
        $validate = Validator::make($request->all(),
        [
            'email' => 'required|email',
            'password' => 'required',
            'code'=>'required|numeric'
        ],
        ['code.required' => 'Es necesario ingresar el código que se le ha enviado']
        );

        $email = $request->email;
        $code = $request->code;
        $credentials = request(['email', 'password']);

        if($validate->fails())
        {
            return;
        }
        else
        {
            if (! $token = Auth::guard('api')->attempt($credentials)) {
                return Redirect::back()->withErrors('Por favor, ingrese las credenciales correctas');
            }
    
            $user = User::where('email', $email)->first();
            if (!$user) {
                return Redirect::back()->withErrors('Usuario no encontrado..');
            }
           
            $verified_code= $user->verified_code;
            if(Hash::make($code, $verified_code))
            {
                $user->update(['is_verified'=>true]);
                return;
            }
            else{
                return;
            }
        }

    }

    public function logout()
    {
        
    }
}
