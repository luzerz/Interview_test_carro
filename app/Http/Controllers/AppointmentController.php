<?php

namespace App\Http\Controllers;

use App\Workshop;
use Illuminate\Database\Schema\Builder;
use Illuminate\Http\Request;
use App\Appointment;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $from = $request->start_time;
        $to = $request->end_time;
        $status = "400";
        $data =  Appointment::where('workshop_id',$request->workshop_id)
            ->where('start_time', '<=', $to)
            ->where('end_time', '>=', $from)
            ->first();
        if($data == null) {
           $data = [
               'car_id' => $request->car_id,
               'workshop_id' => $request->workshop_id,
               'start_time' => $request->start_time,
               'end_time' => $request->end_time,
           ];

           $res = new Appointment($data);
           if ($res->save()) {
               $status = "200";
           }
        }

        return response()->json(
            [
                'status'=> $status
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data = Appointment::where('workshop_id',$id)->with(['workshop','car'])->get();
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function recommend(Request $request){

        $date = $request->availability;
        $data = Appointment::where('start_time', '<=', $date)
            ->where('end_time', '>=', $date)
            ->first();
        if($data == null){
            $time = Carbon::parse($date)->format('H:i');
            $data = Workshop::where('opening_time','<=',$time)
            ->where('closing_time','>=',$time)
            ->get();
        }
        $arr = [
            'status'=>200,
            'data'=>$data
        ];
        return response()->json($arr);
    }
}
