<?php

use App\Action;
use Illuminate\Database\Seeder;

class FillActionsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Action::create([
            'name_ar' => 'انشاء فاتورة',
            'name_en' => 'create invoice',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'استكمال فاتورة',
            'name_en' => 'complete invoice',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'استرجاع فاتورة',
            'name_en' => 'refund invoice',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'تسجيل فاتورة بتاريخ محدد',
            'name_en' => 'register invoice by specific date',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'حذف فاتورة',
            'name_en' => 'delete invoice',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'تعديل الدفع لفاتورة',
            'name_en' => 'edit payment for invoice',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'تعديل الدفع لفاتورة مستكملة',
            'name_en' => 'edit payment for completed invoice',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'حفظ وصفة الزبون',
            'name_en' => 'save customer prescription',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'تعديل بيانات الزبون',
            'name_en' => 'edit customer information',
            'type' => 'مبيعات',
        ]);
        Action::create([
            'name_ar' => 'اضافة مخزون',
            'name_en' => 'add stock',
            'type' => 'المخزون',
        ]);
        Action::create([
            'name_ar' => 'استيراد مخزون اكسل',
            'name_en' => 'import stock by excel',
            'type' => 'المخزون',
        ]);
        Action::create([
            'name_ar' => 'تعديل منتج',
            'name_en' => 'edit product',
            'type' => 'المخزون',
        ]);
        Action::create([
            'name_ar' => 'انشاء فاتورة مشتريات',
            'name_en' => 'create purchase invoice',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'دفع فاتورة مورد',
            'name_en' => 'pay supplier invoice',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'استرجاع فاتورة مشتريات',
            'name_en' => 'create purchase invoice',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'اضافة منتج مشتريات',
            'name_en' => 'add purchase product',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'تعديل مورد',
            'name_en' => 'edit supplier',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'حذف مورد',
            'name_en' => 'delete supplier',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'اضافة مورد',
            'name_en' => 'add supplier',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'تعديل منتج مشتريات',
            'name_en' => 'edit purchase product',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'تسجيل فاتورة مشتريات بتاريخ محدد',
            'name_en' => 'register purchase invoice by specific date',
            'type' => 'المشتريات',
        ]);
        Action::create([
            'name_ar' => 'اضافة اموال الى الصندوق',
            'name_en' => 'add money to cashier',
            'type' => 'الكاشير',
        ]);
        Action::create([
            'name_ar' => 'سحب اموال من الصندوق',
            'name_en' => 'withdraw money from cashier',
            'type' => 'الكاشير',
        ]);
        Action::create([
            'name_ar' => 'اغلاق الكاشير',
            'name_en' => 'close cashier',
            'type' => 'الكاشير',
        ]);
    }
}
