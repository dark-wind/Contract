<?php

namespace Darkwind\Contract\Controllers;

use App\Http\Controllers\Controller;
use Darkwind\Contract\ContractOrigin;
use Illuminate\Http\Request;
use YExcel\Excel;

/**
 * 合同管理
 *
 * @Resource("合同管理", uri="/api/contract")
 */
class ContractController extends Controller
{
    /**
     * 合同列表
     *
     * 模糊搜索：
     *
     *       站点编码：site_code
     *       站点名称：site_name
     *       物业编码：property_code
     *       物业名称：property_name
     *       合同编码：contract_code
     *       合同名称：contract_name
     *       所属业主名称（甲方）：owner_name
     *       客商编号：common_code
     *
     * 精确搜索：
     *
     *      区县:zone
     *      站点性质:site_nature
     *      建设场景:scene
     *      合同类型:contract_type
     *      合同属性:contract_attribute
     *      业主类型:owner_type
     *      合同状态:contract_status
     *      是否代持:is_agency
     *      租金支付方式:rent_pay_type
     *      租金票据类型:rent_invoice_type
     *      是否我方代开票:is_agency_invoice
     *      电费支付方式:electric_charge_pay_method
     *      电费票据类型:electric_charge_invoice_type
     *
     *
     * @Get("/sitelist?site_code=fasddf&site_name=fasddf&property_code=fasddf&property_name=fasddf&contract_code=fasddf&contract_name=fasddf&owner_name=fasddf&common_code=fasddf&zone=fasddf&site_nature=fasddf&scene=fasddf&contract_type=fasddf&contract_attribute=fasddf&owner_type=fasddf&contract_status=fasddf&is_agency=fasddf&rent_pay_type=fasddf&rent_invoice_type=fasddf&is_agency_invoice=fasddf&electric_charge_pay_method=fasddf&electric_charge_invoice_type=fasddf")
     *
     * @Response(200, body={
     *     "status": "ok|error",
     *     "message": "...",
     *     "data": {"..."},
     *     "errors":null,
     *     "code":0
     * })
     */
    public function list(Request $request)
    {
        $query = $this->search($request);
        return $this->ajax('ok', '获取成功', $query->paginate());
    }

    /**
     * 合同源数据列表筛选条件
     *
     * @Get("/contractfilter?site_code=fasddf&site_name=fasddf&property_code=fasddf&property_name=fasddf&contract_code=fasddf&contract_name=fasddf&owner_name=fasddf&common_code=fasddf&zone=fasddf&site_nature=fasddf&scene=fasddf&contract_type=fasddf&contract_attribute=fasddf&owner_type=fasddf&contract_status=fasddf&is_agency=fasddf&rent_pay_type=fasddf&rent_invoice_type=fasddf&is_agency_invoice=fasddf&electric_charge_pay_method=fasddf&electric_charge_invoice_type=fasddf")
     *
     * @Response(200, body={
     *     "status": "ok|error",
     *     "message": "...",
     *     "data": {"..."},
     *     "errors":null,
     *     "code":0
     * })
     */
    public function contractFilter(Request $request)
    {
        $query = $this->search($request);
        $data = [];
        $list = ['zone', 'site_nature', 'scene', 'contract_type', 'contract_attribute', 'owner_type', 'contract_status', 'is_agency', 'rent_pay_type', 'rent_invoice_type', 'is_agency_invoice', 'electric_charge_pay_method', 'electric_charge_invoice_type'];
        foreach ($list as $item) {
            $temp = $query->distinct($item)->get()->toArray();
            $data[$item] = array_column($temp, 0);
        }
        return $this->ajax('ok', '获取成功', $data);
    }

    /**
     * 批量删除
     *
     * @Delete("/deletes")
     * @Request({"ids": {
     *            "jalfajslkf",
     *            "weolrjklwejrlke"
     *     }})
     *
     * @Response(200, body={
     *     "status": "ok|error",
     *     "message": "...",
     *     "data": {"..."},
     *     "errors":null,
     *     "code":0
     * })
     */
    public function deletes(Request $request)
    {
        $count = ContractOrigin::whereIn('_id', $request->ids)->delete();
        return $this->ajax('ok', "成功删除{$count}条数据");
    }

    /**
     *  合同详情
     *
     * @Get("/view/fasddfasdf")
     *
     *
     * @Response(200, body={
     *     "status": "ok|error",
     *     "message": "...",
     *     "data": {"..."},
     *     "errors":null,
     *     "code":0
     * })
     */
    public function view($id)
    {
        return $this->ajax('ok', '获取成功', ContractOrigin::findorFail($id));
    }

