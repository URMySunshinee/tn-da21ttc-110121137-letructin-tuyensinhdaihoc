<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $client = new Client();

        // Lấy tối đa 15 tin nhắn gần nhất của user này (nếu có ít hơn thì lấy tất cả)
        $history = DB::table('chat_ai')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get()
            ->reverse(); // Đảm bảo thứ tự từ cũ đến mới

        $messages = [];
        // Thêm system prompt ở đầu
        $messages[] = [
            'role' => 'system',
            'content' => 'Tôi là chuyên gia tư vấn ngành học cho sinh viên Đại học Trà Vinh. Tôi chỉ trả lời các câu hỏi liên quan đến ngành học, dựa trên sở thích, đam mê môn học hoặc đặc điểm phù hợp với từng ngành. Các câu hỏi ngoài phạm vi này, vui lòng hỏi lại cho đúng nội dung ngành học nhé! Bạn hãy nhớ nhắc lại rằng những ngành học này Đại Học Trà Vinh đang đào tạo nha'
        ];
        // Thêm lịch sử chat (nếu có)
        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg->type_message == 1 ? 'assistant' : 'user',
                'content' => $msg->message_content
            ];
        }
        // Thêm câu hỏi mới vào cuối
        $messages[] = [
            'role' => 'user',
            'content' => $request->input('content')
        ];

        $data = [
            'model' => '', // Thêm model bạn muốn sử dụng, ví dụ: 'gpt-3.5-turbo'
            'messages' => $messages
        ];

        try {
            $response = $client->post('', [ // URL của OpenAI API
                'json' => $data,
                'headers' => [
                    '' => '', // Thêm khóa API của bạn vào đây
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            DB::table('chat_ai')->insert([
                'user_id'         => Auth::user()->id,
                'message_content' => $request->input('content'),
                'type_message'    => 0,
            ]);
            DB::table('chat_ai')->insert([
                'user_id'         => Auth::user()->id,
                'message_content' => $data['choices'][0]['message']['content'],
                'type_message'    => 1,
            ]);

            return response()->json([
                'message' => $data['choices'][0]['message']['content']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error occurred while communicating with OpenAI API',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function loadMessage(){
         $dataMessage = DB::table('chat_ai')
        ->select('*')
        ->where('user_id', Auth::user()->id)
        ->orderBy('id','ASC')
        ->get();
        $data = json_decode($dataMessage, true);
        return response()->json([
                'dataMessage' => $data
            ]);
    }
    public function loadMessageAdmin($id){
         $dataMessage = DB::table('chat_ai')
        ->select('*')
        ->where('user_id', $id)
        ->orderBy('id','ASC')
        ->get();
        $data = json_decode($dataMessage, true);
        return response()->json([
                'dataMessage' => $data
            ]);
    }
}
