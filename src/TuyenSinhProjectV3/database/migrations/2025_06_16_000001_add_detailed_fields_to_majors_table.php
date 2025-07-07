<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            // Thông tin tuyển sinh
            $table->decimal('admission_score', 4, 2)->nullable()->comment('Điểm chuẩn năm gần nhất');
            $table->string('admission_method')->nullable()->comment('Phương thức xét tuyển');
            $table->integer('admission_quota')->nullable()->comment('Chỉ tiêu tuyển sinh');
            $table->string('subject_combination')->nullable()->comment('Tổ hợp môn xét tuyển');
            
            // Thông tin chương trình đào tạo
            $table->integer('total_credits')->nullable()->comment('Tổng số tín chỉ');
            $table->decimal('training_duration', 3, 1)->nullable()->comment('Thời gian đào tạo (năm)');
            $table->string('degree_level')->nullable()->comment('Bậc đào tạo (Cử nhân, Kỹ sư, ...)');
            $table->string('training_mode')->nullable()->comment('Hình thức đào tạo (Chính quy, Liên thông, ...)');
            
            // Cơ hội nghề nghiệp
            $table->text('career_opportunities')->nullable()->comment('Cơ hội nghề nghiệp');
            $table->string('average_salary_range')->nullable()->comment('Mức lương trung bình');
            $table->text('job_positions')->nullable()->comment('Các vị trí công việc');
            
            // Thông tin liên hệ và hỗ trợ
            $table->string('contact_email')->nullable()->comment('Email liên hệ khoa');
            $table->string('contact_phone')->nullable()->comment('Số điện thoại liên hệ');
            $table->string('office_address')->nullable()->comment('Địa chỉ văn phòng khoa');
            $table->string('website_url')->nullable()->comment('Website của khoa');
            
            // Media và tài liệu
            $table->json('gallery_images')->nullable()->comment('Thư viện ảnh (JSON array)');
            $table->string('video_url')->nullable()->comment('Video giới thiệu');
            $table->string('brochure_url')->nullable()->comment('Link tài liệu brochure');
            
            // Thông tin bổ sung
            $table->text('special_requirements')->nullable()->comment('Yêu cầu đặc biệt');
            $table->text('facilities')->nullable()->comment('Cơ sở vật chất');
            $table->text('notable_achievements')->nullable()->comment('Thành tích nổi bật');
            $table->boolean('is_featured')->default(false)->comment('Ngành học nổi bật');
            $table->integer('priority_order')->default(0)->comment('Thứ tự ưu tiên hiển thị');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->dropColumn([
                'admission_score',
                'admission_method', 
                'admission_quota',
                'subject_combination',
                'total_credits',
                'training_duration',
                'degree_level',
                'training_mode',
                'career_opportunities',
                'average_salary_range',
                'job_positions',
                'contact_email',
                'contact_phone',
                'office_address',
                'website_url',
                'gallery_images',
                'video_url',
                'brochure_url',
                'special_requirements',
                'facilities',
                'notable_achievements',
                'is_featured',
                'priority_order'
            ]);
        });
    }
};
