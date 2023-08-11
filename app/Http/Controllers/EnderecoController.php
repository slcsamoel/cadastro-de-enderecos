<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnderecoRequest;
use App\Http\Requests\UpdateEnderecoRequest;
use App\Models\Endereco;
use App\Services\CepService;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $enderecos = Endereco::all()->toArray();
            return array_reverse($enderecos);
         } catch (\Throwable $th) {
            return response()->json(['status'=> 'error' , 'messege' => 'Erro ao buscar os endereços']);
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEnderecoRequest $request)
    {
        try {
              $endereco = new Endereco([
                'cep' => $request->cep,
                'logradouro' => $request->logradouro,
                'bairro' =>$request->bairro,
                'cidade'=> $request->cidade,
                'uf' =>  $request->uf
              ]);

              $endereco->save();
              return response()->json(['status'=> 'success' , 'messege' => 'Endereço Criado!']);

        } catch (\Throwable $th) {
            return response()->json(['status'=> 'error' , 'messege' => 'Erro ao salvar o endereço']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $endereco = Endereco::find($id);
            return response()->json($endereco);

        } catch (\Throwable $th) {
            return response()->json(['status'=> 'error' , 'messege' => 'Erro ao buscar o endereço']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEnderecoRequest $request, $endereco)
    {

        try {
            $enderecoUpdate = Endereco::find($endereco);
            $enderecoUpdate->update($request->all());
            return response()->json(['status'=> 'success' , 'messege' => 'Endereço alterado!']);

        } catch (\Throwable $th) {
            return response()->json(['status'=> 'error' , 'messege' => $th->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($endereco)
    {
        try {
            $enderecoDelete = Endereco::find($endereco);
            $enderecoDelete->delete();
            return response()->json(['status'=> 'success' , 'messege' => 'Endereço deletado!']);

        } catch (\Throwable $th) {

            return response()->json(['status'=> 'error' , 'messege' => 'Erro ao deletar o endereço']);

        }
    }

    /**
     *  Buscar endereço
     */

     public function search(Request $request)
     {

            $endereco = Endereco::where('cep', $request->cep)->get();
            if (count($endereco)>0){
                return response()->json($endereco);
            } else {
                $cepService = new  CepService();
                $endereco =  $cepService->getEnderecoByCep($request->cep);

                if($endereco != null){
                    //salvar no banco
                    $newEndreco = new Endereco;
                    $newEndreco->cep = $request->cep;
                    $newEndreco->logradouro =   $endereco['logradouro'];
                    $newEndreco->bairro = $endereco['bairro'];
                    $newEndreco->cidade = $endereco['localidade'];
                    $newEndreco->uf = $endereco['uf'];
                    $newEndreco->save();

                    $response = array(
                        $newEndreco
                    );

                    return response()->json($response);

                }else{
                    return response()->json(['status'=> 'error' , 'messege' => 'O Cep não foi encontrado!']);
                }

            }

     }




}
