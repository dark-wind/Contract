基于 laravel5.4 的合同模块 扩展包

安装

    composer require darkwindcc/contract

注册扩展包(5.5以上版本不需要这一步)

config/app.php 中的providers数组中添加：

    Darkwind\Contract\ContractServiceProvider::class

加载迁移和配置文件

    php artisan vendor:publish
    php artisan migrate
    
字段对应中文

            'province'=>'省份',
            'city'=>'地市',
            'zone'=>'区县',
            'province_unit'=>'省分公司',
            'city_unit'=>'地市公司',
            'site_code'=>'站点编码',
            'site_name'=>'站点名称',
            'site_nature'=>'站点性质',
            'scene'=>'建设场景',
            'property_code'=>'物业编码',
            'property_name'=>'物业名称',
            'contract_code'=>'合同编码',
            'contract_name'=>'合同名称',
            'contract_type'=>'合同类型',
            'contract_attribute'=>'合同属性',
            'owner_name'=>'所属业主名称（甲方）',
            'common_code'=>'客商编号',
            'mobile'=>'联系方式',
            'certificate_number'=>'证件号码',
            'owner_belong_city_unit'=>'业主所属地市公司',
            'owner_type'=>'业主类型',
            'owner_certificate_type'=>'业主证件类型',
            'owner_certificate_number'=>'业主证件号码',
            'contract_part_B'=>'合同乙方',
            'contract_signed_at'=>'合同签订日期',
            'contract_start_at'=>'合同起始日期（原始）',
            'contract_pay_start_at'=>'合同支付（计提）起始日期',
            'contract_stop_at'=>'合同终止日期',
            'contract_record_at'=>'合同录入日期',
            'contract_total_money'=>'合同总金额',
            'agent'=>'经办人',
            'agent_department'=>'经办部门',
            'contract_status'=>'合同状态',
            'is_agency'=>'是否代持',
            'is_site_deleted'=>'站点是否删除',
            'last_updated_at'=>'最后修改时间',
            'house_lease_area'=>'房屋租赁面积（平方米）',
            'place_lease_area'=>'场地租赁面积（平方米）',
            'base_year_rent'=>'基本年租金(元/年)',
            'rent_pay_type'=>'租金支付方式',
            'rent_pay_cycle'=>'租金支付周期（月）',
            'rent_pay_first_at'=>'租金约定首次支付日期',
            'rent_collection_account'=>'租金收款账号',
            'rent_collection_username'=>'租金收款户名',
            'rent_belong_bank'=>'所属银行（租金收款）',
            'rent_belong_bank_detail'=>'租金收款银行',
            'rent_invoice_type'=>'租金票据类型',
            'is_agency_invoice'=>'我方代开票',
            'agency_rate'=>'代开票税点（%）',
            'electric_charge_unit_price'=>'电费单价（元/度）',
            'electric_charge_standard'=>'电价标准',
            'electric_charge_pay_method'=>'电费支付方式',
            'electric_charge_pay_cycle'=>'电费支付周期（月）',
            'electric_charge_pay_first_at'=>'电费约定首次支付日期',
            'electric_charge_collection_account'=>'电费收款账号',
            'electric_charge_collection_username'=>'电费收款户名',
            'electric_charge_belong_bank'=>'所属银行（电费收款）',
            'electric_charge_belong_bank_detail'=>'电费收款银行',
            'electric_charge_invoice_type'=>'电费票据类型',
            'cash_pledge'=>'押金金额（元）'