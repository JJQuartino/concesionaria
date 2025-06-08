<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auto;
use App\Models\Imagen;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param string $input
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pagina = $request->page ?? 1;
        $paginados = $request->cantidad ?? 12;
        $resultados = 12 * $pagina;

        $marca = $request->marca ?? null;
        $precio = $request->precio ? explode('-',$request->precio) : null;

        $kilometros = $request->kilometros ? explode('-',$request->kilometros) : null;
        if(!$kilometros) Session::put('filtradoKilometros', -1);

        $año = $request->año ? $request->año : null;
        
        $columna = null;
        $orden = null;
        
        if($request->ordenar)
        {
            if(str_contains($request->ordenar, "p") || str_contains($request->ordenar, "k") && str_contains($request->ordenar, "Mam") || str_contains($request->ordenar, "maM")){
                $columna = str_contains($request->ordenar, "p") ? "precio" : "kilometros";
                $orden = str_contains($request->ordenar, "Mam") ? "DESC" : "ASC";
            }
        }

        $query = Auto::select()->selectSub(function ($tmp) {
            $tmp->select('path')->from('imagenes')->whereColumn('idAuto', 'autos.id')->orderBy('orden')->limit(1);
        }, 'foto')
        ->when($marca, function ($tmp, $marca){
            $tmp->where('marca', 'LIKE', '%'.$marca.'%');
        })
        ->when($precio, function ($tmp, $precio){
            $tmp->whereRaw('CAST(precio AS DECIMAL) BETWEEN ? AND ?',[$precio[0],$precio[1]]);
        })
        ->when($kilometros, function ($tmp, $kilometros){
            $tmp->whereRaw('CAST(kilometros AS DECIMAL) BETWEEN ? AND ?',[$kilometros[0],$kilometros[1]]);
        })
        ->when($año, function ($tmp, $año){
            $tmp->where('año', '=', $año);
        })
        ->when($columna && $orden, function($tmp) use ($columna, $orden){
            $tmp->orderByRaw('CAST('.$columna.' AS DECIMAL) '.$orden);
        })
        ->where('activo', 1);
        
        $total = $query->count();
        $precios = $query->get();
        $marcas = $this->getMarcas($marca, $precio, $kilometros, $año);
        $kilometros = $query->get();
        $autos = $query->paginate($paginados);
        $años = Auto::select('año')->distinct()->orderBy('año')->get();

        if($total < $resultados){
            $resultados = $total;
        }

        if($total > 4)
        {    
            $precios = $this->getRangos($precios, "precio");
            $kilometros = $this->getRangos($kilometros, "kilometros");
        }

        $autos->appends(['marca' => $marca, 'precio' => $request->precio, 'kilometros' => $request->kilometros, 'ordenar' => $request->ordenar]);

        return view('cars', compact('autos', 'marcas','resultados','total','precios', 'kilometros', 'años'));
    }

    /**
     * 
     */
    private function getByPrecio($precios)
    {
        $autos = Auto::select('id')->whereBetween('precio', $precios)->get();
        $ids = [];

        foreach($autos as $auto)
            $ids[] = $auto->id;

        return $ids;
    }

    /**
     * Devuelve los ids de los autos según lo buscado
     * 
     * @param string $marca
     * @return array
     */
    private function getByMarca($marca)
    {
        $autos = Auto::select('id','marca', 'modelo')->where('activo', 1)->get();
        $ids = [];
        $marca = strtolower($marca);
        foreach($autos as $auto){
            $test = strtolower($auto->marca." ".$auto->modelo);
            if(str_contains($test, $marca))
                $ids[] = $auto->id;
        }
        return $ids;
    }

    /**
     * Trae las marcas
     * 
     * @param string $marca
     * @param array  $precios
     * @param string $kilometros
     * @param string $año
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getMarcas($marca = null, $precios = null, $kilometros = null, $año = null)
    {
        return Auto::select('marca', DB::raw('COUNT(marca) as cant'))
                    ->when($marca, function ($query, $marca) {
                        $query->whereIn('id',  $this->getByMarca($marca));
                    })
                    ->when($precios, function ($query, $precios) {
                        $query->whereRaw('CAST(precio AS DECIMAL) BETWEEN ? AND ?',[$precios[0],$precios[1]]);
                    })
                    ->when($kilometros, function ($query, $kilometros) {
                        $query->whereRaw('CAST(kilometros AS DECIMAL) BETWEEN ? AND ?',[$kilometros[0],$kilometros[1]]);
                    })
                    ->when($año, function ($query, $año) {
                        $query->where('año', '=', $año);
                    })
                    ->groupBy('marca')
                    ->get();
    }

    /**
     * Muestra el auto seleccionado
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detalle($id)
    {
        $auto = Auto::find($id);
        $fotos = Imagen::select("path")->where("idAuto","=", $id)->orderBy('orden')->get();
        $descripcion = str_replace(". ",".",$auto->descripcion);
        $descripcion = explode('.', $descripcion);
        return view("detalle", compact('auto', 'fotos', 'descripcion'));
    }
    
    /**
     * Devuelve los valores para armar los rangos de precios
     * 
     * @param Illuminate\Database\Eloquent\Collection $resultado
     * 
     * @return array
     */
    private function getPrecios($resultado)
    {
        $max = 0;
        $min = $resultado[0]->kilometros;
        
        foreach($resultado as $auto){
            if($auto->kilometros > $max) $max = $auto->kilometros;
            if($auto->kilometros < $min) $min = $auto->kilometros;
        }

        $prom = ($min + $max) / 2;
        $prom = (int)(ceil($prom / 1000000) * 1000000);

        $minProm = ($min + $prom) / 2;
        $minProm = (int)(ceil($minProm / 1000000) * 1000000);

        return [$min,$minProm,$prom,$max];
    }

    /**
     * Devuelve los valores para armar los rangos de precios
     * 
     * @param Illuminate\Database\Eloquent\Collection $resultado
     * 
     * @return array
     */
    private function getKilometros($resultado)
    {
        $max = 0;
        $min = $resultado[0]->kilometros;
        
        foreach($resultado as $auto){
            if($auto->kilometros > $max) $max = $auto->kilometros;
            if($auto->kilometros < $min) $min = $auto->kilometros;
        }
        
        $prom = round(($max - $min) / 3,2);
        $prom = (ceil($prom / 10000) * 10000);
        $minProm = $min + $prom;
        $prom = $min + $prom*2;

        $sesion = Session::get("filtradoKilometros") + 1;
        Session::put('filtradoKilometros', $sesion);
        return [$min,$minProm,$prom,$max];
    }

    /**
     * Devuelve los valores para armar los rangos de precios o kilómetros
     * 
     * @param Illuminate\Database\Eloquent\Collection $resultado
     * @param string $propiedad
     * 
     * @return array
     */
    private function getRangos($resultado, $propiedad)
    {
        $max = 0;
        $min = $resultado[0]->kilometros;
        
        foreach($resultado as $auto){
            if($auto->$propiedad > $max) $max = $auto->$propiedad;
            if($auto->$propiedad < $min) $min = $auto->$propiedad;
        }

        $factor = $propiedad == "precio" ? 1000000 : 10000;
        
        if($propiedad == "precio")
        {
            $prom = ($min + $max) / 2;
            $prom = (int)(ceil($prom / $factor) * $factor);
            $minProm = ($min + $prom) / 2;
            $minProm = (int)(ceil($minProm / $factor) * $factor);
        }
        else
        {
            $prom = round(($max - $min) / 3,2);
            $prom = (ceil($prom / $factor) * $factor);
            $minProm = $min + $prom;
            $prom = $min + $prom*2;
            $sesion = Session::get("filtradoKilometros") + 1;
            Session::put('filtradoKilometros', $sesion);
        }

        return [$min,$minProm,$prom,$max];
    }
}
