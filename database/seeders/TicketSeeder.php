<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run()
    {
        Ticket::insert([
            [
                'user_id' => 4,
                'category_id' => 1,
                'department_id' => 2,
                'title' => 'انقطاع الإنترنت في المكتب الرئيسي',
                'description' => 'الإنترنت لا يعمل منذ الصباح، برجاء المساعدة.',
                'priority' => 'high',
                'status' => 'open',
            ],
            [
                'user_id' => 5,
                'category_id' => 1,
                'department_id' => 3,
                'title' => 'بطء الاتصال بالإنترنت',
                'description' => 'سرعة الإنترنت بطيئة جدًا أثناء ساعات العمل.',
                'priority' => 'medium',
                'status' => 'open',
            ],
            [
                'user_id' => 6,
                'category_id' => 2,
                'department_id' => 4,
                'title' => 'الجهاز لا يعمل بعد تحديث النظام',
                'description' => 'بعد تحديث النظام، لم يعد الجهاز يعمل بشكل صحيح.',
                'priority' => 'high',
                'status' => 'open',
            ],
            [
                'user_id' => 7,
                'category_id' => 2,
                'department_id' => 5,
                'title' => 'تعطل الطابعة الرئيسية',
                'description' => 'الطابعة لا تستجيب للطباعة منذ أمس.',
                'priority' => 'medium',
                'status' => 'open',
            ],
            [
                'user_id' => 8,
                'category_id' => 3,
                'department_id' => 6,
                'title' => 'عدم توافق تعريف كرت الشاشة',
                'description' => 'بعد تحديث الويندوز، تعريف كرت الشاشة لم يعد يعمل.',
                'priority' => 'high',
                'status' => 'closed',
            ],
            [
                'user_id' => 9,
                'category_id' => 3,
                'department_id' => 7,
                'title' => 'مشكلة في تعريف الطابعة',
                'description' => 'تم تثبيت تعريف الطابعة لكنه لا يعمل بشكل صحيح.',
                'priority' => 'medium',
                'status' => 'open',
            ],
            [
                'user_id' => 7,
                'category_id' => 4,
                'department_id' => 5,
                'title' => 'عدم إمكانية تسجيل الدخول إلى النظام',
                'description' => 'أواجه مشكلة في تسجيل الدخول إلى النظام باستخدام بياناتي.',
                'priority' => 'high',
                'status' => 'closed',
            ],
            [
                'user_id' => 4,
                'category_id' => 4,
                'department_id' => 2,
                'title' => 'مشكلة في استلام المعدات الجديدة',
                'description' => 'لم يتم استلام المعدات الجديدة حتى الآن رغم تأكيد الطلب.',
                'priority' => 'medium',
                'status' => 'open',
            ],
            [
                'user_id' => 5,
                'category_id' => 2,
                'department_id' => 3,
                'title' => 'مشكلة في صيانة السيرفرات',
                'description' => 'السيرفرات تحتاج إلى صيانة دورية لمنع حدوث أعطال مفاجئة.',
                'priority' => 'high',
                'status' => 'open',
            ],
            [
                'user_id' => 6,
                'category_id' => 1,
                'department_id' => 4,
                'title' => 'عدم استقرار الشبكة اللاسلكية',
                'description' => 'إشارة الواي فاي غير مستقرة وتقطع بشكل متكرر.',
                'priority' => 'medium',
                'status' => 'closed',
            ],
        ]);
    }
}