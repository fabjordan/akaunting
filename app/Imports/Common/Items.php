<?php

namespace App\Imports\Common;

use App\Abstracts\Import;
use App\Http\Requests\Common\Item as Request;
use App\Models\Common\Item as Model;

class Items extends Import
{
    public function model(array $row)
    {
        return new Model($row);
    }

    public function map($row): array
    {
        $keys = [
            'name',
            'sale_price',
            'purchase_price',
            'quantity',
            'category_name',
            'description',
            'enabled',
        ];

        $row = array_combine($keys, array_values(array_filter($row)));
        $row = parent::map($row);

        $row['category_id'] = $this->getCategoryId($row, 'item');
        // $row['tax_id'] = $this->getTaxId($row);

        return $row;
    }

    public function rules(): array
    {
        return (new Request())->rules();
    }
}
