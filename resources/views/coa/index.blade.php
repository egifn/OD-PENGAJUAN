@extends('layouts.admin')

@section('title')
	<title>Chart Of Account (COA)</title>
    
    
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Chart Of Account</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Chart Of Account (COA)</h4>
                        </div>
                        <div class="card-body">
                          
                            <ul id="tree1">
                                @foreach($account_1 as $acc_1)
                                <li><a href="#"> 
                                    {{ $acc_1->kode_lv1 }} - {{ $acc_1->account_name }} <!-- Lv_1  -->

                                    <ul id="tree1">
                                        @foreach($acc_1->coa_2 as $acc_2)
                                        <li><a href="#">
                                            {{ $acc_2->kode_lv2 }} - {{ $acc_2->account_name }} <!-- Lv_2  -->

                                            <ul id="tree1">
                                                @foreach($acc_2->coa_3 as $acc_3)
                                                <li><a href="#">
                                                    {{ $acc_3->kode_lv3 }} - {{ $acc_3->account_name }} <!-- Lv_3  -->

                                                    <ul id="tree1">
                                                        @foreach($acc_3->coa_4 as $acc_4)
                                                        <li><a href="#">
                                                            {{ $acc_4->kode_lv4 }} - {{ $acc_4->account_name }} <!-- Lv_4  -->
                                                    
                                                        </a></li>
                                                        @endforeach
                                                    </ul>

                                                </a></li>
                                                @endforeach
                                            </ul>

                                        </a></li>
                                        @endforeach
                                    </ul>

                                </a></li>
                                @endforeach
                            </ul>
                            
                          
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</main>


@endsection