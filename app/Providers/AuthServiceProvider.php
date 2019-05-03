<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Debug\Exception\FatalThrowableError;

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

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Auth::viaRequest('jwttoken', function ($request) {
//            $user = User::where('id', 1)->first();

            $token = $request->bearerToken();
            try {
                $algorithmManager = AlgorithmManager::create([
                    new HS256(),
                    new A256KW()
                ]);

                $jwsVerifier = new JWSVerifier(
                    $algorithmManager
                );

                $headerCheckerManager = HeaderCheckerManager::create(
                    [
//                new AlgorithmChecker(['HS256']), // We check the header "alg" (algorithm)
                        new AlgorithmChecker(['A256KW']), // We check the header "alg" (algorithm)

                    ],
                    [
                        new JWETokenSupport(), // Adds JWS token type support
                    ]
                );
                $headerCheckerManager2 = HeaderCheckerManager::create(
                    [
                        new AlgorithmChecker(['HS256']), // We check the header "alg" (algorithm)
//                new AlgorithmChecker(['A256KW']), // We check the header "alg" (algorithm)

                    ],
                    [
                        new JWSTokenSupport(), // Adds JWS token type support
                    ]
                );

                $jsonConverter = new StandardConverter();

                $jwsSerializerManager = SSerializer\JWSSerializerManager::create([
                    new SSerializer\JSONFlattenedSerializer($jsonConverter),
                    new SSerializer\CompactSerializer($jsonConverter),
                ]);

                $jwsLoader = new JWSLoader(
                    $jwsSerializerManager,
                    $jwsVerifier,
                    $headerCheckerManager2
                );


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

                $jweDecrypter = new JWEDecrypter(
                    $keyEncryptionAlgorithmManager,
                    $contentEncryptionAlgorithmManager,
                    $compressionMethodManager
                );


                $jweSerializerManager = ESerializer\JWESerializerManager::create([
                    new ESerializer\JSONFlattenedSerializer($jsonConverter),
                    new ESerializer\CompactSerializer($jsonConverter),
                ]);

                $jweLoader = new JWELoader(
                    $jweSerializerManager,
                    $jweDecrypter,
                    $headerCheckerManager
                );


                $jwk = JWK::create([
                    'kty' => 'oct',
                    'k' => 'dzI6nbW4OcNF-AtfxGAmuyz7IpHRudBI0WgGjZWgaRJt6prBn3DARXgUR8NVwKhfL43QBIU2Un3AvCGCHRgY4TbEqhOi8-i98xxmCggNjde4oaW6wkJ2NgM3Ss9SOX9zS3lcVzdCMdum-RwVJ301kbin4UtGztuzJBeg5oVN00MGxjC2xWwyI0tgXVs-zJs5WlafCuGfX1HrVkIf5bvpE0MQCSjdJpSeVao6-RSTYDajZf7T88a2eVjeW31mMAg-jzAWfUrii61T_bYPJFOXW8kkRWoa1InLRdG6bKB9wQs9-VdXZP60Q4Yuj_WZ-lO7qV9AEFrUkkjpaDgZT86w2g',
                ]);

                $encryptionKeySet = JWKSet::createFromKeys(array($jwk));
                $signatureKeySet = JWKSet::createFromKeys(array($jwk));
                $nestedTokenLoader = new NestedTokenLoader($jweLoader, $jwsLoader);
                try {
                    $jws = $nestedTokenLoader->load($token, $encryptionKeySet, $signatureKeySet);
                } catch(\Throwable $e) {
                    return null;
                }
                $decryptedString = $jws->getPayload();
                $decryptedjson = json_decode($decryptedString, true);

                if($decryptedjson["exp"] - time() < 0)
                {
                    return null;
                }
                $data = Arr::only($decryptedjson, ['email', 'password']);
                $user = User::where('email', $data['email'])
                    ->first();
                $validCredentials = Hash::check($data['password'], $user['password']);
                if ($validCredentials) {
                    return $user;
                }
                else
                {
                    return null;
                }
            }
            catch (\Exception $e)
            {
                return null;
            }
        });


        //
    }
}
