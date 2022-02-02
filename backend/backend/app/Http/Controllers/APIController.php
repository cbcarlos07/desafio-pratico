<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
class APIController extends Controller
{
    public function index()
    {
        //$array = ['msg' => 'Bem-vindo à API'];
        $array = Product::get();
        return response()->json( $array );
    }

    public function criar(Request $request)
    {        
        try {
            //code...
            $arquivo = $request->file('arquivo');
            $ext = $arquivo->getClientOriginalExtension();
            $retorno = [];
            if( $ext == 'csv'){
    
                $path = $arquivo->getRealPath();
                $data = array_map('str_getcsv', file($path));
                if( count($data) > 0 ){
                    if(count($data) > 1) {
                        $header = explode(";", $data[0][0]);
                        $itens = [];
                        for ($i = 0; $i < count($data) - 1; $i++) {
                            $body = explode(";", $data[$i + 1][0]); 
                            $item = [
                                $header[0] => $body[0],
                                $header[1] => $body[1],
                                $header[2] => $body[2],
                                $header[3] => $body[3],
                                $header[4] => $body[4],
                            ];
                            $itens[] = $item;
                        }
                        $csv_data = array_slice($data, 0, 2);
                        
                        $array = [
                                'nome' => $arquivo->getClientOriginalName(),
                                'ext' => $arquivo->getClientOriginalExtension(),
                                'tempPath' => $arquivo->getRealPath(),
                            ];
                        $products = Product::insert( $itens );
                            
                        //return response()->json( $itens );
                        $retorno =  ['status' => $products, 'msg' => 'Produtos salvos com sucesso!'];
                    }else{
                        $retorno = ['status' => false, 'msg' => 'É necessário ter pelo meno sum item'];        
                    }
                }else{
                    $retorno = ['status' => false, 'msg' => 'O arquivo está vazio'];
                }
            }else{
                $retorno = ['status' => false, 'msg' => 'O arquivo nao é csv'];
            }
            
            return response()->json( $retorno );
        } catch (\Throwable $th) {
            $retorno = ['msg' => 'Certifique que seu arquivo csv seja separado por ponto e vírgula', 'status', false];
            return response()->json( $retorno );
        }
        
    }

    public function editar($id, Request $request)
    {
        $product = Product::find( $id );
        $retorno = $product->update( $request->all() );
        $array= ['status'=> $retorno, 'msg' => 'Produto atualizado com sucesso!'];
        
        return response()->json( $array );
    }

    public function buscarPorId($id, Request $request)
    {
        $product = Product::find( $id );
        
        return response()->json( $product );
    }
    public function remover($id)
    {
        $product = Product::find( $id );
        $retorno = $product->delete(  );
        $array= ['status'=> $retorno, 'msg' => 'Produto removido com sucesso!'];
        
        return response()->json( $array );
    }
}
