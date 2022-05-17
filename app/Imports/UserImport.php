<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UserImport implements ToModel, WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */
    public function model(array $row){
        $user = User::where('email',$row[3])->first();
        if ($user === null) {
            return new User([
                'name'             => $row[0],
                'lastname'         => $row[1],
                'contact'          => json_encode(['phone' => $row[2]]),
                'email'            => $row[3],
                'password'         => Hash::make($row[4]),
                'autorization'     => $row[5] === 'true' ? true : false,
                'terms_conditions' => $row[6] === 'true' ? true : false,
            ]);   
        }        
    }

    public function batchSize(): int
    {
        return 100000;
    }
    
    public function chunkSize(): int
    {
        return 100000;
    }
}
