<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{
    public function index()
    {
        return view('page.admin.promotion.index');
    }

    public function getPromotion(Request $request)
    {
        if ($request->ajax()) {
            $data = Promotion::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($row) {
                    $readMore = "";
                    if (strlen($row->description) > 200) {
                        $readMore = '"<i class="read-more" style="cursor:pointer" class="underline" data-id="' . $row->id . '"><u>baca selengkapnya</u></i>';
                    }
                    return \Str::limit(strip_tags($row->description), 200) . $readMore;
                })
                ->rawColumns(['description'])
                ->addColumn('image', function ($row) {
                    return '<img width="200" src="' . url($this->decryptAESCryptoJS($row->image, env('SECRET_KEY_INDOTEK'))) . '"/>';
                })
                ->rawColumns(['image'])
                ->addColumn('date', function ($row) {
                    return '<span>' . date('d F Y', strtotime($row->start_date)) . ' s.d ' . date('d F Y', strtotime($row->end_date)) . '</span>';
                })
                ->rawColumns(['date'])
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-id="' . $row->id . '" class="edit-promotion btn btn-success btn-sm"><i class="fas fa-edit"></i></button>';
                    $actionBtn .= ' <button data-id="' . $row->id . '" class="delete-promotion btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->rawColumns(['action'])
                ->make();
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'image' => 'nullable',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        $imagePath = null;
        $newPath = null;
        $getPromotion = Promotion::find($request->id); // Ambil promosi lama jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();

            $ch = curl_init();
            $url = env('URL_API') . '/api/store-file/promotions';

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
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode == 200) {
                $response = json_decode($response, true);
                $imagePath = $response['image_path'];
            } else {
                return response()->json(['error' => 'Failed to upload image to API.'], 500);
            }
        } else {
            $newPath = $getPromotion ? $getPromotion->image : null;
        }
        $groupId = explode(',', $request->group_id);
        $memberId = explode(',', $request->member_id);
        Log::info($groupId);

        $dataString = $request->polis_id;
        Log::info('INGFOOOOOOOOO');
        $dataArray = json_decode('[' . $dataString . ']', true);
        Log::info($dataArray);

        $policyNumbers = array_map(function ($item) {
            return trim($item['policyNo']);
        }, $dataArray);
        Log::info($policyNumbers);
        $branchId = array_map(function ($item) {
            return trim($item['branchId']);
        }, $dataArray);
        Log::info($branchId);
        $policyCombine = array_map(function ($item) {
            return trim($item['policyCombine']);
        }, $dataArray);
        Log::info($policyCombine);

        $promotion = Promotion::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'author' => $request->author,
                'description' => $request->description,
                'image' =>  $newPath != null ? $newPath : $this->encryptAESCryptoJS(env('URL_API') . '/' . $imagePath, env('SECRET_KEY_INDOTEK')),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'branch_id' => $this->encryptAESCryptoJS(json_encode($branchId), env('SECRET_KEY_INDOTEK')),
                'group_id' => $this->encryptAESCryptoJS(json_encode($groupId), env('SECRET_KEY_INDOTEK')),
                'polis_id' => $this->encryptAESCryptoJS(json_encode($policyNumbers), env('SECRET_KEY_INDOTEK')),
                'member_id' => $this->encryptAESCryptoJS(json_encode($memberId), env('SECRET_KEY_INDOTEK')),
                'policy_combine' => $this->encryptAESCryptoJS(json_encode(str_replace(' ', '', $policyCombine)), env('SECRET_KEY_INDOTEK'))
            ]
        );
        return response()->json(['success' => 'Promotion saved successfully.', 'data' => $promotion]);
    }
    public function edit($id)
    {
        $promotion = Promotion::find($id);
        $data = [
            'id' => $promotion->id,
            'title' => $promotion->title,
            'author' => $promotion->author,
            'description' => $promotion->description,
            'start_date' => $promotion->start_date,
            'end_date' => $promotion->end_date,
            'branch_id' => json_decode($this->decryptAESCryptoJS($promotion->branch_id, env('SECRET_KEY_INDOTEK'))),
            'group_id' => json_decode($this->decryptAESCryptoJS($promotion->group_id, env('SECRET_KEY_INDOTEK'))),
            'polis_id' => json_decode($this->decryptAESCryptoJS($promotion->polis_id, env('SECRET_KEY_INDOTEK'))),
            'member_id' => json_decode($this->decryptAESCryptoJS($promotion->member_id, env('SECRET_KEY_INDOTEK'))),
        ];
        return response()->json($data);
    }
    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        if ($promotion->image) {
            $imagePath = public_path($promotion->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $promotion->delete();
        return response()->json(['success' => 'Promotion deleted successfully.']);
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
