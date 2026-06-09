<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Cv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser;

class CvController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | UPLOAD CV
    |--------------------------------------------------------------------------
    */

    public function upload(Request $request)
    {
        $request->validate([

            'cv' => 'required|mimes:pdf|max:5120',

        ]);

        /*
        |--------------------------------------------------------------------------
        | GET CANDIDATE
        |--------------------------------------------------------------------------
        */

        $candidate = Candidate::where(

            'user_id',

            Auth::id()

        )->firstOrFail();

        /*
            | GET FILE
        */

        $file = $request->file('cv');

        /*
        |--------------------------------------------------------------------------
        | KEEP ORIGINAL NAME
        |--------------------------------------------------------------------------
        */

        $fileName = time().'_'
            .$file->getClientOriginalName();
        /*
        |--------------------------------------------------------------------------
        | SAVE FILE
        |--------------------------------------------------------------------------
        */

        $path = $request->file('cv')
            ->storeAs('cvs', $fileName, 'public');

        /*
        |--------------------------------------------------------------------------
        | SAVE CV DB
        |--------------------------------------------------------------------------
        */

        $cv = Cv::create([

            'candidate_id' => $candidate->id,

            'file_path' => $path,

            'created_at' => now(),

        ]);

        /*
        |--------------------------------------------------------------------------
        | READ PDF
        |--------------------------------------------------------------------------
        */

        try {

            $parser = new Parser;

            $pdf = $parser->parseFile(

                storage_path(
                    'app/public/'.$path
                )
            );

            $text = $pdf->getText();

            /*
            |--------------------------------------------------------------------------
            | FIX UTF8
            |--------------------------------------------------------------------------
            */

            $text = mb_convert_encoding(

                $text,

                'UTF-8',

                'auto'
            );

            $text = iconv(

                'UTF-8',

                'UTF-8//IGNORE',

                $text
            );

            /*
            |--------------------------------------------------------------------------
            | LIMIT TEXT
            |--------------------------------------------------------------------------
            */

            $text = substr($text, 0, 12000);

        } catch (\Exception $e) {

            return back()->with(

                'error',

                'Không đọc được file PDF'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AI PROMPT
        |--------------------------------------------------------------------------
        */

        $prompt = "

            Bạn là AI đọc CV chuyên nghiệp.

            Hãy đọc CV sau và trả về JSON HỢP LỆ.

            QUAN TRỌNG:

            - Chỉ trả JSON
            - Không markdown
            - Không giải thích
            - Không dùng ```json
            - Nếu thiếu thông tin thì trả null
            - Không được bỏ field

            Format JSON:

            {
                \"full_name\": null,
                \"phone\": null,
                \"email\": null,
                \"birthday\": null,
                \"gender\": null,
                \"address\": null,
                \"desired_position\": null,
                \"level\": null,
                \"description\": null,
                \"skills\": [],
                \"experience\": [],
                \"education\": []
            }

            experience format:

            [
                {
                    \"company\": \"\",
                    \"position\": \"\",
                    \"time\": \"\",
                    \"description\": \"\"
                }
            ]

            education format:

            [
                {
                    \"school\": \"\",
                    \"major\": \"\",
                    \"time\": \"\"
                }
            ]

            CV:
            $text

            ";

        /*
        |--------------------------------------------------------------------------
        | CALL GROQ AI
        |--------------------------------------------------------------------------
        */

        try {

            $response = Http::timeout(120)
                ->withHeaders([

                    'Authorization' => 'Bearer '.
                        env('GROQ_API_KEY'),

                    'Content-Type' => 'application/json',

                ])
                ->post(

                    'https://api.groq.com/openai/v1/chat/completions',

                    [

                        'model' => 'llama-3.3-70b-versatile',

                        'messages' => [

                            [

                                'role' => 'user',

                                'content' => $prompt,

                            ],
                        ],

                        'temperature' => 0.2,
                    ]
                );

        } catch (\Exception $e) {

            return back()->with(

                'error',

                'AI đang bận, thử lại sau'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GET AI RESULT
        |--------------------------------------------------------------------------
        */

        $ai =

            $response->json()['choices'][0]['message']['content']

            ?? null;

        if (! $ai) {

            return back()->with(

                'error',

                'AI không đọc được CV'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CLEAN JSON
        |--------------------------------------------------------------------------
        */

        $ai = trim($ai);

        $ai = str_replace(

            '```json',

            '',

            $ai
        );

        $ai = str_replace(

            '```',

            '',

            $ai
        );

        /*
        |--------------------------------------------------------------------------
        | PARSE JSON
        |--------------------------------------------------------------------------
        */

        $data = json_decode($ai, true);

        if (! $data) {

            return back()->with(

                'error',

                'AI parse dữ liệu thất bại'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE CANDIDATE
        |--------------------------------------------------------------------------
        */

        /*
|--------------------------------------------------------------------------
| FORMAT BIRTHDAY
|--------------------------------------------------------------------------
*/

        $birthday = null;

        if (! empty($data['birthday'])) {

            try {

                $birthday = Carbon::parse(

                    $data['birthday']

                )->format('Y-m-d');

            } catch (\Exception $e) {

                $birthday = null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE CANDIDATE
        |--------------------------------------------------------------------------
        */

        $candidate->update([

            'full_name' => $data['full_name']
                ?? $candidate->full_name,

            'phone' => $data['phone']
                ?? $candidate->phone,

            'birthday' => $birthday
                ?? $candidate->birthday,

            'gender' => $data['gender']
                ?? $candidate->gender,

            'address' => $data['address']
                ?? $candidate->address,

            'desired_position' => $data['desired_position']
                ?? $candidate->desired_position,

            'level' => $data['level']
                ?? $candidate->level,

            'description' => $data['description']
                ?? $candidate->description,

            'skills' => is_array(
                $data['skills'] ?? null
            )

                ? implode(
                    ', ',
                    $data['skills']
                )

                : ($data['skills'] ?? null),

            'experience' => is_array(
                $data['experience'] ?? null
            )

                ? json_encode(
                    $data['experience'],
                    JSON_UNESCAPED_UNICODE
                )

                : ($data['experience'] ?? null),

            'education' => is_array(
                $data['education'] ?? null
            )

                ? json_encode(
                    $data['education'],
                    JSON_UNESCAPED_UNICODE
                )

                : ($data['education'] ?? null),
        ]);

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return back()->with(

            'success',

            'Upload CV và đọc AI thành công'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CV
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $cv = Cv::findOrFail($id);

        $candidate = Candidate::where(

            'user_id',

            Auth::id()

        )->first();

        /*
        |--------------------------------------------------------------------------
        | CHECK OWNER
        |--------------------------------------------------------------------------
        */

        if (
            $cv->candidate_id != $candidate->id
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE FILE
        |--------------------------------------------------------------------------
        */

        $file = storage_path(

            'app/public/'.
            $cv->file_path
        );

        if (file_exists($file)) {

            unlink($file);

        }

        /*
        |--------------------------------------------------------------------------
        | DELETE DB
        |--------------------------------------------------------------------------
        */

        $cv->delete();

        return back()->with(

            'success',

            'Đã xóa CV'
        );
    }
    /*
|--------------------------------------------------------------------------
| UPLOAD CV NORMAL
|--------------------------------------------------------------------------
*/

    public function uploadNormal(Request $request)
    {
        $request->validate([

            'cv' => 'required|mimes:pdf,doc,docx|max:5120',

        ]);

        /*
        |--------------------------------------------------------------------------
        | GET CANDIDATE
        |--------------------------------------------------------------------------
        */

        $candidate = Candidate::where(

            'user_id',

            Auth::id()

        )->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | GET FILE
        |--------------------------------------------------------------------------
        */

        $file = $request->file('cv');

        /*
        |--------------------------------------------------------------------------
        | KEEP ORIGINAL NAME
        |--------------------------------------------------------------------------
        */

        $fileName = time().'_'
            .$file->getClientOriginalName();

        /*
        |--------------------------------------------------------------------------
        | STORE FILE
        |--------------------------------------------------------------------------
        */

        $path = $file->storeAs(

            'cvs',

            $fileName,

            'public'
        );

        /*
        |--------------------------------------------------------------------------
        | SAVE DB
        |--------------------------------------------------------------------------
        */

        Cv::create([

            'candidate_id' => $candidate->id,

            'file_path' => $path,

            'created_at' => now(),

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return back()->with(

            'success',

            'Upload CV thành công'
        );
    }
    /*
|--------------------------------------------------------------------------
| RE-UPLOAD CV
|--------------------------------------------------------------------------
*/

    /*
    |--------------------------------------------------------------------------
    | RE-UPLOAD CV
    |--------------------------------------------------------------------------
    */

    public function reuploadApplicationCv(Request $request, $applicationId)
    {
        $request->validate([

            'cv' => 'required|mimes:pdf,doc,docx|max:5120',

        ]);

        /*
        |------------------------------------------------------------------
        | GET CANDIDATE
        |------------------------------------------------------------------
        */

        $candidate = Candidate::where(

            'user_id',

            Auth::id()

        )->firstOrFail();

        /*
        |------------------------------------------------------------------
        | GET APPLICATION
        |------------------------------------------------------------------
        */

        $application = Application::where(

            'id',

            $applicationId

        )->where(

            'candidate_id',

            $candidate->id

        )->firstOrFail();

        /*
        |------------------------------------------------------------------
        | UPLOAD FILE
        |------------------------------------------------------------------
        */

        $file = $request->file('cv');

        $fileName = time().'_'.$file->getClientOriginalName();

        $path = $file->storeAs(

            'cvs',

            $fileName,

            'public'
        );

        /*
        |------------------------------------------------------------------
        | CREATE CV
        |------------------------------------------------------------------
        */

        $cv = Cv::create([

            'candidate_id' => $candidate->id,

            'file_path' => $path,

            'created_at' => now(),

        ]);

        /*
        |------------------------------------------------------------------
        | UPDATE APPLICATION CV
        |------------------------------------------------------------------
        */

        $application->update([

            'cv_id' => $cv->id,

        ]);

        /*
        |------------------------------------------------------------------
        | SUCCESS
        |------------------------------------------------------------------
        */

        return back()->with(

            'success',

            'Upload lại CV thành công'
        );
    }
}
