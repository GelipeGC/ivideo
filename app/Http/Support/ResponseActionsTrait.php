<?php

namespace App\Http\Support;

trait ResponseActionsTrait
{
   /**
    * Get the response for a successful general created.
    *
    * @param  string $status
    * @param  string $message
    * @param  integer $code
    * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    * */
   public function sendSuccessfullyResponse($status, $message,$code, $data = []){
       return response()->json([$status => true, "message" => $message, "data" => $data], $code);
   }

   /**
    * Get the response for a failed general Create.
    *
    * @param  string $status
    * @param  string $message
    * @param  integer $code
    * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    */
   public function sendFailedResponse($status, $message, $code){
       return response()->json([$status => false, "message" => $message], $code);
   }
}
