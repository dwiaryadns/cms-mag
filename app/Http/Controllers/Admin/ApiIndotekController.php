<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiIndotekController extends Controller
{
    public $GetToken = "https://simulasihealthmobile.mag.co.id/oauth/v1/token";
    public $GetGroupList = "https://simulasihealthmobile.mag.co.id/api/v1/other/GetGroupList";
    public $GetGroupPolList = "https://simulasihealthmobile.mag.co.id/api/v1/other/GetGroupPolList";
    public $GetGroupPolicyUserList = "https://simulasihealthmobile.mag.co.id/api/v1/other/GetGroupPolicyUserList";

    public function getSessionId()
    {
        $privateKey = env('PRIVATE_KEY');
        $timestamp = microtime(true);
        $microseconds = sprintf("%03d", ($timestamp - floor($timestamp)) * 1000);
        $formattedDate = date("YmdHis") . $microseconds;
        $text = $privateKey . '|' . $formattedDate;
        $sessionId = $this->encryptAESCryptoJS($text, $privateKey);
        Log::info('Decrypt SessionId : ' . $this->decryptAESCryptoJS($sessionId, $privateKey));
        Log::info('Encrypt SessionId : ' . $sessionId);
        Log::info('      ');
        return $sessionId;
    }

    public function getToken()
    {
        $username = env('USERNAME_INDOTEK');
        $password = env('PASSWORD_INDOTEK');
        $grantType = env('GRANT_TYPE_INDOTEK');
        $clientId = env('CLIENT_ID_INDOTEK');
        $clientSecret = env('CLIENT_SECRET_INDOTEK');
        $appId = env('APPID_INDOTEK');

        $data = [
            'grant_type' => $grantType,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'UserName' => $username,
            'Password' => $password,
            'AppId' => $appId
        ];
        Log::info(json_encode($data));
        $ch = curl_init($this->GetToken);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }

        curl_close($ch);

        if (isset($error_msg)) {
            return response()->json([
                'status' => $httpCode,
                'error' => $error_msg,
            ]);
        }

        return json_decode($response, true);
    }

    public function getGroupList(Request $request)
    {
        $getToken = $this->getToken();
        $accessToken = $getToken['access_token'];
        $appInfo = json_decode($getToken['AppInfo'], true);
        Log::info($appInfo);
        Log::info("           ");
        $clientHasId = $appInfo['ClientSecretHash'];

        $sData = [
            'UserID' => Auth::user()->email,
            'GroupNameId' => $request->groupName
        ];
        $encryptSData = $this->encryptAESCryptoJS(json_encode($sData), env('PRIVATE_KEY'));
        Log::info('Decrypt sData : ' . $this->decryptAESCryptoJS($encryptSData, env('PRIVATE_KEY')));
        Log::info(' sData : ' . $encryptSData);
        Log::info('      ');

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ];

        $data = [
            'ClientHashId' => $clientHasId,
            'SessionId' => $this->getSessionId(),
            'sData' => $encryptSData
        ];
        $ch = curl_init($this->GetGroupList);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        Log::info('data : ' . json_encode($data));
        Log::info('access token : ' . $accessToken);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        Log::info('Request cURL mulai dieksekusi');
        $response = curl_exec($ch);
        Log::info('Response diterima: ' . $response);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            Log::info($error_msg);
        }

        curl_close($ch);

        if (isset($error_msg)) {
            Log::info($error_msg);
            return response()->json([
                'status' => $httpCode,
                'error' => $error_msg,
            ]);
        }
        $result = json_decode($response, true);
        return response()->json([
            'data' => $result,
            'decrypt' => $this->decryptAESCryptoJS(json_encode($result['Message']), env("PRIVATE_KEY"))
        ]);
    }
    public function getGroupPolList(Request $request)
    {
        $getToken = $this->getToken();
        $accessToken = $getToken['access_token'];
        $appInfo = json_decode($getToken['AppInfo'], true);
        Log::info($appInfo);
        Log::info("           ");
        $clientHasId = $appInfo['ClientSecretHash'];

        $sData = [
            'UserID' => Auth::user()->email,
            'GroupId' => $request->groupId,
            'PolNoName' => "",
        ];
        $encryptSData = $this->encryptAESCryptoJS(json_encode($sData), env('PRIVATE_KEY'));
        Log::info('Decrypt sData : ' . $this->decryptAESCryptoJS($encryptSData, env('PRIVATE_KEY')));
        Log::info(' sData : ' . $encryptSData);
        Log::info('      ');

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ];

        $data = [
            'ClientHashId' => $clientHasId,
            'SessionId' => $this->getSessionId(),
            'sData' => $encryptSData
        ];
        $ch = curl_init($this->GetGroupPolList);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        Log::info('data : ' . json_encode($data));
        Log::info('access token : ' . $accessToken);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        Log::info('Request cURL mulai dieksekusi');
        $response = curl_exec($ch);
        Log::info('Response diterima: ' . $response);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            Log::info($error_msg);
        }

        curl_close($ch);

        if (isset($error_msg)) {
            Log::info($error_msg);
            return response()->json([
                'status' => $httpCode,
                'error' => $error_msg,
            ]);
        }
        $result = json_decode($response, true);
        return response()->json([
            'data' => $result,
            'decrypt' => $this->decryptAESCryptoJS(json_encode($result['Message']), env("PRIVATE_KEY"))
        ]);
    }
    public function getGroupPolicyUserList(Request $request)
    {
        $getToken = $this->getToken();
        $accessToken = $getToken['access_token'];
        $appInfo = json_decode($getToken['AppInfo'], true);
        Log::info($appInfo);
        Log::info("           ");
        $clientHasId = $appInfo['ClientSecretHash'];

        $sData = [
            "UserID" => Auth::user()->email,
            "GroupId" => $request->groupId,
            "PolicyNo" => $request->policyNo,
            "MemberName" => ""
        ];
        $encryptSData = $this->encryptAESCryptoJS(json_encode($sData), env('PRIVATE_KEY'));
        Log::info('Decrypt sData : ' . $this->decryptAESCryptoJS($encryptSData, env('PRIVATE_KEY')));
        Log::info(' sData : ' . $encryptSData);
        Log::info('      ');

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ];

        $data = [
            'ClientHashId' => $clientHasId,
            'SessionId' => $this->getSessionId(),
            'sData' => $encryptSData
        ];
        $ch = curl_init($this->GetGroupPolicyUserList);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        Log::info('data : ' . json_encode($data));
        Log::info('access token : ' . $accessToken);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        Log::info('Request cURL mulai dieksekusi');
        $response = curl_exec($ch);
        Log::info('Response diterima: ' . $response);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            Log::info($error_msg);
        }

        curl_close($ch);

        if (isset($error_msg)) {
            Log::info($error_msg);
            return response()->json([
                'status' => $httpCode,
                'error' => $error_msg,
            ]);
        }
        $result = json_decode($response, true);
        return response()->json([
            'data' => $result,
            'decrypt' => $this->decryptAESCryptoJS(json_encode($result['Message']), env("PRIVATE_KEY"))
        ]);
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

    public function decrypt(Request $request)
    {
        return $this->decryptAESCryptoJS($request->encrypt, env('PRIVATE_KEY'));
    }
}
