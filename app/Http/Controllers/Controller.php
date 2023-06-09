<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $M;

    public function index()
    {
        $collection = $this->M::all();
        return response()->json($collection);
    }

    public function show($id)
    {
        $record = $this->M::find($id);
        if (!$record) {
            return response()->json(['message' => 'Não encontrado'], 404);
        }
        return response()->json($record);
    }
     
    public function destroy($id)
    {
        $model = $this->M::find($id);
        if (!$model) {
            return response()->json(['message' => 'Não encontrado'], 404);
        }
        $model->delete();
        return response()->json(['message' => 'Removido com sucesso']);
    }
}
