<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Jose\Component\Core\JWK;
use Jose\Component\Core\JWKSet;
use Jose\Component\Signature\Algorithm\HS256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Signature\JWSLoader;

use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Encryption\NestedTokenBuilder;
use Jose\Component\Encryption\NestedTokenLoader;
use Jose\Component\Encryption\JWESerializerManagerFactory;
use Jose\Component\Encryption\Algorithm\KeyEncryption\A256KW;
use Jose\Component\Encryption\Algorithm\ContentEncryption\A256CBCHS512;
use Jose\Component\Encryption\Compression\CompressionMethodManager;
use Jose\Component\Encryption\Compression\Deflate;
use Jose\Component\Encryption\JWEBuilder;
use Jose\Component\Encryption\JWELoader;
use Jose\Component\Encryption\JWEDecrypter;
use Jose\Component\Encryption\JWETokenSupport;

use Jose\Component\Signature\Serializer as SSerializer;
use Jose\Component\Encryption\Serializer as ESerializer;

use Jose\Component\Checker\HeaderCheckerManager;
use Jose\Component\Checker\AlgorithmChecker;
use Jose\Component\Signature\JWSTokenSupport;

use Illuminate\Support\Facades\Hash;

class AuthenticationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
//        dd($request->all());

        $algorithmManager = AlgorithmManager::create([
            new HS256(),
            new A256KW()
        ]);

        $user = \App\User::where('email',$request->email)->first();
        if(!$user)
        {
            return response()->json()->setStatusCode(404);
        }

        $validCredentials = Hash::check($request->password, $user['password']);
        if(!$validCredentials)
        {
            return response()->json()->setStatusCode(404);
        }
// The JSON Converter.
        $jsonConverter = new StandardConverter();

// We instantiate our JWS Builder.
        $jwsBuilder = new JWSBuilder(
            $jsonConverter,
            $algorithmManager
        );

        $jwk = JWK::create([
            'kty' => 'oct',
            'k' => 'dzI6nbW4OcNF-AtfxGAmuyz7IpHRudBI0WgGjZWgaRJt6prBn3DARXgUR8NVwKhfL43QBIU2Un3AvCGCHRgY4TbEqhOi8-i98xxmCggNjde4oaW6wkJ2NgM3Ss9SOX9zS3lcVzdCMdum-RwVJ301kbin4UtGztuzJBeg5oVN00MGxjC2xWwyI0tgXVs-zJs5WlafCuGfX1HrVkIf5bvpE0MQCSjdJpSeVao6-RSTYDajZf7T88a2eVjeW31mMAg-jzAWfUrii61T_bYPJFOXW8kkRWoa1InLRdG6bKB9wQs9-VdXZP60Q4Yuj_WZ-lO7qV9AEFrUkkjpaDgZT86w2g',
        ]);
        $jwsSerializerManager = SSerializer\JWSSerializerManager::create([
            new SSerializer\JSONFlattenedSerializer($jsonConverter),
            new SSerializer\CompactSerializer($jsonConverter),
        ]);
        $jweSerializerManager = ESerializer\JWESerializerManager::create([
            new ESerializer\JSONFlattenedSerializer($jsonConverter),
            new ESerializer\CompactSerializer($jsonConverter),
        ]);


        $keyEncryptionAlgorithmManager = AlgorithmManager::create([
            new A256KW(),
        ]);

// The content encryption algorithm manager with the A256CBC-HS256 algorithm.
        $contentEncryptionAlgorithmManager = AlgorithmManager::create([
            new A256CBCHS512(),
        ]);

// The compression method manager with the DEF (Deflate) method.
        $compressionMethodManager = CompressionMethodManager::create([
            new Deflate(),
        ]);
        $jweBuilder = new JWEBuilder(
            $jsonConverter,
            $keyEncryptionAlgorithmManager,
            $contentEncryptionAlgorithmManager,
            $compressionMethodManager
        );

        $payload = $jsonConverter->encode([
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 3600,
            'iss' => 'My service',
            'aud' => 'Your application',
//            'username' => "john",
//            'password' => "qwerty"
                  'id' => $user->id,
        ]);



        $nestedTokenBuilder = new NestedTokenBuilder($jweBuilder, $jweSerializerManager, $jwsBuilder, $jwsSerializerManager);


        $token = $nestedTokenBuilder->create(
            $payload,                                     // The payload to protect
            [[                                            // A list of signatures. 'key' is mandatory and at least one of 'protected_header'/'header' has to be set.
                'key'              => $jwk,     // The key used to sign. Mandatory.
                'protected_header' => ['alg' => 'HS256'], // The protected header. Optional.
            ]],
            'jws_compact',
//            'jws_json_flattened',
            // The serialization mode for the JWS
            ['alg' => 'A256KW', 'enc' => 'A256CBC-HS512'], // The shared protected header. Optional.
            [],                             // The shared unprotected header. Optional.
            [[                                            // A list of recipients. 'key' is mandatory.
                'key'    => $jwk,              // The recipient key.
            ]],
            'jwe_compact'                         // The serialization mode for the JWE.
//            'jwe_json_flattened'
        );
//        dd(2);
        $userdata = collect($user->toArray())->only("id","firstname","lastname","email",'image');
        return response()
        ->json(array($token,$userdata))
        ->setStatusCode(201, "JWT created");

//        $jwsVerifier = new JWSVerifier(
//            $algorithmManager
//        );
//        $headerCheckerManager = HeaderCheckerManager::create(
//            [
////                new AlgorithmChecker(['HS256']), // We check the header "alg" (algorithm)
//                new AlgorithmChecker(['A256KW']), // We check the header "alg" (algorithm)
//
//            ],
//            [
//                new JWETokenSupport(), // Adds JWS token type support
//            ]
//        );
//        $headerCheckerManager2 = HeaderCheckerManager::create(
//            [
//                new AlgorithmChecker(['HS256']), // We check the header "alg" (algorithm)
////                new AlgorithmChecker(['A256KW']), // We check the header "alg" (algorithm)
//
//            ],
//            [
//                new JWSTokenSupport(), // Adds JWS token type support
//            ]
//        );
//        $jwsLoader = new JWSLoader(
//            $jwsSerializerManager,
//            $jwsVerifier,
//            $headerCheckerManager2
//        );
//
//        $jweDecrypter = new JWEDecrypter(
//            $keyEncryptionAlgorithmManager,
//            $contentEncryptionAlgorithmManager,
//            $compressionMethodManager
//        );
//        $jweLoader = new JWELoader(
//            $jweSerializerManager,
//            $jweDecrypter,
//            $headerCheckerManager
//        );
//        $encryptionKeySet = JWKSet::createFromKeys(array($jwk));
//        $signatureKeySet = JWKSet::createFromKeys(array($jwk));
//        $nestedTokenLoader = new NestedTokenLoader($jweLoader, $jwsLoader);
//        $jws = $nestedTokenLoader->load($token, $encryptionKeySet, $signatureKeySet);
//        dd($jws->getPayload());
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
