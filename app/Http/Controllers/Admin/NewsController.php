<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Str;

class NewsController extends Controller
{
    public function index()
    {
        return view('page.admin.news.index');
    }

    public function getNews(Request $request)
    {
        if ($request->ajax()) {
            $data = News::query()->orderBy('id', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($row) {
                    if (strlen($row->description) >= 200) {
                        return \Str::limit(strip_tags($row->description), 200) . '"<i class="read-more" style="cursor:pointer" class="underline" data-id="' . $row->id . '"><u>baca selengkapnya</u></i>';
                    }
                    return strip_tags($row->description);
                })
                ->rawColumns(['description'])
                ->addColumn('image', function ($row) {
                    return '<img width="200" src="' . url($this->decryptAESCryptoJS($row->image, env('SECRET_KEY_INDOTEK_KEY'))) . '"/>';
                })
                ->rawColumns(['image'])
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<div class="form-check form-switch">
                                <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                            </div>';
                })
                ->rawColumns(['is_active'])
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-id="' . $row->id . '" class="edit-news btn btn-success btn-sm"><i class="fas fa-edit"></i></button>';
                    $actionBtn .= ' <button data-id="' . $row->id . '" class="delete-news btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function toggleStatus(Request $request)
    {
        $news = News::find($request->id);
        $news->is_active = !$news->is_active; // Toggle nilai is_active
        $news->save();

        return response()->json(['success' => 'Status updated successfully.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'link_url' => 'nullable',
            'image' => 'required|mimes:jpg,png,jpeg,svg',
            'description' => 'required'
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $ch = curl_init();
            $url = env('URL_API') . '/api/store-file/news';
            $file = new \CURLFile($image->getPathname(), $image->getClientMimeType(), $imageName);
            $postData = ['image' => $file];

            $headers = [
                'Authorization: ' . env('SECRET_KEY_API')
            ];

            Log::info(env('SECRET_KEY_API'));

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Tambahkan header di sini

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpcode == 200) {
                $response = json_decode($response, true);
                $imagePath = $response['image_path'];
            } else {
                return response()->json(['error' => 'Failed to upload image to API.'], 500);
            }
        }
        Log::info($request->all);
        $news = News::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'author' => $request->author,
                'link_url' => $request->link_url,
                'description' => $request->description,
                'image' =>  $this->encryptAESCryptoJS(env('URL_API') . '/' . $imagePath, env('SECRET_KEY_INDOTEK_KEY'))
            ]
        );
        return response()->json(['success' => 'News saved successfully.']);
    }
    public function edit($id)
    {
        $news = News::find($id);
        return response()->json($news);
    }
    public function destroy($id)
    {
        $news = News::find($id);
        if ($news->image) {
            $imagePath = public_path($news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $news->delete();
        return response()->json(['success' => 'News deleted successfully.']);
    }

    public function encryptAESCryptoJS($plainText, $passphrase)
    {
        try {
            $salt = $this->genRandomWithNonZero(8);
            list($key, $iv) = $this->deriveKeyAndIV($passphrase, $salt);

            $encrypted = openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
            $encryptedBytesWithSalt = "Salted__" . $salt . $encrypted;

            return base64_encode($encryptedBytesWithSalt);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function decryptAESCryptoJS($encrypted, $passphrase)
    {
        try {
            $encryptedBytesWithSalt = base64_decode($encrypted);

            $salt = substr($encryptedBytesWithSalt, 8, 8);
            $encryptedBytes = substr($encryptedBytesWithSalt, 16);

            list($key, $iv) = $this->deriveKeyAndIV($passphrase, $salt);

            $decrypted = openssl_decrypt($encryptedBytes, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
            return $decrypted;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deriveKeyAndIV($passphrase, $salt)
    {
        $password = $passphrase;
        $concatenatedHashes = '';
        $currentHash = '';
        $enoughBytesForKey = false;

        while (!$enoughBytesForKey) {
            if (!empty($currentHash)) {
                $preHash = $currentHash . $password . $salt;
            } else {
                $preHash = $password . $salt;
            }

            $currentHash = md5($preHash, true);
            $concatenatedHashes .= $currentHash;

            if (strlen($concatenatedHashes) >= 48) {
                $enoughBytesForKey = true;
            }
        }

        $keyBytes = substr($concatenatedHashes, 0, 32);
        $ivBytes = substr($concatenatedHashes, 32, 16);

        return array($keyBytes, $ivBytes);
    }

    public function genRandomWithNonZero($seedLength)
    {
        $uint8list = '';
        for ($i = 0; $i < $seedLength; $i++) {
            $uint8list .= chr(random_int(1, 245));
        }
        return $uint8list;
    }
}
