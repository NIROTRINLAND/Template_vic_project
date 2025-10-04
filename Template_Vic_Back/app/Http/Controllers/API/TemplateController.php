<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Template;
use App\Models\TemplateRating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class TemplateController extends Controller
{
    public function create(Request $request)
    {
        $file = $request->file('file');


        // dd($request);
        try {
            $file = $request->file('file'); // 'file' = le name de l'input
            echo $file->getClientMimeType();
            echo json_encode($file->getClientMimeType());

            $user = Auth::user();

            // 1️⃣ Validation
            $request->validate([
                'file' => 'required|mimes:zip|max:20480', // 20 Mo max
                'price' => 'nullable|string|min:0',
                'description' => 'string',
            ]);

            $is_paid = false;
            $price = $request->price ?? 0;

            // 2️⃣ Nom du ZIP sans extension
            $originalName = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

            // 3️⃣ Chemin de destination
            $extractPath = storage_path('app/public/templates/' . $originalName);
            if (!is_dir($extractPath)) mkdir($extractPath, 0755, true);

            // 4️⃣ Décompression du ZIP
            $zip = new ZipArchive;
            if ($zip->open($request->file('file')->getRealPath()) === TRUE) {
                $firstEntry = $zip->getNameIndex(0);
                $rootFolder = rtrim(explode('/', $firstEntry)[0], '/');

                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entry = $zip->getNameIndex($i);
                    if ($entry === $rootFolder . '/') continue;

                    $relativePath = preg_replace('#^' . preg_quote($rootFolder . '/', '#') . '#', '', $entry);
                    $destination = $extractPath . '/' . $relativePath;

                    if (substr($entry, -1) === '/') {
                        if (!is_dir($destination)) mkdir($destination, 0755, true);
                    } else {
                        copy('zip://' . $request->file('file')->getRealPath() . '#' . $entry, $destination);
                    }
                }
                $zip->close();
            } else {
                return response()->json(['error' => 'Impossible d’ouvrir le fichier ZIP'], 500);
            }

            // 5️⃣ Vérifier si le template est payant
            if ($price > 0) $is_paid = true;

            // 6️⃣ Chercher le screenshot dans le dossier screenshort
            $screenshot = null;
            $screenshotFolder = $extractPath . '/screenshort';





            if (is_dir($screenshotFolder)) {
                foreach (['png', 'jpg', 'jpeg'] as $ext) {
                    $files = glob($screenshotFolder . '/*.' . $ext);
                    if (count($files) > 0) {
                        $first = basename($files[0]);
                        $screenshot = 'templates/' . $originalName . '/screenshort/' . $first;
                        break;
                    }
                }
            }

            // 7️⃣ Générer le lien public vers index.html
            $previewLink = null;
            $indexFile = $extractPath . '/index.html';
            if (file_exists($indexFile)) {
                $previewLink = asset('storage/templates/' . $originalName . '/index.html');
            }

            // 8️⃣ Enregistrer en base
            $template = \App\Models\Template::create([
                'creator_id' => $user->id,
                'name' => $originalName,
                'folder' => $originalName,
                'is_paid' => $is_paid,
                'price' => preg_replace('/[^0-9]/', '', $price),
                'screenshot' => $screenshot,
                'preview_link' => $previewLink, // 🔥 ajout du lien index.html
                'description' => $request->description
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Template importé et décompressé avec succès',
                'folder' => $originalName,
                'template_id' => $template->id,
                'screenshot' => $screenshot ? asset('storage/' . $screenshot) : null,
                'preview_link' => $previewLink,

            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function indexFreeTemplate()
    {
        $FreeTemplate = Template::where('is_paid', 0)
            ->where('is_public', 1)
            ->get();

        return response()->json([
            'FreeTemplate' => $FreeTemplate
        ]);
    }

    public function indexFreeTemplateAdmin()
    {
        $FreeTemplate = Template::where('is_paid', 0)

            ->get();

        return response()->json([
            'FreeTemplate' => $FreeTemplate
        ]);
    }
    public function indexPaidTemplateAdmin()
    {
        $FreeTemplate = Template::where('is_paid', 1)

            ->get();

        return response()->json([
            'FreeTemplate' => $FreeTemplate
        ]);
    }
    public function indexPaidTemplate()
    {
        $FreeTemplate = Template::where('is_paid', 1)
            ->where('is_public', 1)
            ->get();

        return response()->json([
            'FreeTemplate' => $FreeTemplate
        ]);
    }

    public function TemplateStat()
    {
        $Free = Template::where('is_paid', 0)->count();
        $Paid = Template::where('is_paid', 1)->count();
        $user = User::all()->count();
        return response()->json([
            'FreeTemplate' => $Free,
            'PaidTemplate' => $Paid,
            'user' => $user
        ]);
    }


    public function ModifyVisibility(Request $request)
    {
        $template = $request->template;
        $currTemplate = Template::where('id', $template['id'])->first();
        echo (json_encode($currTemplate));
        Log::info($currTemplate);
        if ($currTemplate->is_public == 1) {
            $currTemplate->is_public = 0;
            $currTemplate->save();
        } else {
            $currTemplate->is_public = 1;
            $currTemplate->save();
        }
        return response()->json([
            'FreeTemplate' =>  $currTemplate
        ]);
    }

    public function DownoaldTemplate(Request $request)
    {
        $currTemplate = Template::where('name', $request->template['name'])->first();
        $currTemplate->download = $currTemplate->download ?   $currTemplate->download + 1  : 1;
        $currTemplate->save();
        Log::info($request);
        $folderPath = storage_path("app/public/templates/{$request->template['name']}");

        $zipFileName = $request->template['name'] . '.zip';
        $zipFilePath = storage_path("app/{$zipFileName}");

        if (!file_exists($folderPath)) {
            return response()->json(['error' => "Le dossier {$request->template['name']} n'existe pas"], 404);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            Log::error("Impossible de créer le ZIP à $zipFilePath");
            return response()->json(['error' => 'Erreur ZIP'], 500);
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folderPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }



    public function Rating(Request $request)
    {

        $currTemplate = Template::where('name', $request->template['name'])->first();
        $rate = new TemplateRating();
        $rate->template_id =  $currTemplate->id;
        $rate->rating = $request->rating;
        $rate->save();
        $result = TemplateRating::where('template_id', $currTemplate->id)
            ->avg('rating');
        return response()->json([
            'Rating' =>  $rate,
            'moyenne' => $result
        ]);
    }

    public function ShowRating(Request $request)
    {

        $currTemplate = Template::where('name', $request->template['name'])->first();
        $result = TemplateRating::where('template_id', $currTemplate->id)
            ->avg('rating');
        return response()->json([
            'moyenne' => round($result, 2)
        ]);
    }

    public function ShowCreator(Request $request)
    {
        $template = $request->template;
        $currTemplate = Template::where('name', $template['name'])->first();
        $creator = User::where('id', $currTemplate->creator_id)->first();
        return response()->json([
            'creator' =>  $creator
        ]);
    }

    public function indexFreeTemplateAdminHome()
    {
        $FreeTemplate = Template::where('is_paid', 0)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'FreeTemplate' => $FreeTemplate
        ]);
    }

    public function indexFreeTemplateMosDownoald()
    {
        $FreeTemplate = Template::orderBy('download', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'FreeTemplate' => $FreeTemplate
        ]);
    }

    public function Stat()
    {


        $FreeTemplateByDay = Template::whereDate('created_at', Carbon::today())
            ->where('is_paid', 0)
            ->count();

        $PaidTemplateByDay = Template::whereDate('created_at', Carbon::today())
            ->where('is_paid', 1)
            ->count();

        $uniqueCreatorsToday = Template::whereDate('created_at', Carbon::today())
            ->distinct('creator_id')
            ->count('creator_id');

        $template_users_curr = DB::table('templates')
            ->join('users', 'users.id', '=', 'templates.creator_id')
            ->whereDate('templates.created_at', Carbon::today())
            ->select('users.*',  'users.name as creator_name', 'templates.*')
            ->get();

        return response()->json([

            'FreeTemplateByDay' => $FreeTemplateByDay,
            'PaidTemplateByDay' => $PaidTemplateByDay,
            'uniqueCreatorsToday' => $uniqueCreatorsToday,
            'template_users_curr' => $template_users_curr
        ]);
    }

    public function ContactCreator(Request $request){

Log::info($request->name);
 // Validation simple
 $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'message' => 'required|string',
]);

// Préparer les données pour le mail
$details = [
    'name' => $request->name,
    'email' => $request->email,
    'message' => $request->message,
];
 
// Envoyer le mail
Mail::to($request->email)->send(new ContactMail($details));

return back()->with('success', 'Email envoyé avec succès !');
    }
}
