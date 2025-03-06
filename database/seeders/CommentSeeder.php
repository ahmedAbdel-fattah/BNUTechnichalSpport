<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::insert([
            [
                'ticket_id' => 1,
                'user_id' => 3,
                'comment_text' => 'الإنترنت لا يعمل منذ الصباح، برجاء المساعدة.',
            ],
            [
                'ticket_id' => 1,
                'user_id' => 2,
                'comment_text' => 'نحن نحقق في مشكلتك، وسنعود إليك قريبًا.',
            ],
            [
                'ticket_id' => 2,
                'user_id' => 3,
                'comment_text' => 'سرعة الإنترنت بطيئة جدًا أثناء ساعات العمل.',
            ],
            [
                'ticket_id' => 2,
                'user_id' => 2,
                'comment_text' => 'يرجى تزويدنا بمزيد من التفاصيل حول سرعة الاتصال.',
            ],
            [
                'ticket_id' => 3,
                'user_id' => 3,
                'comment_text' => 'الجهاز لا يعمل بعد تحديث النظام.',
            ],
            [
                'ticket_id' => 3,
                'user_id' => 2,
                'comment_text' => 'تم استلام المشكلة، سنقوم بمراجعة الجهاز.',
            ],
            [
                'ticket_id' => 4,
                'user_id' => 3,
                'comment_text' => 'الطابعة لا تستجيب للطباعة منذ أمس.',
            ],
            [
                'ticket_id' => 4,
                'user_id' => 2,
                'comment_text' => 'يرجى التأكد من توصيل الطابعة بشكل صحيح.',
            ],
            [
                'ticket_id' => 5,
                'user_id' => 3,
                'comment_text' => 'بعد تحديث الويندوز، تعريف كرت الشاشة لم يعد يعمل.',
            ],
            [
                'ticket_id' => 5,
                'user_id' => 2,
                'comment_text' => 'يرجى محاولة إعادة تثبيت التعريفات الخاصة بكرت الشاشة.',
            ],
            [
                'ticket_id' => 6,
                'user_id' => 3,
                'comment_text' => 'تم تثبيت تعريف الطابعة لكنه لا يعمل بشكل صحيح.',
            ],
            [
                'ticket_id' => 6,
                'user_id' => 2,
                'comment_text' => 'قد يكون هناك إصدار أحدث لتعريف الطابعة، سنوافيك بالتفاصيل.',
            ],
            [
                'ticket_id' => 7,
                'user_id' => 3,
                'comment_text' => 'أواجه مشكلة في تسجيل الدخول إلى النظام باستخدام بياناتي.',
            ],
            [
                'ticket_id' => 7,
                'user_id' => 2,
                'comment_text' => 'تم حل مشكلة تسجيل الدخول، يرجى المحاولة الآن.',
            ],
            [
                'ticket_id' => 8,
                'user_id' => 3,
                'comment_text' => 'لم يتم استلام المعدات الجديدة حتى الآن رغم تأكيد الطلب.',
            ],
            [
                'ticket_id' => 8,
                'user_id' => 2,
                'comment_text' => 'المعدات في طريقها إليك، وسيتم استلامها قريبًا.',
            ],
            [
                'ticket_id' => 9,
                'user_id' => 3,
                'comment_text' => 'السيرفرات تحتاج إلى صيانة دورية لمنع حدوث أعطال مفاجئة.',
            ],
            [
                'ticket_id' => 9,
                'user_id' => 2,
                'comment_text' => 'نوصي بجدولة صيانة دورية للسيرفرات لتجنب الأعطال.',
            ],
            [
                'ticket_id' => 10,
                'user_id' => 3,
                'comment_text' => 'إشارة الواي فاي غير مستقرة وتقطع بشكل متكرر.',
            ],
            [
                'ticket_id' => 10,
                'user_id' => 2,
                'comment_text' => 'تم إعادة ضبط الشبكة، يرجى التحقق من الاتصال مرة أخرى.',
            ],
        ]);

    }
}