    /**
     *  合同基本信息修改/增加
     *
     * @Post("/save/fasdlfasf;l")
     *
     * @Request({
     *     "province":"省份",
     *     "city":"地市",
     *     "zone":"区县",
     *     "province_unit":"省分公司",
     *     "city_unit":"地市公司",
     *     "site_code":"站点编码",
     *     "site_name":"站点名称",
     *     "site_nature":"站点性质",
     *     "scene":"建设场景",
     *     "property_code":"物业编码",
     *     "property_name":"物业名称",
     *     "contract_code":"合同编码",
     *     "contract_name":"合同名称",
     *     "contract_type":"合同类型",
     *     "contract_attribute":"合同属性",
     *     "owner_name":"甲方",
     *     "common_code":"客商编号",
     *     "mobile":"联系方式",
     *     "certificate_number":"证件号码",
     *     "owner_belong_city_unit":"业主所属地市公司",
     *     "owner_type":"业主类型",
     *     "owner_certificate_type":"业主证件类型",
     *     "owner_certificate_number":"业主证件号码",
     *     "contract_part_B":"合同乙方",
     *     "contract_signed_at":"合同签订日期",
     *     "contract_start_at":"原始",
     *     "contract_pay_start_at":"起始日期",
     *     "contract_stop_at":"合同终止日期",
     *     "contract_record_at":"合同录入日期",
     *     "contract_total_money":"合同总金额",
     *     "agent":"经办人",
     *     "agent_department":"经办部门",
     *     "contract_status":"合同状态",
     *     "is_agency":"是否代持",
     *     "is_site_deleted":"站点是否删除",
     *     "last_updated_at":"最后修改时间",
     *     "house_lease_area":"房屋租赁面积",
     *     "place_lease_area":"场地租赁面积",
     *     "base_year_rent":"基本年租金",
     *     "rent_pay_type":"租金支付方式",
     *     "rent_pay_cycle":"租金支付周期",
     *     "rent_pay_first_at":"租金约定首次支付日期",
     *     "rent_collection_account":"租金收款账号",
     *     "rent_collection_username":"租金收款户名",
     *     "rent_belong_bank":"所属银行",
     *     "rent_belong_bank_detail":"租金收款银行",
     *     "rent_invoice_type":"租金票据类型",
     *     "is_agency_invoice":"我方代开票",
     *     "agency_rate":"代开票税点",
     *     "electric_charge_unit_price":"电费单价",
     *     "electric_charge_standard":"电价标准",
     *     "electric_charge_pay_method":"电费支付方式",
     *     "electric_charge_pay_cycle":"电费支付周期",
     *     "electric_charge_pay_first_at":"电费约定首次支付日期",
     *     "electric_charge_collection_account":"电费收款账号",
     *     })
     *
     * @Response(200, body={
     *     "status": "ok|error",
     *     "message": "...",
     *     "data": {"..."},
     *     "errors":null,
     *     "code":0
     * })
     */
    public function save(Request $request, $id = null)
    {
        $model = (new ContractOrigin())->saveInfo($request, $id);
        return $this->ajax('ok', '修改成功', $model);
    }

