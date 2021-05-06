<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ProductsImport implements ToModel , SkipsOnError , WithValidation , SkipsOnFailure , WithBatchInserts , WithChunkReading
{
    use Importable , SkipsErrors , SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $repository_id;

    public function __construct($repo_id){
         $this->repository_id = $repo_id;
    }
    
    /*public function model(array $row)
    {
        return new Product([
        'repository_id' => $this->repository_id,
           'barcode' => $row[0],
           'name'    => $row[1], 
           'details' => $row[2],
           'price'   => $row[3],
           'quantity'=> $row[4],
        ]);
    }*/
    public function model(array $row)
    {   
        $product = Product::where('repository_id',$this->repository_id)->where('barcode',$row[0])->first();
        if($product)  // found it
        {
        $new_quantity = $product->quantity + $row[4];
        $new_price = $row[3];
        $product->update([
            'quantity' => $new_quantity,
            'price' => $new_price,
        ]);
        }
    else{
        return new Product([
        'repository_id' => $this->repository_id,
           'barcode' => $row[0],
           'name'    => $row[1], 
           'details' => $row[2],
           'price'   => $row[3],
           'quantity'=> $row[4],
        ]);
        }
    }
    public function onError(Throwable $error){

    }


    public function rules(): array
    {
        return [
            '*.0' => 'required',
            '*.1' => 'required',
            '*.2' => 'required',
            '*.3' => 'required',
            '*.4' => 'required',
        ];
    }
    
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    public function batchSize(): int    // we use withBatchInserts interface for the very large files
    {
        return 1000;
    }

    public function chunkSize(): int   // for memory usage for big files
    {
        return 1000;
    }
}
