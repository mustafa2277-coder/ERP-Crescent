<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        ///$this->middleware('role:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        //return Carbon::today();
        $total=DB::table('sales')

                ->select(DB::raw("SUM(totalPrice) as todayTotal"),'sales.*')

                ->whereDate('sales.created_at',Carbon::today())

                ->get();
        //return $total[0]->todayTotal;

        $total1=DB::table('sales')

                ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')

                ->select(DB::raw("SUM(totalPrice) as todayTotal") )

                ->whereDate('sales.created_at',Carbon::today())

                ->where('user_warehouse.warehouse_id','7')

                ->get();
        $total2=DB::table('sales')

                ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')

                ->select(DB::raw("SUM(totalPrice) as todayTotal") )

                ->whereDate('sales.created_at',Carbon::today())

                ->where('user_warehouse.warehouse_id','8')

                ->get();
        $total3=DB::table('sales')

                ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')

                ->select(DB::raw("SUM(totalPrice) as todayTotal") )

                ->whereDate('sales.created_at',Carbon::today())

                ->where('user_warehouse.warehouse_id','10')

                ->get();
        // //return  $salesId;
        // $total=0;
        //     for( $i=0; $i<sizeof($salesId); $i++){
        //         //return $id;
        //         $salesDetail=DB::table('sale_details')->select(DB::raw("SUM(totalPrice) as total"))
        //                     ->where('sale_details.orderId',$salesId[$i]->id)
        //                     ->get();
        //         $total=$total+$salesDetail[0]->total;
        //     }

        // $salesId=DB::table('sales')->select('sales.id')->where('sales.done',null)->where('sales.token',null)->where('sales.employId',19)->whereDate('sales.created_at',Carbon::today())->get();
        // //return  $salesId;
        // $total1=0;
        //     for( $i=0; $i<sizeof($salesId); $i++){
        //         //return $id;
        //         $salesDetail=DB::table('sale_details')->select(DB::raw("SUM(totalPrice) as total"))
        //                     ->where('sale_details.orderId',$salesId[$i]->id)
        //                     ->get();
        //         $total1=$total1+$salesDetail[0]->total;
        //     }

        // $salesId=DB::table('sales')->select('sales.id')->where('sales.done',null)->where('sales.token',null)->where('sales.employId',20)->whereDate('sales.created_at',Carbon::today())->get();
        // //return  $salesId;
        // $total2=0;
        //     for( $i=0; $i<sizeof($salesId); $i++){
        //         //return $id;
        //         $salesDetail=DB::table('sale_details')->select(DB::raw("SUM(totalPrice) as total"))
        //                     ->where('sale_details.orderId',$salesId[$i]->id)
        //                     ->get();
        //         $total2=$total2+$salesDetail[0]->total;
        //     }

        // $salesId=DB::table('sales')->select('sales.id')->where('sales.done',null)->where('sales.token',null)->where('sales.employId',9)->whereDate('sales.created_at',Carbon::today())->get();
        // //return  $salesId;
        // $total3=0;
        //     for( $i=0; $i<sizeof($salesId); $i++){
        //         //return $id;
        //         $salesDetail=DB::table('sale_details')->select(DB::raw("SUM(totalPrice) as total"))
        //                     ->where('sale_details.orderId',$salesId[$i]->id)
        //                     ->get();
        //         $total3=$total3+$salesDetail[0]->total;
        //     }
        
        // $salesId=DB::table('sales')->select('sales.id')->where('sales.done',null)->where('sales.token',null)->where('sales.employId',11)->whereDate('sales.created_at',Carbon::today())->get();
        // //return  $salesId;
        // $total4=0;
        //     for( $i=0; $i<sizeof($salesId); $i++){
        //         //return $id;
        //         $salesDetail=DB::table('sale_details')->select(DB::raw("SUM(totalPrice) as total"))
        //                     ->where('sale_details.orderId',$salesId[$i]->id)
        //                     ->get();
        //         $total4=$total4+$salesDetail[0]->total;
        //     }
        return view('home',compact('total','total1','total2','total3'));
    }
    
    public function refreshToken()
    {
        return csrf_token();
    }
}
