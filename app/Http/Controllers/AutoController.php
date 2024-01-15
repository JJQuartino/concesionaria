<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Imagen;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/**
 * Class AutoController
 * @package App\Http\Controllers
 */
class AutoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect the user after authentication.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return $this->index();
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autos = Auto::paginate(10);

        return view('auto.index', compact('autos'))
            ->with('i', (request()->input('page', 1) - 1) * $autos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auto = new Auto();
        return view('auto.create', compact('auto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Auto::$rules);
        
        $auto = Auto::create($request->all());
        $id = DB::select('SELECT id FROM autos ORDER BY id DESC LIMIT 1'); 
        $orden = 1; 
        foreach ($request->imagenes as $imagen)
        {
            $img = Image::make($imagen->path());
            $img->save( storage_path().'/app/public/images/'.$imagen->hashName());
            DB::insert('INSERT INTO imagenes (id, idAuto, orden, path) values (?,?,?,?)', [0, $id[0]->id, $orden, $imagen->hashName()]);
            $orden++;
        }
        
        return redirect()->route('autos.index')
            ->with('success', 'Auto created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auto = Auto::find($id);
        $fotos = DB::select("SELECT path FROM imagenes WHERE idAuto = $id ORDER BY orden");
        return view('detalle', compact('auto', 'fotos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auto = Auto::find($id);
        $fotos = DB::select("SELECT path, id FROM imagenes WHERE idAuto = $id ORDER BY orden");
        return view('auto.edit', compact('auto','fotos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Auto $auto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auto $auto)
    {
        if($request->orden != "...")
            $this->reorderPhotos($request->orden);

        request()->validate(Auto::$rules);

        $auto->update($request->all());

        return redirect()->route('autos.index')
            ->with('success', 'Auto updated successfully');
    }

    /**
     * Set a car to either active or inactive
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function setActive($id)
    {
        $auto = Auto::find($id);
        $auto->activo = !$auto->activo;
        $auto->save();
    }

    /**
     * Replace a photo with a new one
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request)
    {
        try{
            $imagen = $request->imagen;
            $id = $request->id;
            //Traemos el path viejo y borramos la imagen a reemplazar
            $oldPath = Imagen::select('path')->where('id', '=', $id)->get();
            Storage::delete(storage_path().'/app/public/images/'.$oldPath[0]->path);

            //Creamos la nueva imagen, la guardamos y actualizamos la BBDD
            $img = Image::make($imagen->path());
            $newPath = $imagen->hashName();
            $img->save( storage_path().'/app/public/images/'.$newPath);
            Imagen::where('id', '=', $id)->update(['path' => $newPath]);
            return response()->json(["status" => 200]);
        }catch(Exception $e){
            return $e;
        }
    }

    /**
     * Reorders photos according to the selected new order
     * 
     * @param string $orden
     */
    public function reorderPhotos($orden)
    {
        $orden = explode(',', $orden);
        foreach($orden as $nuevoOrden => $idFoto) { 
            $img = Imagen::find($idFoto);
            $img->orden = ++$nuevoOrden;
            $img->save();
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $auto = Auto::find($id)->delete();
        $imagenes = DB::select('SELECT path FROM imagenes WHERE idAuto = '.$id);
        foreach($imagenes as $imagen)
        {
            Storage::delete(storage_path().'/app/public/images/'.$imagen->path);
        }
        DB::delete('DELETE FROM imagenes WHERE idAuto = '.$id);
        return redirect()->route('autos.index')
            ->with('success', 'Auto deleted successfully');
    }

}
