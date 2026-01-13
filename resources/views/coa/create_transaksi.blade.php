@section('js')
    <script type="text/javascript">
        

        $(document).ready(function(){
            fetch_data_coa();
            function fetch_data_coa(query = '')
            {
                $.ajax({
                    url:'{{ route("coa_transaction/action_coa.actionCoa") }}',
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#lookup_coa tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search_coa', function(){
                var query = $(this).val();
                fetch_data_coa(query);
            });
        });

        $(document).ready(function(){
            fetch_data_coa_kredit();
            function fetch_data_coa_kredit(query = '')
            {
                $.ajax({
                    url:'{{ route("coa_transaction_kredit/action_coa_kredit.actionCoaKredit") }}',
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#lookup_coa_kredit tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search_coa_kredit', function(){
                var query = $(this).val();
                fetch_data_coa_kredit(query);
            });
        });

        $(document).ready(function(){
            var addButton_debet = $('#add_button_debet'); 
            var wrapper_debet = $('.field_wrapper_debet'); 
            var d_x = 1; 
            $(addButton_debet).click(function(){
                 d_x++;
                 $(wrapper_debet).append('<div class="form-group add"><div class="row"><div class="col-md-2"><input class="form-control" type="text" name="kode_coa[]" id="kode_coa_'+d_x+'" placeholder="DEBET" value="" readonly></div><div class="col-md-4"><div class="input-group"><input class="form-control" type="text" name="coa[]" id="coa_'+d_x+'" placeholder="DEBET" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-warning" data-toggle="modal" data-target="#myModalCoa"> <span class="fa fa-search"></span></button></span></div></div><div class="col-md-1" ><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="nav-icon icon-trash"></i></a></div></div></div>'); 
            });

            var d_y = 1;
            $('#lookup_coa').on('click', 'tbody tr', function(e){
                if(d_y=d_x){
                    e.preventDefault();
                    $('#kode_coa_'+d_y+'').val($(this).find('td').html());
                    $('#coa_'+d_y+'').val($(this).find('td').next().next().next().next().html());
        
                    $('#myModalCoa').modal('hide'); 
                }else{
                    d_y++;
                    e.preventDefault();
                    $('#kode_coa_'+d_y+'').val($(this).find('td').html());
                    $('#coa_'+d_y+'').val($(this).find('td').next().next().next().next().html());
            
                    $('#myModalCoa').modal('hide'); 
                }
            });

            $(wrapper_debet).on('click', '.remove_button', function(e){
                if (confirm("Are you sure you want to delete this line?")) {
                    e.preventDefault();
                    $(this).parent('').parent('').remove(); 
                    d_x--; 
                }
             });
        });



        $(document).ready(function(){
            var addButton_kredit = $('#add_button_kredit'); 
            var wrapper_kredit = $('.field_wrapper_kredit'); 
            var k_x = 1; 
            $(addButton_kredit).click(function(){
                 k_x++;
                 $(wrapper_kredit).append('<div class="form-group add"><div class="row"><div class="col-md-5 mb-2"></div><div class="col-md-2"><input class="form-control" type="text" name="kode_coa_kredit[]" id="kode_coa_kredit_'+k_x+'" placeholder="CREDIT" value="" readonly></div><div class="col-md-4"><div class="input-group"><input class="form-control" type="text" name="coa_kredit[]" id="coa_kredit_'+k_x+'" placeholder="CREDIT" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-warning" data-toggle="modal" data-target="#myModalCoa_kredit"> <span class="fa fa-search"></span></button></span></div></div><div class="col-md-1" ><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="nav-icon icon-trash"></i></a></div></div></div>'); 
            });

            var k_y = 1;
            $('#lookup_coa_kredit').on('click', 'tbody tr', function(e){
                if(k_y=k_x){
                    e.preventDefault();
                    $('#kode_coa_kredit_'+k_y+'').val($(this).find('td').html());
                    $('#coa_kredit_'+k_y+'').val($(this).find('td').next().next().next().next().html());
        
                    $('#myModalCoa_kredit').modal('hide'); 
                }else{
                    k_y++;
                    e.preventDefault();
                    $('#kode_coa_kredit_'+k_y+'').val($(this).find('td').html());
                    $('#coa_kredit_'+k_y+'').val($(this).find('td').next().next().next().next().html());
            
                    $('#myModalCoa_kredit').modal('hide'); 
                }
            });

            $(wrapper_kredit).on('click', '.remove_button', function(e){
                if (confirm("Are you sure you want to delete this line?")) {
                    e.preventDefault();
                    $(this).parent('').parent('').remove(); 
                    k_x--; 
                }
             });
        });


        $('#savedatas').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("coa_transaction.store") }}',
                type: 'POST',
                data: $(this).serializeArray(),
                success: function(data){
                    console.log(data);
                }
            });
        });

    </script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Add New COA Transaction</title>
    
    
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">COA Transaction</li>
        <li class="breadcrumb-item active">Add New COA Transaction</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('coa_transaction.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Add New COA Transaction
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Code
                                        <input type="text" name="kode" class="form-control" value=" {{ $no_urut }}" style="text-align: center;" required readonly>
                                    </div>

                                    <div class="col-md-10 mb-2">
                                        Account Description
                                        <input type="text" name="account_desc" class="form-control" value="" required>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <form id="savedatas">
                                <div class="card-body">
                                    <div class="field_wrapper_debet">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <input id="kode_coa_1" type="text" class="form-control" name="kode_coa[]" placeholder="DEBET" value="" required readonly>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group">
                                                    <input id="coa_1" type="text" class="form-control" name="coa[]" placeholder="DEBET" readonly required>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-warning" data-toggle="modal" data-target="#myModalCoa"> <span class="fa fa-search"></span></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <a class="btn btn-primary" href="javascript:void(0);" id="add_button_debet" title="Add field">+</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field_wrapper_kredit">
                                        <div class="row">
                                            <div class="col-md-5 mb-2">
                                       
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <input id="kode_coa_kredit_1" type="text" class="form-control" name="kode_coa_kredit[]" placeholder="CREDIT" value="" required readonly>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group">
                                                    <input id="coa_kredit_1" type="text" class="form-control" name="coa_kredit[]" placeholder="CREDIT" readonly required>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-warning" data-toggle="modal" data-target="#myModalCoa_kredit"> <span class="fa fa-search"></span></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-1 mb-2" >
                                                <a class="btn btn-primary" href="javascript:void(0);" id="add_button_kredit" title="Add field">+</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-2" align="right">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success">Save</button>
                                        </div>   
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModalCoa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_coa" id="search_coa" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_coa" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Account Lvl 1</th>
                                <th>Account Lvl 2</th>
                                <th>Account Lvl 3</th>
                                <th>Account Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModalCoa_kredit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_coa_kredit" id="search_coa_kredit" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_coa_kredit" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Account Lvl 1</th>
                                <th>Account Lvl 2</th>
                                <th>Account Lvl 3</th>
                                <th>Account Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection