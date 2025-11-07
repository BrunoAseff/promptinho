<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yethee\Tiktoken\EncoderProvider;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    private EncoderProvider $provider;

    public function __construct(EncoderProvider $provider)
    {
        $this->provider = $provider;
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
            $decodedText = [];

            foreach ($tokens as $token) {
                $decodedText[] = $encoder->decode([$token]);
            }

            return response()->json([
                "count" => \count($tokens),
                "tokens" => $tokens,
                "decoded_text" => $decodedText,
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
