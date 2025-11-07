<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yethee\Tiktoken\EncoderProvider;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    private EncoderProvider $provider;

    public function __construct()
    {
        $this->provider = new EncoderProvider();
    }

    public function count(Request $request): JsonResponse
    {
        $model = $request->input("model");
        $text = $request->input("text");

        if (empty($model) || empty($text)) {
            return response()->json(
                [
                    "error" => "Parâmetros obrigatórios: 'model', 'text'",
                ],
                400,
            );
        }

        try {
            $encoder = $this->provider->getForModel($model);
            $tokens = $encoder->encode($text);

            return response()->json([
                "tokens" => \count($tokens),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "error" => "Falha na contagem de tokens.",
                    "details" => $e->getMessage(),
                ],
                400,
            );
        }
    }
}