    /**
     * 合同数据筛选导出
     *
     * @Get("/export?site_name=fadsf&yunwei_code=fadsf&site_code=fadsf&isp_name=fadsf&computer_keep_people=fadsf&site_type=fasdfsdf&service_level=fasdfsdf&site_status=fasdfsdf&FSU_manufacturer=fasdfsdf&is_install_isp_device=fasdfsdf&is_disable_responsible_site=fasdfsdf&isp_share=fasdfsdf&maintain_status=fasdfsdf&site_source=fasdfsdf&build_type=fasdfsdf")
     *
     * @Response(200, body={
     *     "status": "ok|error",
     *     "message": "...",
     *     "data": {"..."},
     *     "errors":null,
     *     "code":0
     * })
     */
    public function export(Request $request)
    {
        $query = $this->search($request);
        $data = $query->get();

        $generator = function () use ($data) {
            yield [
                '省份', '地市', '区县', '省分公司', '地市公司', '站点编码', '站点名称', '站点性质', '建设场景', '物业编码', '物业名称', '合同编码', '合同名称', '合同类型', '合同属性', '所属业主名称（甲方）', '客商编号', '联系方式', '证件号码', '业主所属地市公司', '业主类型', '业主证件类型', '业主证件号码', '合同乙方', '合同签订日期', '合同起始日期（原始）', '合同支付（计提）起始日期', '合同终止日期', '合同录入日期', '合同总金额', '经办人', '经办部门', '合同状态', '是否代持', '站点是否删除', '最后修改时间', '房屋租赁面积（平方米）', '场地租赁面积（平方米）', '基本年租金(元/年)', '租金支付方式', '租金支付周期（月）', '租金约定首次支付日期', '租金收款账号', '租金收款户名', '所属银行（租金收款）', '租金收款银行', '租金票据类型', '我方代开票', '代开票税点（%）', '电费单价（元/度）', '电价标准', '电费支付方式', '电费支付周期（月）', '电费约定首次支付日期', '电费收款账号', '电费收款户名', '所属银行（电费收款）', '电费收款银行', '电费票据类型', '押金金额（元）'
            ];
            foreach ($data as $row) {
                yield [
                    $row->province,
                    $row->city,
                    $row->zone,
                    $row->province_unit,
                    $row->city_unit,
                    $row->site_code . ' ',
                    $row->site_name,
                    $row->site_nature,
                    $row->scene,
                    $row->property_code . ' ',
                    $row->property_name,
                    $row->contract_code,
                    $row->contract_name,
                    $row->contract_type,
                    $row->contract_attribute,
                    $row->owner_name,
                    $row->common_code . ' ',
                    $row->mobile,
                    $row->certificate_number . ' ',
                    $row->owner_belong_city_unit,
                    $row->owner_type,
                    $row->owner_certificate_type,
                    $row->owner_certificate_number . ' ',
                    $row->contract_part_B,
                    $row->contract_signed_at,
                    $row->contract_start_at,
                    $row->contract_pay_start_at,
                    $row->contract_stop_at,
                    $row->contract_record_at,
                    $row->contract_total_money,
                    $row->agent,
                    $row->agent_department,
                    $row->contract_status,
                    $row->is_agency,
                    $row->is_site_deleted,
                    $row->last_updated_at,
                    $row->house_lease_area,
                    $row->place_lease_area,
                    $row->base_year_rent,
                    $row->rent_pay_type,
                    $row->rent_pay_cycle,
                    $row->rent_pay_first_at,
                    $row->rent_collection_account . ' ',
                    $row->rent_collection_username,
                    $row->rent_belong_bank,
                    $row->rent_belong_bank_detail,
                    $row->rent_invoice_type,
                    $row->is_agency_invoice,
                    $row->agency_rate,
                    $row->electric_charge_unit_price,
                    $row->electric_charge_standard,
                    $row->electric_charge_pay_method,
                    $row->electric_charge_pay_cycle,
                    $row->electric_charge_pay_first_at,
                    $row->electric_charge_collection_account . ' ',
                    $row->electric_charge_collection_username,
                    $row->electric_charge_belong_bank,
                    $row->electric_charge_belong_bank_detail,
                    $row->electric_charge_invoice_type,
                    $row->cash_pledge,
                ];
            }
        };
        if (!$generator) {
            return $this->ajax('error', '导出参数错误，数据获取失败');
        }

        return response()->stream(function () use ($generator) {
            Excel::put(
                'php://output',
                $generator(),
                [
                    'skipRow' => 0
                ]
            );
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename=order_export.xlsx',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    private function search($request)
    {
        $query = ContractOrigin::query();
        if ($request->site_code) {
            $query->where('site_code', 'like', "%{$request->site_code}%");
        }
        if ($request->site_name) {
            $query->where('site_name', 'like', "%{$request->site_name}%");
        }
        if ($request->property_code) {
            $query->where('property_code', 'like', "%{$request->property_code}%");
        }
        if ($request->property_name) {
            $query->where('property_name', 'like', "%{$request->property_name}%");
        }
        if ($request->contract_code) {
            $query->where('contract_code', 'like', "%{$request->contract_code}%");
        }
        if ($request->contract_name) {
            $query->where('contract_name', 'like', "%{$request->contract_name}%");
        }
        if ($request->owner_name) {
            $query->where('owner_name', 'like', "%{$request->owner_name}%");
        }
        if ($request->common_code) {
            $query->where('common_code', 'like', "%{$request->common_code}%");
        }

        //区县
        if ($request->zone) {
            $query->where('zone', $request->zone);
        }
        //站点性质
        if ($request->site_nature) {
            $query->where('site_nature', $request->site_nature);
        }
        //        建设场景
        if ($request->scene) {
            $query->where('scene', $request->scene);
        }
        //合同类型
        if ($request->contract_type) {
            $query->where('contract_type', $request->contract_type);
        }
        //合同属性
        if ($request->contract_attribute) {
            $query->where('contract_attribute', $request->contract_attribute);
        }
        //业主类型
        if ($request->owner_type) {
            $query->where('owner_type', $request->owner_type);
        }
        //合同状态
        if ($request->contract_status) {
            $query->where('contract_status', $request->contract_status);
        }
        //是否代持
        if ($request->is_agency) {
            $query->where('is_agency', $request->is_agency);
        }
        //租金支付方式
        if ($request->rent_pay_type) {
            $query->where('rent_pay_type', $request->rent_pay_type);
        }
        //租金票据类型
        if ($request->rent_invoice_type) {
            $query->where('rent_invoice_type', $request->rent_invoice_type);
        }
        //是否我方代开票
        if ($request->is_agency_invoice) {
            $query->where('is_agency_invoice', $request->is_agency_invoice);
        }
        //电费支付方式
        if ($request->electric_charge_pay_method) {
            $query->where('electric_charge_pay_method', $request->electric_charge_pay_method);
        }
        //电费票据类型
        if ($request->electric_charge_invoice_type) {
            $query->where('electric_charge_invoice_type', $request->electric_charge_invoice_type);
        }

        return $query;
    }
}
