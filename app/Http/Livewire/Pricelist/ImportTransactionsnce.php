<?php

namespace App\Http\Livewire\Pricelist;

use App\Csv;
use App\Price;
use Validator;
use App\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class ImportTransactionsnce extends Component
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
        'currency'          => '',
        'market'            => '',
        'term_duration'     => '',
        'product_vendor'    => '',
        'price'             => '',
        'billing_plan'      => '',
        'msrp'              => '',
        'currency'          => '',
    ];

    protected $rules = [
        'fieldColumnMap.name'           => 'required',
        'fieldColumnMap.product_sku'    => 'required',
    ];

    protected $customAttributes = [
        'fieldColumnMap.name'           => 'name',
        'fieldColumnMap.product_sku'    => 'product sku',
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
            if($tt['product_id'] != null){
                try {
                    $price = Price::updateOrCreate([
                        'product_sku'   => $tt['product_sku'],
                        'instance_id'   => $this->priceList->instance_id,
                        'price_list_id' => $this->priceList->id,
                        'name'          => $tt['name'],
                    ],[
                        'billing_plan'  => $tt['billing_plan'],
                        'currency'      => $tt['currency'],
                        'term_duration' => $tt['term_duration'],
                        'price'         => $tt['price'],
                        'msrp'          => $tt['msrp'],
                        'product_vendor'=> $tt['product_vendor'],
                        'product_id'    => $tt['product_id'],

                    ]);
                Log::info('Budget updated for: '. $price['product_sku'].' name:'. $price['name']);

                } catch (\Throwable $th) {
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
        $product = Product::where('sku', $row['SkuId'])->where('instance_id', $this->priceList->instance_id)->pluck('id')->first();
        $attributes = collect($this->fieldColumnMap)
        ->filter()
        ->mapWithKeys(function($heading, $field) use ($row) {
            return [$field => $row[$heading]];
        })->toArray();

        return $attributes + [
            'product_vendor'    => 'microsoft',
            'instance_id'       => $this->priceList->instance_id,
            'price_list_id'     => $this->priceList->id,
            'market'            => $row['Market'] ?? null,
            'billing_plan'      => $row['BillingPlan'] ?? null,
            'currency'          => $row['Currency'],
            'term_duration'     => $row['TermDuration'] ?? null,
            'product_id'        => $product,

        ];
    }

    public function guessWhichColumnsMapToWhichFields()
    {
        $guesses = [
            'name'          => ['skutitle'],
            'product_sku'   => ['skuid'],
            'price'         => ['unitprice',],
            'msrp'          => ['erp price',],
        ];
        foreach ($this->columns as $column) {

            $match = collect($guesses)->search(fn($options) => in_array(strtolower($column), $options));

            if ($match) $this->fieldColumnMap[$match] = $column;
        }
    }
}
