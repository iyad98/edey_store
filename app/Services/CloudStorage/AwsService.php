<?php

namespace App\Services\CloudStorage;

// models

use Aws\S3\S3Client;
use Illuminate\Support\Facades\File;


class AwsService
{
    public $client;
    public function __construct()
    {
        $this->client = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'endpoint' => env('AWS_ENDPOINT','https://fra1.digitaloceanspaces.com'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID','3FWL6YUJFDAOCV2YWT6W'),
                'secret' => env('AWS_SECRET_ACCESS_KEY','OcdcnmItHyLOMBWj3iJwWfgxFXFPNdwA7zpJhqhwk9Q'),
            ],
        ]);
    }
    public function upload_file($key , $body){
        $result = $this->client->putObject([
            'Bucket' => env('AWS_BUCKET','q8store-space'),
            'Key'    => $key,
            'Body'   => $body,
            'ACL'    => 'public-read'
        ]);
    }
    public function delete_file($key) {
        $this->client->deleteObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $key,
        ]);
    }

    // help
    public function upload(){
        $result = $this->client->putObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key'    => 'test/test2.png',
            'Body'   => File::get(public_path('')."/uploads/galleries/2020-09-15/szqn0Gd72iFkAzg0ugqM1600170861NaGxmyo7dlMhvSEySYvN.png"),
            'ACL'    => 'public-read'
        ]);
        dd($result->toArray());
    }
    public function upload_optimize_file($dest) {
        $result = $this->client->putObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key'    => 'test/test_optimize.png',
            'Body'   => file_get_contents($dest),
            'ACL'    => 'public-read'
        ]);
        dd($result);
    }
}
