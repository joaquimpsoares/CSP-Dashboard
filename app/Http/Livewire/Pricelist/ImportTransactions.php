<?php

namespace App\Http\Livewire\Pricelist;

use App\Csv;
use App\Price;
use Validator;
use App\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class ImportTransactions extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $upload;
    public $priceList;
    public $columns;
    public $fieldColumnMap = [
        'name'              => '',
        'product_sku'       => '',
        'instance_id'       => '',
        'product_vendor'    => '',
        'price'             => '',
        'msrp'              => '',
        'currency'          => '',
    ];

    protected $rules = [
        'fieldColumnMap.name' => 'required',
        'fieldColumnMap.product_sku' => 'required',
    ];

    protected $customAttributes = [
        'fieldColumnMap.name' => 'name',
        'fieldColumnMap.product_sku' => 'product sku',
    ];

    public function updatingUpload($value)
    {
        Validator::make(
            ['upload' => $value],
            ['upload' => 'required|mimes:txt,csv,xlsx'],
        )->validate();
    }

    public function updatedUpload()
    {
        $this->columns = Csv::from($this->upload)->columns();

        $this->guessWhichColumnsMapToWhichFields();
    }

    public function import()
    {
        $this->validate();
        $importCount = 0;
        Csv::from($this->upload)
        ->eachRow(function ($row) use (&$importCount) {
            $tt = $this->extractFieldsFromRow($row);
            // dd($tt['instance_id']);
            $product = Product::where('instance_id', $tt['instance_id'] )->where('sku', $tt['product_sku'])->first();
            // Log::info('instance id: ' .$this->priceList->instance_id. ' updating for ID: '. $product->id . ' sku: '. $tt['product_sku'] .' name: ' .$tt['name']);

            if($tt['product_id'] != null){
                try {
                    $price = Price::updateOrCreate([
                        'product_sku'   => $tt['product_sku'],
                        'instance_id'   => $this->priceList->instance_id,
                        'price_list_id' => $this->priceList->id,
                        'name'          => $tt['name'],
                    ],[
                        'price'         => $tt['price'],
                        'msrp'          => $tt['msrp'],
                        'product_vendor'=> $tt['product_vendor'],
                        'product_id'    => $product->id,

                    ]);
                Log::info('Budget updated for: '. $price['product_sku'].' name:'. $price['name']);

                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }

                $importCount++;
            }
            });
        $this->reset();
        $this->emit('refreshTransactions');
        $this->notify('Imported '.$importCount.' transactions!');
    }

    public function extractFieldsFromRow($row)
    {
        $product = Product::where('sku', $row['Offer ID'])->where('instance_id', $this->priceList->instance_id)->pluck('id')->first();

        $attributes = collect($this->fieldColumnMap)
        ->filter()
        ->mapWithKeys(function($heading, $field) use ($row) {
            return [$field => $row[$heading]];
        })->toArray();

        return $attributes + [
            'product_vendor' => 'microsoft',
            'instance_id' => $this->priceList->instance_id,
            'price_list_id' => $this->priceList->id,
            'product_id' => $product
        ];
    }

    public function guessWhichColumnsMapToWhichFields()
    {
        $guesses = [
            'name'          => ['offer display name'],
            'product_sku'   => ['offer id'],
            'price'         => ['list price',],
            'msrp'          => ['erp price',],
        ];

        foreach ($this->columns as $column) {
            $match = collect($guesses)->search(fn($options) => in_array(strtolower($column), $options));

            if ($match) $this->fieldColumnMap[$match] = $column;
        }
    }
}
