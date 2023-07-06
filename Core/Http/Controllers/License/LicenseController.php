<?php

namespace Core\Http\Controllers\License;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class LicenseController extends Controller
{

    public function activateLicense(Request $request)
    {
        $request->validate([
            'license' => 'required'
        ]);
        try {
            $response = Http::withOptions(['verify' => false])->post('https://laravel.licenselook.com/api/v1/verify-license-key', [
                'purchase_key' => $request['license'],
                'user_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'password' => auth()->user()->password,
                'domain' => $request->getSchemeAndHttpHost()
            ]);
            if ($response->failed()) {
                return redirect()->back()->withErrors(['message' => 'Request failed. Please try again']);
            }


            if ($response->serverError()) {
                return redirect()->back()->withErrors(['message' => 'Server error. Please try again']);
            }

            if ($response->clientError()) {
                return redirect()->back()->withErrors(['message' => 'Client error. Please try again']);
            }
			
			// dd(json_decode($response->body(), true));

            if ($response->ok()) {
                $response_body = json_decode($response->body(), true);

                if ($response_body['success'] && $response_body['activated'] == false) {
                    setEnv('LICENSE_CHECKED', "1");
                    return redirect()->route('core.admin.welcome');
                }

                if ($response_body['success'] && !$response_body['activated']) {
                    return redirect()->back()->withErrors(['message' => $response_body['message']]);
                }

                if (!$response_body['success'] && !$response_body['activated']) {
                    return redirect()->back()->withErrors(['message' => $response_body['message']]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Something went wrong. Please try again']);
        } catch (\Error $e) {
            return redirect()->back()->withErrors(['message' => 'Something went wrong. Please try again']);
        }
    }
}
