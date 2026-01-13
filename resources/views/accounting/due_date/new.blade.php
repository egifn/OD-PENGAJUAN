public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        // $this->validate($request, [
    
        // ]);

        // Acc_DueDate::create([
        //     'doc_id' => $request->get('docid'),
        //     'customer_id' => $request->get('cusid'),
        //     'customer_name' => $request->get('cusname'),
        //     'amount' => $request->get('amount'),
        //     'remain' => $request->get('remain'),
        //     'doc_date' => $request->get('doc_date'),
        //     'due_date' => $request->get('duedate'),
        //     'due_date_updated' => $request->get('due_date_new'),
        //     'id_user' => Auth::user()->id
        // ]);


        // $update_duedate = DB::connection('mysql_ta')->table('dms_ar_arinvoice')
        //                             ->select('dms_ar_arinvoice.szDocId')
        //                             ->Where('dms_ar_arinvoice.szDocId', $request->get('docid'))
        //                             ->update([
        //                                 'dtmDue' =>  $request->get('due_date_new')
        //                             ]);

        $datas=[];
        foreach ($request->input('szDocId') as $key => $value) {
            // $datas["idtype.{$key}"] = 'required';
            // $datas["kode_produk.{$key}"] = 'required'; 
            // $datas["qty.{$key}"] = 'required';
            // $datas["kode_divisi.{$key}"] = 'required';
            // $datas["description.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);

        if($validator->passes()){
            foreach ($request->input("szDocId") as $key => $value) {
                if($request->get("tanggal")[$key] != ''){
                     $data = new Acc_DueDate;

                    $data->doc_id = $request->get('szDocId')[$key];
                    $data->customer_id = $request->get("customer_id")[$key];
                    $data->customer_name = $request->get("customer_name")[$key];
                    $data->amount = $request->get("amount")[$key];
                    $data->remain = $request->get("remain")[$key];
                    $data->doc_date = $request->get("dtm_doc")[$key];
                    $data->due_date = $request->get("dtm_due")[$key];
                    $data->due_date_updated = $request->get("tanggal")[$key];
                    $data->kode_perusahaan = Auth::user()->kode_perusahaan; 
                    $data->id_user = Auth::user()->id;
                    $data->time_update = Carbon::now()->format('H:i:s');
                    $data->save();  

                    //update due_date DMS  
                    if(Auth::user()->kode_perusahaan == 'WPS'){
                        $update_duedate = DB::connection('mysql_ta')->table('dms_ar_arinvoice')
                                    ->select('dms_ar_arinvoice.szDocId')
                                    ->Where('dms_ar_arinvoice.szDocId', $request->get('szDocId')[$key])
                                    ->update([
                                        'dtmDue' =>  $request->get("tanggal")[$key]
                                    ]);
                    }elseif(Auth::user()->kode_perusahaan == 'LP'){
                        $update_duedate = DB::connection('mysql_tu')->table('dms_ar_arinvoice')
                                    ->select('dms_ar_arinvoice.szDocId')
                                    ->Where('dms_ar_arinvoice.szDocId', $request->get('szDocId')[$key])
                                    ->update([
                                        'dtmDue' =>  $request->get("tanggal")[$key]
                                    ]);
                    }elseif(Auth::user()->kode_perusahaan == 'TUA'){
                        $update_duedate = DB::connection('mysql_tua')->table('dms_ar_arinvoice')
                                    ->select('dms_ar_arinvoice.szDocId')
                                    ->Where('dms_ar_arinvoice.szDocId', $request->get('szDocId')[$key])
                                    ->update([
                                        'dtmDue' =>  $request->get("tanggal")[$key]
                                    ]);
                    }
                }
            }
        }


        $perusahaan_dms = DB::table('perusahaans')->get();
        $depo_dms = DB::table('depos')->get();

        $jt = DB::connection('mysql_ta')
                        ->table('dms_ar_arinvoice')
                        ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                        ->Where('dms_ar_arinvoice.szCustomerId', request()->customer)
                        ->Where('dms_ar_arinvoice.bClosed', 0)
                        ->get();

        return view ('accounting.due_date.index', compact('perusahaan_dms','depo_dms','jt'));
    }