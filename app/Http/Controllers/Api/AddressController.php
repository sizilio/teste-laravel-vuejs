<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;

/**
 * Class AddressController
 * @package App\Http\Controllers\Api
 */
class AddressController extends Controller {

    /**
     * Lista todos dados
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $adresses = Address::all();

        return response()->json([
            'status' => true,
            'adresses' => $adresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Busca dados
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find (Request $request) {

        // Busca por cep
        // Se não encontrou na base local, solicita add um novo
        $cep = $request->get('cep');
        if (!empty($cep)) {
            $request->validate(['cep' => 'required|size:8']);
            $address = [$this->checkExistAddress($cep, true)];
        }

        // Busca fuzzy
        $logradouro = $request->get('logradouro');
        if (!empty($logradouro))
            $address = Address::whereFuzzy(function ($query) use ($request) {
                $query->orWhereFuzzy('logradouro', $request->get('logradouro'));
                $query->orWhereFuzzy('bairro', $request->get('logradouro'));
                $query->orWhereFuzzy('cidade', $request->get('logradouro'));
            })->get();

        // Return
        return response()->json([
            'status' => true,
            'message' => null,
            'address' => $address
        ], 200);
    }

    /**
     * Salva endereço
     *
     * @param AddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (Request $request) {

        // Valida e verifica se existe Cep
        $request->validate(['cep' => 'required|size:8']);
        $address = $this->checkExistAddress($request->get('cep'), true);

        // Return
        return response()->json([
            'status' => true,
            'message' => "Endereço criado com sucesso!",
            'address' => $address
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit (Address $address) {}

    /**
     * Edita endereço
     *
     * @param AddressRequest $request
     * @param Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update (AddressRequest $request, Address $address) {
        $address->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "Endereço atualizado com sucesso!",
            'address' => $address
        ], 200);
    }

    /**
     * Apaga endereço
     *
     * @param Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Address $address) {
        $address->delete();

        return response()->json([
            'status' => true,
            'message' => "Endereço excluído com sucesso!",
        ], 200);
    }

    /**
     * Busca endereço pelo cep em banco de dados externo
     *
     * @param $cep
     * @return false|mixed
     */
    public function getCep ($cep) {
        $url = "https://correioscep.vercel.app/api/cep/" . $cep;
        $json = @file_get_contents($url);
        if ($json !== false)
            return json_decode($json, true);
        else
            return false;
    }

    /**
     * Verifica se existe endereço
     * Se existe, retorna dados.
     * @param $cep
     * @return mixed
     */
    private function checkExistAddress ($cep, $create = false) {
        if ($address = Address::where('cep', $cep)->first()) return $address;
        else {
            if ($create) return $this->createAddress($cep);
            else return false;
        }
    }

    /**
     * Cria um novo endereço
     * @param $cep
     * @return mixed
     */
    private function createAddress ($cep) {
        $data = $this->getCep($cep);
        $data['cep'] = $cep;
        return Address::create($data);
    }
}
