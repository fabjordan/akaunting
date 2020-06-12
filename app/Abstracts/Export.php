<?php

namespace App\Abstracts;

use App\Utilities\Date;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

abstract class Export implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithTitle
{
    public $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function title(): string
    {
        return Str::snake((new \ReflectionClass($this))->getShortName());
    }

    public function fields(): array
    {
        return [];
    }

    public function map($model): array
    {
        $map = [];

        $date_fields = ['paid_at', 'invoiced_at', 'billed_at', 'due_at', 'issued_at', 'created_at'];

        $fields = ['name', 'sale_price', 'purchase_price', 'quantity', 'category_name', 'description', 'enabled'];

        foreach ($fields as $field) {
            $value = $model->$field;

            if (in_array($field, $date_fields)) {
                $value = Date::parse($value)->format('d/m/Y');
            }

            $map[] = $value;
        }

        return $map;
    }

    public function headings(): array
    {
        return [
            'Nome',
            'Preço de Venda',
            'Preço de Compra',
            'Quantidade',
            'Categoria',
            'Descrição',
            'Ativado',
        ];

        // return $this->fields();
    }
}
