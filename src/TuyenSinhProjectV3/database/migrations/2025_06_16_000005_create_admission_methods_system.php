<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tạo bảng phương thức xét tuyển
        Schema::create('admission_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên phương thức xét tuyển');
            $table->string('code', 20)->unique()->comment('Mã phương thức');
            $table->text('description')->nullable()->comment('Mô tả chi tiết');
            $table->boolean('requires_subject_combinations')->default(false)->comment('Có cần tổ hợp môn không');
            $table->boolean('is_active')->default(true)->comment('Trạng thái hoạt động');
            $table->integer('priority_order')->default(0)->comment('Thứ tự ưu tiên');
            $table->timestamps();
        });

        // Tạo bảng quan hệ ngành - phương thức xét tuyển
        Schema::create('major_admission_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('admission_method_id')->constrained('admission_methods')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['major_id', 'admission_method_id'], 'major_admission_method_unique');
        });

        // Tạo bảng điểm chuẩn theo năm
        Schema::create('admission_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('admission_method_id')->constrained('admission_methods')->onDelete('cascade');
            $table->foreignId('subject_combination_id')->nullable()->constrained('subject_combinations')->onDelete('cascade');
            $table->year('year')->comment('Năm tuyển sinh');
            $table->decimal('score', 4, 2)->comment('Điểm chuẩn');
            $table->timestamps();
            
            $table->unique(['major_id', 'admission_method_id', 'subject_combination_id', 'year'], 'admission_score_unique');
        });

        // Thêm các trường mới vào bảng majors
        Schema::table('majors', function (Blueprint $table) {
            $table->string('major_code', 20)->nullable()->after('name_major')->comment('Mã ngành');
            $table->text('introduction')->nullable()->comment('Giới thiệu ngành học');
            $table->text('job_opportunities')->nullable()->comment('Cơ hội việc làm');
            $table->text('post_graduation_opportunities')->nullable()->comment('Cơ hội sau đại học');
            $table->text('contact_info')->nullable()->comment('Thông tin liên hệ');
        });

        // Thêm dữ liệu mẫu cho phương thức xét tuyển
        DB::table('admission_methods')->insert([
            [
                'name' => 'Xét kết quả kỳ thi tốt nghiệp THPT',
                'code' => 'THPT',
                'description' => 'Xét tuyển dựa trên điểm thi tốt nghiệp THPT theo tổ hợp môn',
                'requires_subject_combinations' => true,
                'is_active' => true,
                'priority_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xét kết quả học tập THPT (Học bạ)',
                'code' => 'HOCBA',
                'description' => 'Xét tuyển dựa trên kết quả học tập 3 năm THPT',
                'requires_subject_combinations' => false,
                'is_active' => true,
                'priority_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xét Điểm ĐGNL HCM',
                'code' => 'DGNL_HCM',
                'description' => 'Xét tuyển dựa trên điểm Đánh giá năng lực Đại học Quốc gia TP.HCM',
                'requires_subject_combinations' => false,
                'is_active' => true,
                'priority_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xét Điểm Đánh giá đầu vào V-SAT',
                'code' => 'VSAT',
                'description' => 'Xét tuyển dựa trên điểm Vietnam Scholastic Assessment Test',
                'requires_subject_combinations' => false,
                'is_active' => true,
                'priority_order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->dropColumn([
                'major_code',
                'introduction',
                'job_opportunities', 
                'post_graduation_opportunities',
                'contact_info'
            ]);
        });
        
        Schema::dropIfExists('admission_scores');
        Schema::dropIfExists('major_admission_methods');
        Schema::dropIfExists('admission_methods');
    }
};
