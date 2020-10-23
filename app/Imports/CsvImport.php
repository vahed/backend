<?php

namespace App\Imports;

use App\Customer;
use App\Product;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use phpDocumentor\Reflection\Types\Array_;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class CsvImport extends DefaultValueBinder implements ToCollection,WithCustomValueBinder
{
    public $id = null;
    public $order_date = null;
    public $customer_number = null;
    public $first_name = null;
    public $family_name = null;
    public $product_number = null;
    public $description = null;
    public $cost = null;
    public $quantity = null;
    public $total = null;
    public $cust = array();

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function Collection(Collection $collection)
    {
        foreach ($collection as $key => $value){
            if($key > 0) {

                $this->id = (int)$value[0];
                $this->order_date = $this->formatDate($value[1]);
                $this->customer_number = (int)$value[2];
                $this->first_name = $value[3];
                $this->family_name = $value[4];
                $this->product_number = (int)$value[5];
                $this->description = $value[6];
                $this->cost = $value[7];
                $this->quantity = (int)$value[8];
                $this->total = $this->totalAmount($this->cost,$this->quantity);

                if($this->id) {
                    //check for any duplicate names
                    $customer = Customer::where([
                        'first_name' => $this->first_name,
                        'family_name' => $this->family_name
                        ])->first();

                    if($customer === null) {
                        DB::table('customers')->insertOrIgnore([
                            'id' => $this->customer_number,
                            'first_name' => $this->first_name,
                            'family_name' => $this->family_name
                        ]);
                    }

                    DB::table('products')->insertOrIgnore([
                        'id' => $this->product_number,
                        'description' => $this->description,
                        'cost' => $this->cost
                    ]);

                    DB::table('ordered_items')->insert([
                        'order_id' => $this->id,
                        'quantity' => $this->quantity,
                        'total' => $this->total,
                        'order_date' => $this->order_date,
                    ]);

                    DB::table('orders')->insertOrIgnore([
                        'order_number' => $this->id,
                        'customer_number' => $this->customer_number,
                        'product_number' => $this->product_number,
                    ]);
                }
            }
        }

    }

    /**
     * @param make sure total amount
     * of each items is correct
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function totalAmount($cost,$quantity):float
    {
        $total = $cost * $quantity;

        return $total;
    }

    /**
     * @param change excel format $date
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function formatDate($date)
    {
        $unixDate = ($date - 25569) * 86400;
        $newDateFormat = date("Y-m-d", $unixDate);//gmdate("d-m-Y H:i:s", $unixDate);

        return $newDateFormat;
    }

}
