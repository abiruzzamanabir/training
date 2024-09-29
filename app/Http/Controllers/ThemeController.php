<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theme = Theme::findOrFail(1);
        return view('theme.index', [
            'theme' => $theme,
        ]);
    }
    public function time()
    {
        $theme = Theme::findOrFail(1);
        return view('theme.time', [
            'theme' => $theme,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $path = base_path('.env');
        $test = file_get_contents($path);

        if (file_exists($path)) {
            if ($request->live) {
                $test = str_replace(["SSLCZ_STORE_ID=bangl6362104f9019c", "SSLCZ_STORE_PASSWORD=bangl6362104f9019c@ssl", "SSLCZ_TESTMODE=true", "IS_LOCALHOST=true"], ["SSLCZ_STORE_ID=bbfdigitallive", "SSLCZ_STORE_PASSWORD=5EE47643EBEAC14830", "SSLCZ_TESTMODE=false", "IS_LOCALHOST=false"], $test);
            } else {
                $test = str_replace(["SSLCZ_STORE_ID=bbfdigitallive", "SSLCZ_STORE_PASSWORD=5EE47643EBEAC14830", "SSLCZ_TESTMODE=false", "IS_LOCALHOST=false"], ["SSLCZ_STORE_ID=bangl6362104f9019c", "SSLCZ_STORE_PASSWORD=bangl6362104f9019c@ssl", "SSLCZ_TESTMODE=true", "IS_LOCALHOST=true"], $test);
            }

            file_put_contents($path, $test);
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
        }

        $update_data = Theme::findOrFail(1);
        $previous_app_name = $update_data->name;

        $images = [
            'logo' => $request->old_logo,
            'background' => $request->old_background,
            'iconbg' => $request->old_iconbg,
            'favicon' => $request->old_favicon,
        ];

        foreach ($images as $key => $oldImage) {
            if ($request->hasFile($key)) {
                $img = $request->file($key);
                $newImageName = md5(time() . rand()) . '.' . $img->clientExtension();
                $inter = Image::make($img->getRealPath());
                $inter->save(public_path('assets/img/') . $newImageName);

                // Check if the old image is not a default image
                if ($update_data->$key !== 'default_' . $key . '.' . $img->clientExtension()) {
                    $oldImagePath = public_path('assets/img/') . $oldImage;
                    // Check if the file exists before unlinking
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    } else {
                        // Optionally log or handle the missing file scenario
                        Log::warning("File not found for deletion: {$oldImagePath}");
                    }
                }

                $images[$key] = $newImageName; // Update the image name to the new one
            }
        }

        // Assign the updated values back to variables
        $logo = $images['logo'];
        $background = $images['background'];
        $iconbg = $images['iconbg'];
        $favicon = $images['favicon'];


        $update_data->update([
            'title' => $request->title,
            'close' => $request->close,
            'footer' => $request->footer,
            'name' => $request->name,
            'url' => $request->url,
            'amount' => $request->amount,
            'logo' => $logo,
            'background' => $background,
            'favicon' => $favicon,
            'iconbg' => $iconbg,
        ]);
        // $path = base_path('.env');
        // $test = file_get_contents($path);

        if (file_exists($path)) {
            file_put_contents($path, str_replace("APP_NAME='" . $previous_app_name . "'", "APP_NAME='" . $request->name . "'", $test));
        }
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        return back()->with('success', 'Setting Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function authenticateTheme(Request $request)
    {
        $password = $request->input('password');
        $correctPassword = env('THEME_PASSWORD'); // Retrieve password from environment variable

        if ($this->isPasswordCorrect($password, $correctPassword)) {
            session(['authenticatedTheme' => true]);
            return back()->with('success', 'Authenticated successfully.');
        }

        return back()->with('danger', 'Incorrect password. Please try again.');
    }

    private function isPasswordCorrect($inputPassword, $correctPassword)
    {
        return hash_equals($inputPassword, $correctPassword);
    }

    public function authenticateDashboard(Request $request)
    {
        $password = $request->input('password');
        $correctPassword = env('DASHBOARD_PASSWORD'); // Retrieve password from environment variable

        // Check if the session is expired
        if ($request->session()->has('expires_at') && now()->greaterThan($request->session()->get('expires_at'))) {
            $request->session()->forget('authenticatedDashboard');
            return back()->with('danger', 'Session expired. Please authenticate again.');
        }

        if ($this->isPasswordCorrect($password, $correctPassword)) {
            // Store session value and set expiration time
            $request->session()->put('authenticatedDashboard', true);
            $request->session()->put('expires_at', now()->addHour());

            return back()->with('success', 'Authenticated successfully.');
        }

        return back()->with('danger', 'Incorrect password. Please try again.');
    }



    public function authenticateTime(Request $request)
    {
        $password = $request->input('password');
        $correctPassword = env('TIME_PASSWORD'); // Retrieve password from environment variable

        if ($this->isPasswordCorrect($password, $correctPassword)) {
            session(['authenticatedTime' => true]);
            return back()->with('success', 'Authenticated successfully.');
        }

        return back()->with('danger', 'Incorrect password. Please try again.');
    }


    public function logout(Request $request)
    {
        // Clear the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent session fixation
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.index')->with('success', 'Logout successful.');
    }
}
