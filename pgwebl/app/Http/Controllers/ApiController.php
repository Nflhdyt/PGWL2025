<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use App\Models\PolylinesModel;
use App\Models\PolygonsModel;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $point;
    protected $polyline;
    protected $polygon;

    public function __construct()
    {
        $this->point = new PointsModel();
        $this->polyline = new PolylinesModel();
        $this->polygon = new PolygonsModel();
    }

    public function points()
    {
        $points = $this->point->geojson_points();
        return response()->json($points);
    }

    public function polylines()
    {
        $polylines = $this->polyline->geojson_polylines();
        return response()->json($polylines, 200, [], JSON_NUMERIC_CHECK);
    }
    public function polygons()
    {
        $polygons = $this->polygon->geojson_polygons();
        return response()->json($polygons);
    }
}
