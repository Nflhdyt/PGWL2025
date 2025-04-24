<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolylinesModel extends Model
{
    protected $table = 'polylines';
    protected $guarded = ['id'];

    public function geojson_polylines()
    {
        $polylines = $this
            ->select(DB::raw('id, st_asgeojson(geom) as geom, name, description, image,
            st_length(geom, true) as length_m, st_length(geom, true)/1000 as
            length_km, created_at, updated_at'))
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polylines as $pl) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($pl->geom),
                'properties' => [
                    'id' => $pl->id,
                    'name' => $pl->name,
                    'description' => $pl->description,
                    'image' => $pl->image,
                    'created_at' => $pl->created_at,
                    'updated_at' => $pl->updated_at,
                    'length_m' => $pl->length_m,
                    'length_km' => $pl->length_km,
                ],
            ];

            array_push($geojson['features'], $feature);


        }
        return $geojson;
    }
}
