<?php

namespace Darkwind\Contract;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;
use YExcel\Excel;

class ContractOrigin extends Model
{
    //
    protected $connection = 'mongodb';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //
    public function saveInfo($request, $id)
    {

        $model = $id ? ContractOrigin::findOrFail($id) : new ContractOrigin();
        $params = $request->all();
        unset($params['id']);

        foreach ($params as $index => $value) {
            $model->$index = $value;
        }
        return $model->save() ? $model : false;
    }

    public function import($file)
    {
        //读取文件
        if (in_array($file->mime, ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/wps-office.xlsx',])) {
            $type = 'Excel2007';
        } else {
            $type = 'Excel5';
        }
        $config = ['highestColumn' => count($this->contractAttrs()), 'skipRows' => [1], 'type' => $type];

        $xlsFile = $file->realPath();

        $data = [];
        foreach (Excel::get($xlsFile, $config) as $row) {
            if ($row[0] && $row[1] && $row [2]) {
                $arr = array_combine($this->contractAttrs(), $row);
                $data[] = $arr;
            }
        }

//        write data
        if ($count = count($data)) {
            DB::connection('mongodb')->collection('contract_origins')->delete();
            DB::connection('mongodb')->collection('contract_origins')->insert(array_values($data));
        }
        return $count;
    }


    private function contractAttrs()
    {
        return [
            'province',
            'city',
            'zone',
            'province_unit',
            'city_unit',
            'site_code',
            'site_name',
            'site_nature',
            'scene',
            'property_code',
            'property_name',
            'contract_code',
            'contract_name',
            'contract_type',
            'contract_attribute',
            'owner_name',
            'common_code',
            'mobile',
            'certificate_number',
            'owner_belong_city_unit',
            'owner_type',
            'owner_certificate_type',
            'owner_certificate_number',
            'contract_part_B',
            'contract_signed_at',
            'contract_start_at',
            'contract_pay_start_at',
            'contract_stop_at',
            'contract_record_at',
            'contract_total_money',
            'agent',
            'agent_department',
            'contract_status',
            'is_agency',
            'is_site_deleted',
            'last_updated_at',
            'house_lease_area',
            'place_lease_area',
            'base_year_rent',
            'rent_pay_type',
            'rent_pay_cycle',
            'rent_pay_first_at',
            'rent_collection_account',
            'rent_collection_username',
            'rent_belong_bank',
            'rent_belong_bank_detail',
            'rent_invoice_type',
            'is_agency_invoice',
            'agency_rate',
            'electric_charge_unit_price',
            'electric_charge_standard',
            'electric_charge_pay_method',
            'electric_charge_pay_cycle',
            'electric_charge_pay_first_at',
            'electric_charge_collection_account',
            'electric_charge_collection_username',
            'electric_charge_belong_bank',
            'electric_charge_belong_bank_detail',
            'electric_charge_invoice_type',
            'cash_pledge',
        ];
    }
}
