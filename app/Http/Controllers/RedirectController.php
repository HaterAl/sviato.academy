<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RedirectController extends Controller
{
    public function redirectToNewUrl($oldUrl)
    {
        // Get the redirect mappings from the configuration file
        $redirects = Config::get('redirects.redirects');

        // Check if the old URL is in the mappings
        if (isset($redirects[$oldUrl])) {
            $newUrl = $redirects[$oldUrl];

            // Redirect to the new URL
            return redirect($newUrl);
        }

        // Handle the case when the old URL is not found in the mappings
        return abort(404);
    }
	
	    public function createRedirect(Request $request)
    {
        $oldUrl = $request->input('old_url');
        $newUrl = $request->input('new_url');

        // Проверяем, чтобы old_url и new_url были переданы в запросе
        if ($oldUrl && $newUrl) {
            // Получаем текущий список редиректов из конфигурационного файла
            $redirects = config('redirects.redirects', []);

            // Добавляем новую пару old_url => new_url в список редиректов
            $redirects[$newUrl] = $oldUrl;

            // Записываем обновленный список редиректов в файл конфигурации
            $configPath = config_path('redirects.php');
            $content = '<?php return ' . var_export(['redirects' => $redirects], true) . ';';
            file_put_contents($configPath, $content);

            return "Redirect created: $newUrl => $oldUrl";
        } else {
            return "Invalid parameters. Both 'old_url' and 'new_url' must be provided.";
        }
    }
}