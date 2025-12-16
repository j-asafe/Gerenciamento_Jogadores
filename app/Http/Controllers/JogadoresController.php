<?php

namespace App\Http\Controllers;

use App\Models\Jogador;
use Illuminate\Http\Request;

class JogadoresController extends Controller
{
    // Listar todos os jogadores
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Jogador::all()
        ]);
    }

    // Cadastrar um jogador
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'idade' => 'required|integer',
            'posicao' => 'required|string',
            'nacionalidade' => 'required|string',
            'time' => 'required|string'
        ]);

        $jogador = Jogador::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Jogador cadastrado com sucesso',
            'data' => $jogador
        ], 201);
    }

    // Exibir um jogador específico
    public function show($id)
    {
        $jogador = Jogador::find($id);
        if (!$jogador) {
            return response()->json([
                'success' => false,
                'message' => 'Jogador não encontrado'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $jogador
        ]);
    }

    // Atualizar um jogador
    public function update(Request $request, $id)
    {
        $jogador = Jogador::find($id);
        if (!$jogador) {
            return response()->json([
                'success' => false,
                'message' => 'Jogador não encontrado'
            ], 404);
        }

        $request->validate([
            'nome' => 'sometimes|required|string',
            'idade' => 'sometimes|required|integer',
            'posicao' => 'sometimes|required|string',
            'nacionalidade' => 'sometimes|required|string',
            'time' => 'sometimes|required|string'
        ]);

        $jogador->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Jogador atualizado com sucesso',
            'data' => $jogador
        ]);
    }

    // Deletar um jogador
    public function destroy($id)
    {
        $jogador = Jogador::find($id);
        if (!$jogador) {
            return response()->json([
                'success' => false,
                'message' => 'Jogador não encontrado'
            ], 404);
        }

        $jogador->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jogador deletado com sucesso'
        ]);
    }
}
