<?php 

//     function testing(){
//         dd("testing");
//     }

if(!function_exists('messageError')){

    function messageError($messages){

        if(is_array($messages)){

            $responseError = '';
            foreach($messages as $key => $value){
                $responseError .= $key.": ".$value[0].", ";
                // $responseError = $key.": ".$value[0].",";
            }
            return response()->json($responseError,422);
        }

        throw new Exception("Message not array type");
    }
}

// class MessageError {
//     public static function message($message){
    
//         if(is_array($messages)){
            
//             $responseError = '';
//             foreach($messages as $key => $value){
//                 $responseError .= $key.": ".$value[0].", ";
//                 // $responseError = $key.": ".$value[0].",";
//             }
//         }

//         return response()->json([
//             'status' => 'error',
//             'message' => $responseError
//         ], 422);
//     }

// };


// ?>