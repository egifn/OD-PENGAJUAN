@section('js')
<script type="text/javascript">
    function goBack() {
        window.history.back();
    }

    // $('#savedatas').on('submit', function(e){
    //     e.preventDefault();
    //     $.ajax({
    //         url: '{{ route("pengajuan_masuk/view/Approved.approved") }}',
    //         type: 'post',
    //         data: $(this).serializeArray(),
    //         success: function(data){
    //             console.log(data);
    //         }
    //     });
    // });

    $(document).ready(function(){
        var sisa = $("#sisa_budget").val();
        
        if(document.getElementById('ket').value == 'Pembelian ATK'){
            ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
            var table = document.getElementById("tabelinput_1"), sumHsl = 0;
            for(var t = 1; t < table.rows.length; t++)
            {   
                var sub_total = table.rows[t].cells[17].children[0].value;
                //menghilangka format rupiah harga//
                var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                //End menghilangka format rupiah harga//

                sumHsl = sumHsl + parseInt(sub_total_hasil);
                sisa = sisa - parseInt(sub_total_hasil);
            }
            // $('#subtotal_harga').val(sumHsl);

            // //membuat format rupiah total//
            // var sumHsl_temp = sumHsl.toString().split('').reverse().join(''),
            //     ribuan  = sumHsl_temp.match(/\d{1,3}/g);
            //     hasil_sumHsl_temp = ribuan.join(',').split('').reverse().join('');
            // //End membuat format rupiah total//
            // $('#subtotal_harga_temp').val(hasil_sumHsl_temp);
            // ////END PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                
            //membuat format rupiah total//
            var temp_sisa = sisa.toString().split('').reverse().join(''),
                ribuan  = temp_sisa.match(/\d{1,3}/g);
                hasil_temp_sisa = ribuan.join(',').split('').reverse().join('');
            //End membuat format rupiah total//
            $(".f_budget").text('Budget: Rp. ' + hasil_temp_sisa + '');
            $("#sisa_budget").val(sisa);
        }
		
		var table = document.getElementById("tabelinput_1"), sumHsl = 0;
        for(var t = 1; t < table.rows.length; t++)
        {   
            var sub_total = table.rows[t].cells[17].children[0].value;
                
            //menghilangka format rupiah harga//
            var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
            var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
            //End menghilangka format rupiah harga//

            sumHsl = sumHsl + parseInt(sub_total_hasil);

            //membuat format rupiah total//
            var total_all = sumHsl.toString().split('').reverse().join(''),
            ribuan_total_all  = total_all.match(/\d{1,3}/g);
            hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
            //End membuat format rupiah total//
            $('#total_all').val(hasil_total_all);
        }
    });

    var x = 1;
    function input_ket(x) {
        if(x==1){
            var keterangan_detail = $("input[name='ket_detail[]1']").val();
                     
            if ($("input[name='chk[]1']:checked").val()){
                var ceklist = '1';
            }else{
                var ceklist = '0';
            }
            
            $('#ceklist_temp1').text(ceklist);
            $('#keterangan_temp1').text(keterangan_detail);
        }else{
            //x++;
            var keterangan_detail = $("input[name='ket_detail[]" +x+ "']").val();
                     
            if ($("input[name='chk[]" +x+ "']:checked").val()){
                var ceklist = '1';
            }else{
                var ceklist = '0';
            }

            $('#ceklist_temp' +x+ '').text(ceklist);
            $('#keterangan_temp' +x+ '').text(keterangan_detail);
        }
    }

    function jumlah_it(x) {
        var harga = ($("input[name='harga_satuan[]" +x+ "']").val());
       
        //menghilangka format rupiah harga//
        var temp_harga = harga.replace(/[.](?=.*?\.)/g, '');
        var temp_harga_jadi = parseInt(temp_harga.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//

        var jml = parseInt($("input[name='qty_it[]" +x+ "']").val());
        $('#qty_it_temp' + x + '').text(jml);
       
        var total = temp_harga_jadi*jml;
        //membuat format rupiah total//
        var total_rupiah = total.toString().split('').reverse().join(''),
                ribuan  = total_rupiah.match(/\d{1,3}/g);
                hasil_total_rupiah = ribuan.join(',').split('').reverse().join('');
        //End membuat format rupiah total//

        $("input[name='total_harga[]" +x+ "']").val(hasil_total_rupiah);
		
		if(document.getElementById('ket').value != 'Pembelian ATK'){
            ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
            var table = document.getElementById("tabelinput_1"), sumHsl = 0;
            for(var t = 1; t < table.rows.length; t++)
            {   
                var sub_total = table.rows[t].cells[17].children[0].value;
                
                //menghilangka format rupiah harga//
                var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                //End menghilangka format rupiah harga//

                sumHsl = sumHsl + parseInt(sub_total_hasil);

                //membuat format rupiah total//
                var total_all = sumHsl.toString().split('').reverse().join(''),
                ribuan_total_all  = total_all.match(/\d{1,3}/g);
                hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#total_all').val(hasil_total_all);

                budget_hasil = budget_hasil - parseInt(sub_total_hasil);
            }
        }

        //var f = $('#total_budget').val();
        var temp_budget = $('#total_budget').val();
        //menghilangka format rupiah harga//
        var budget_hilang_format = temp_budget.replace(/[.](?=.*?\.)/g, '');
        var budget_hasil = parseInt(budget_hilang_format.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//

        if(document.getElementById('ket').value == 'Pembelian ATK'){
            if(temp_budget < total){
                alert('Budget yang tersedia tidak cukup...');
                $("input[name='qty[]" +x+ "']").val(0);
                $("input[name='total_harga[]" +x+ "']").val(0);
            }else{
                ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                var table = document.getElementById("tabelinput_1"), sumHsl = 0;
                for(var t = 1; t < table.rows.length; t++)
                {   
                    var sub_total = table.rows[t].cells[17].children[0].value;
                    //menghilangka format rupiah harga//
                    var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                    var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah harga//

                    sumHsl = sumHsl + parseInt(sub_total_hasil);
                    budget_hasil = budget_hasil - parseInt(sub_total_hasil);
                }
                $('#subtotal_harga').val(sumHsl);

                //membuat format rupiah total//
                var sumHsl_temp = sumHsl.toString().split('').reverse().join(''),
                        ribuan  = sumHsl_temp.match(/\d{1,3}/g);
                        hasil_sumHsl_temp = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#subtotal_harga_temp').val(hasil_sumHsl_temp);
                ////END PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                
                //membuat format rupiah total//
                var sisa = budget_hasil.toString().split('').reverse().join(''),
                        ribuan  = sisa.match(/\d{1,3}/g);
                        hasil_sisa = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $(".f_budget").text('Budget: Rp. ' + hasil_sisa + '');
                $("#sisa_budget").val(budget_hasil);
                
            }

        }
    }

    function jumlah(x) {
        var harga = ($("input[name='harga_satuan[]" +x+ "']").val());
       
        //menghilangka format rupiah harga//
        var temp_harga = harga.replace(/[.](?=.*?\.)/g, '');
        var temp_harga_jadi = parseInt(temp_harga.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//

        var jml = parseInt($("input[name='qty_ops[]" +x+ "']").val());
        $('#qty_ops_temp' + x + '').text(jml);
        
        var total = temp_harga_jadi*jml;
        //membuat format rupiah total//
        var total_rupiah = total.toString().split('').reverse().join(''),
                ribuan  = total_rupiah.match(/\d{1,3}/g);
                hasil_total_rupiah = ribuan.join(',').split('').reverse().join('');
        //End membuat format rupiah total//

        $("input[name='total_harga[]" +x+ "']").val(hasil_total_rupiah);

        if(document.getElementById('ket').value != 'Pembelian ATK'){
            ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
            var table = document.getElementById("tabelinput_1"), sumHsl = 0;
            for(var t = 1; t < table.rows.length; t++)
            {   
                var sub_total = table.rows[t].cells[17].children[0].value;
                
                //menghilangka format rupiah harga//
                var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                //End menghilangka format rupiah harga//

                sumHsl = sumHsl + parseInt(sub_total_hasil);

                //membuat format rupiah total//
                var total_all = sumHsl.toString().split('').reverse().join(''),
                ribuan_total_all  = total_all.match(/\d{1,3}/g);
                hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#total_all').val(hasil_total_all);

                budget_hasil = budget_hasil - parseInt(sub_total_hasil);
            }
        }

        //var f = $('#total_budget').val();
        var temp_budget = $('#total_budget').val();
        //menghilangka format rupiah harga//
        var budget_hilang_format = temp_budget.replace(/[.](?=.*?\.)/g, '');
        var budget_hasil = parseInt(budget_hilang_format.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//

        if(document.getElementById('ket').value == 'Pembelian ATK'){
            if(temp_budget < total){
                alert('Budget yang tersedia tidak cukup...');
                $("input[name='qty[]" +x+ "']").val(0);
                $("input[name='total_harga[]" +x+ "']").val(0);
            }else{
                ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                var table = document.getElementById("tabelinput_1"), sumHsl = 0;
                for(var t = 1; t < table.rows.length; t++)
                {   
                    var sub_total = table.rows[t].cells[17].children[0].value;
                    //menghilangka format rupiah harga//
                    var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                    var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah harga//

                    sumHsl = sumHsl + parseInt(sub_total_hasil);
                    
                    //membuat format rupiah total//
                    var total_all = sumHsl.toString().split('').reverse().join(''),
                            ribuan_total_all  = total_all.match(/\d{1,3}/g);
                            hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                    //End membuat format rupiah total//
                    $('#total_all').val(hasil_total_all);

                    budget_hasil = budget_hasil - parseInt(sub_total_hasil);
                }
                $('#subtotal_harga').val(sumHsl);

                //membuat format rupiah total//
                var sumHsl_temp = sumHsl.toString().split('').reverse().join(''),
                        ribuan  = sumHsl_temp.match(/\d{1,3}/g);
                        hasil_sumHsl_temp = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#subtotal_harga_temp').val(hasil_sumHsl_temp);
                ////END PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                
                //membuat format rupiah total//
                var sisa = budget_hasil.toString().split('').reverse().join(''),
                        ribuan  = sisa.match(/\d{1,3}/g);
                        hasil_sisa = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $(".f_budget").text('Budget: Rp. ' + hasil_sisa + '');
                $("#sisa_budget").val(budget_hasil);
            }

        }
    }

    function jumlah_ga(x) {
        var harga = ($("input[name='harga_satuan[]" +x+ "']").val());
       
        //menghilangka format rupiah harga//
        var temp_harga = harga.replace(/[.](?=.*?\.)/g, '');
        var temp_harga_jadi = parseInt(temp_harga.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//

        var jml = parseInt($("input[name='qty_ga[]" +x+ "']").val());
        $('#qty_ga_temp' + x + '').text(jml);
        
        var total = temp_harga_jadi*jml;
        //membuat format rupiah total//
        var total_rupiah = total.toString().split('').reverse().join(''),
                ribuan  = total_rupiah.match(/\d{1,3}/g);
                hasil_total_rupiah = ribuan.join(',').split('').reverse().join('');
        //End membuat format rupiah total//

        $("input[name='total_harga[]" +x+ "']").val(hasil_total_rupiah);

        if(document.getElementById('ket').value != 'Pembelian ATK'){
            ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
            var table = document.getElementById("tabelinput_1"), sumHsl = 0;
            for(var t = 1; t < table.rows.length; t++)
            {   
                var sub_total = table.rows[t].cells[17].children[0].value;
                
                //menghilangka format rupiah harga//
                var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                //End menghilangka format rupiah harga//

                sumHsl = sumHsl + parseInt(sub_total_hasil);

                //membuat format rupiah total//
                var total_all = sumHsl.toString().split('').reverse().join(''),
                ribuan_total_all  = total_all.match(/\d{1,3}/g);
                hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#total_all').val(hasil_total_all);

                budget_hasil = budget_hasil - parseInt(sub_total_hasil);
            }
        }

        //var f = $('#total_budget').val();
        var temp_budget = $('#total_budget').val();
        //menghilangka format rupiah harga//
        var budget_hilang_format = temp_budget.replace(/[.](?=.*?\.)/g, '');
        var budget_hasil = parseInt(budget_hilang_format.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//

        if(document.getElementById('ket').value == 'Pembelian ATK'){
            if(temp_budget < total){
                alert('Budget yang tersedia tidak cukup...');
                $("input[name='qty[]" +x+ "']").val(0);
                $("input[name='total_harga[]" +x+ "']").val(0);
            }else{
                ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                var table = document.getElementById("tabelinput_1"), sumHsl = 0;
                for(var t = 1; t < table.rows.length; t++)
                {   
                    var sub_total = table.rows[t].cells[17].children[0].value;
                    //menghilangka format rupiah harga//
                    var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                    var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah harga//

                    sumHsl = sumHsl + parseInt(sub_total_hasil);
                    
                    //membuat format rupiah total//
                    var total_all = sumHsl.toString().split('').reverse().join(''),
                            ribuan_total_all  = total_all.match(/\d{1,3}/g);
                            hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                    //End membuat format rupiah total//
                    $('#total_all').val(hasil_total_all);

                    budget_hasil = budget_hasil - parseInt(sub_total_hasil);
                }
                $('#subtotal_harga').val(sumHsl);

                //membuat format rupiah total//
                var sumHsl_temp = sumHsl.toString().split('').reverse().join(''),
                        ribuan  = sumHsl_temp.match(/\d{1,3}/g);
                        hasil_sumHsl_temp = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#subtotal_harga_temp').val(hasil_sumHsl_temp);
                ////END PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                
                //membuat format rupiah total//
                var sisa = budget_hasil.toString().split('').reverse().join(''),
                        ribuan  = sisa.match(/\d{1,3}/g);
                        hasil_sisa = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $(".f_budget").text('Budget: Rp. ' + hasil_sisa + '');
                $("#sisa_budget").val(budget_hasil);
            }

        }
    }

    function jumlah_pc(x) {
        var harga = ($("input[name='harga_satuan[]" +x+ "']").val());
       
        //menghilangka format rupiah harga//
        var temp_harga = harga.replace(/[.](?=.*?\.)/g, '');
        var temp_harga_jadi = parseInt(temp_harga.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//
       
        var jml = parseInt($("input[name='qty_prc[]" +x+ "']").val());
        $('#qty_prc_temp' + x + '').text(jml);
        
        var total = temp_harga_jadi*jml;
        //membuat format rupiah total//
        var total_rupiah = total.toString().split('').reverse().join(''),
                ribuan  = total_rupiah.match(/\d{1,3}/g);
                hasil_total_rupiah = ribuan.join(',').split('').reverse().join('');
        //End membuat format rupiah total//

        $("input[name='total_harga[]" +x+ "']").val(hasil_total_rupiah);

        if(document.getElementById('ket').value != 'Pembelian ATK'){
            ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
            var table = document.getElementById("tabelinput_1"), sumHsl = 0;
            for(var t = 1; t < table.rows.length; t++)
            {   
                var sub_total = table.rows[t].cells[17].children[0].value;
                
                //menghilangka format rupiah harga//
                var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                //End menghilangka format rupiah harga//

                sumHsl = sumHsl + parseInt(sub_total_hasil);

                //membuat format rupiah total//
                var total_all = sumHsl.toString().split('').reverse().join(''),
                ribuan_total_all  = total_all.match(/\d{1,3}/g);
                hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#total_all').val(hasil_total_all);

                budget_hasil = budget_hasil - parseInt(sub_total_hasil);
            }
        }

        //var f = $('#total_budget').val();
        var temp_budget = $('#total_budget').val();
        //menghilangka format rupiah harga//
        var budget_hilang_format = temp_budget.replace(/[.](?=.*?\.)/g, '');
        var budget_hasil = parseInt(budget_hilang_format.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//

        if(document.getElementById('ket').value == 'Pembelian ATK'){
            if(temp_budget < total){
                alert('Budget yang tersedia tidak cukup...');
                $("input[name='qty[]" +x+ "']").val(0);
                $("input[name='total_harga[]" +x+ "']").val(0);
            }else{
                ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                var table = document.getElementById("tabelinput_1"), sumHsl = 0;
                for(var t = 1; t < table.rows.length; t++)
                {   
                    var sub_total = table.rows[t].cells[17].children[0].value;
                    //menghilangka format rupiah harga//
                    var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                    var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah harga//

                    sumHsl = sumHsl + parseInt(sub_total_hasil);
                    
                    //membuat format rupiah total//
                    var total_all = sumHsl.toString().split('').reverse().join(''),
                            ribuan_total_all  = total_all.match(/\d{1,3}/g);
                            hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                    //End membuat format rupiah total//
                    $('#total_all').val(hasil_total_all);

                    budget_hasil = budget_hasil - parseInt(sub_total_hasil);

                }
                $('#subtotal_harga').val(sumHsl);

                //membuat format rupiah total//
                var sumHsl_temp = sumHsl.toString().split('').reverse().join(''),
                        ribuan  = sumHsl_temp.match(/\d{1,3}/g);
                        hasil_sumHsl_temp = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#subtotal_harga_temp').val(hasil_sumHsl_temp);
                ////END PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                
                //membuat format rupiah total//
                var sisa = budget_hasil.toString().split('').reverse().join(''),
                        ribuan  = sisa.match(/\d{1,3}/g);
                        hasil_sisa = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $(".f_budget").text('Budget: Rp. ' + hasil_sisa + '');
                $("#sisa_budget").val(budget_hasil);
            }
        }
    }

    $("#button_form_approved").click(function() {
        
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        let budget_sisa = $("#sisa_budget").val();
        
        let kode_produk = []
        let ceklist = []
        let keterangan_detail = []

        let qty_it = []
        let qty_ops = []
        let qty_ga = []
        let qty_prc = []
        let harga_satuan = []

        $('.kode_produk').each(function() {
            kode_produk.push($(this).text())
        })
        $('.ceklist_temp').each(function() {
            ceklist.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            keterangan_detail.push($(this).text())
        })

        $('.qty_it_temp').each(function() {
            qty_it.push($(this).text())
        })
        $('.qty_ops_temp').each(function() {
            qty_ops.push($(this).text())
        })
        $('.qty_ga_temp').each(function() {
            qty_ga.push($(this).text())
        })
        $('.qty_prc_temp').each(function() {
            qty_prc.push($(this).text())
        })
        $('.harga_satuan').each(function() {
            harga_satuan.push($(this).text())
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_masuk/view/Approved.approved') }}",
            data: {
                no_urut: no_urut,
                budget_sisa: budget_sisa,

                kode_produk: kode_produk,
                qty_it: qty_it, 
                qty_ops: qty_ops,
                qty_ga: qty_ga,
                qty_prc: qty_prc,
                harga_satuan: harga_satuan,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('pengajuan_masuk.index')}}";
                }else{

                }
            }
        });
    });

    $("#button_form_pending").click(function() {
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        
        let kode_produk = []
        let ceklist = []
        let keterangan_detail = []

        $('.kode_produk').each(function() {
            kode_produk.push($(this).text())
        })
        $('.ceklist_temp').each(function() {
            ceklist.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            keterangan_detail.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_masuk/view/pending.pending') }}",
            data: {
                no_urut: no_urut,

                kode_produk: kode_produk,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('pengajuan_masuk.index')}}";
                }else{

                }
            }
        });
    });
</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>View Pengajuan Masuk</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan Masuk</li>
        <li class="breadcrumb-item active">View Pengajuan Masuk</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">    
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Pengajuan Masuk</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Kode Pengajuan
                                        <input type="text" name="kode" class="form-control" value="{{ $pengajuan_v->kode_pengajuan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ $pengajuan_v->tgl_pengajuan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Yang Mengajukan
                                        <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" value="{{ $pengajuan_v->name }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $pengajuan_v->nama_perusahaan }}" readonly>
                                        <input type="hidden" name="kode_perusahaan" id="kode_perusahaan" class="form-control" value="{{ $pengajuan_v->kode_perusahaan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="nama_depo" class="form-control" value="{{ $pengajuan_v->nama_depo }}" readonly>
                                        <input type="hidden" name="kode_depo" id="kode_depo" class="form-control" value="{{ $pengajuan_v->kode_depo }}" readonly>
                                        <input type="hidden" name="kode_divisi" id="kode_divisi" class="form-control" value="{{ $pengajuan_v->kode_divisi }}" readonly>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="ket" id="ket" class="form-control" value="{{ $pengajuan_v->nama_pengeluaran }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Tipe
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_v->sifat }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        No urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $pengajuan_v->no_urut }}" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    @if($pengajuan_v->nama_pengeluaran == 'Pembelian ATK') <!-- jika ATK -->
                                        <input type="hidden" name="sisa_budget" id="sisa_budget" class="form-control" value="{{ $budget->budget }}" required readonly>
                                    @else
                                        <input type="hidden" name="sisa_budget" id="sisa_budget" class="form-control" value="0" required readonly>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

<!-- ################################### COBA #################################### -->
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @if($pengajuan_v->nama_pengeluaran == 'Pembelian ATK') <!-- jika ATK -->
                                    <div class="col-md-12 mb-2" style="text-align: right;">
                                        <input type="hidden" name="total_budget" id="total_budget" class="form-control" value="{{ ($budget->budget) }}" required readonly>
                                        <h3 class="f_budget" id="f_budget">Budget: Rp. {{ number_format($budget->budget) }}</h3>
                                    </div>
                                @endif

                                
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;overflow-y:scroll;">
                                        <table id="tabelinput_1" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kategori</th>
                                                    <th>Id Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Desc/Spek</th>
                                                    <th>Qty</th>
                                                    <!-- filterisasi Qty -->
                                                    <th>Qty IT</th>
                                                    <th>Qty Ops</th>
                                                    <th>Qty GA</th>
                                                    <th>Qty Purchas</th>
                                                    <th>Satuan</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Total Harga</th>
                                                    <!-- filterisasi Qty -->
                                                    <th>Divisi</th>
                                                    <th>Keterangan/Desc</th>
                                                    <th hidden>File/attch</th>
                                                    <th>Persetujuan</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1 ?>
                                                @forelse($details as $val)

                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td class="type">
                                                        <input class="form-control" type="text" name="type[]" id="type{{ $i }}" value="{{ $val->name }}" hidden/>{{ $val->name }}
                                                    </td>
                                                    <td class="kode_produk">
                                                        <input class="form-control" type="text" name="kode_produk[]" id="kode_produk{{ $i }}" value="{{ $val->kode_product }}" hidden/>{{ $val->kode_product }}
                                                    </td>
                                                    <td class="nama_produk">
                                                        <input class="form-control" type="text" name="nama_produk[]" id="nama_produk{{ $i }}" value="{{ $val->nama_barang  }}" hidden/>{{ $val->nama_barang }}
                                                    </td>
                                                    <td class="merk">
                                                        <input class="form-control" type="text" name="merk[]" id="merk{{ $i }}" value="{{ $val->merk }}" hidden/>{{ $val->merk }}
                                                    </td>
                                                    <td class="ket">
                                                        <input class="form-control" type="text" name="ket[]" id="ket{{ $i }}" value="{{ $val->ket }}" hidden/>{{ $val->ket }}
                                                    </td>
                                                    <td class="qty" align="right">
                                                        <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty{{ $i }}" value="{{ $val->qty }}" hidden/>{{ $val->qty }}
                                                    </td>

                                                    <!-- filterisasi Qty -->
                                                    @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                        @if($pengajuan_v->status_validasi_adm_it  == '1')
                                                            <td class="qty_it" align="right">
                                                                {{-- <input type="text" name="qty_it[]{{ $i }}" id="qty_it[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                                <input type="text" name="qty_it[]{{ $i }}" id="qty_it{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_it }}" onkeyup="jumlah_it( {{ $i }} );" readonly>
                                                            </td>
                                                            <td class="qty_it_temp" id="qty_it_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_it }}
                                                        @else
                                                            <td class="qty_it" align="right">
                                                                {{-- <input type="text" name="qty_it[]{{ $i }}" id="qty_it[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                                <input type="text" name="qty_it[]{{ $i }}" id="qty_it{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_it }}" onkeyup="jumlah_it( {{ $i }} );" required>
                                                            </td>
                                                            <td class="qty_it_temp" id="qty_it_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_it }}
                                                        @endif
                                                    
                                                        <td class="qty_ops" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_ops }}" readonly>
                                                        </td>
                                                        <td class="qty_ops_temp" id="qty_ops_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ops }}

                                                        <td class="qty_ga" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_ga[]{{ $i }}" id="qty_ga{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_ga }}" readonly>
                                                        </td>
                                                        <td class="qty_ga_temp" id="qty_ga_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ga }}

                                                        <td class="qty_prc" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_prc[]{{ $i }}" id="qty_prc{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_pc }}" readonly>
                                                        </td>
                                                        <td class="qty_prc_temp" id="qty_prc_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_pc }}
                                                    @elseif(Auth::user()->kode_divisi == '2') <!-- Jika ops-->
                                                        <td class="qty_it" align="right">
                                                            {{-- <input type="text" name="qty_it[]{{ $i }}" id="qty_it[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_it[]{{ $i }}" id="qty_it{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_it }}" readonly>
                                                        </td>
                                                        <td class="qty_it_temp" id="qty_it_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_it }}
                                                        
                                                        @if($pengajuan_v->status_validasi_adm_ops  == '1')
                                                            <td class="qty_ops" align="right">
                                                                {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                                <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_ops }}" onkeyup="jumlah( {{ $i }} );" readonly>
                                                            </td>
                                                            <td class="qty_ops_temp" id="qty_ops_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ops }}
                                                        @else
                                                            <td class="qty_ops" align="right">
                                                                {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                                <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_ops }}" onkeyup="jumlah( {{ $i }} );" required>
                                                            </td>
                                                            <td class="qty_ops_temp" id="qty_ops_temp{{ $i }}" contenteditable="true" hidden>0
                                                        @endif
                                                        

                                                        <td class="qty_ga" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_ga[]{{ $i }}" id="qty_ga{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_ga }}" readonly>
                                                        </td>
                                                        <td class="qty_ga_temp" id="qty_ga_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ga }}

                                                        <td class="qty_prc" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_prc[]{{ $i }}" id="qty_prc{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_pc }}" readonly>
                                                        </td>
                                                        <td class="qty_prc_temp" id="qty_prc_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_pc }}
                                                    @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                        <td class="qty_it" align="right">
                                                            {{-- <input type="text" name="qty_it[]{{ $i }}" id="qty_it[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_it[]{{ $i }}" id="qty_it{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_it }}" readonly>
                                                        </td>
                                                        <td class="qty_it_temp" id="qty_it_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_it }}
                                                        <td class="qty_ops" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_ops }}" readonly>
                                                        </td>
                                                        <td class="qty_ops_temp" id="qty_ops_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ops }}
                                                        
                                                        @if($pengajuan_v->status_validasi_adm_ga  == '1')
                                                            <td class="qty_ga" align="right">
                                                                {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                                <input type="text" name="qty_ga[]{{ $i }}" id="qty_ga{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_ga }}" onkeyup="jumlah_ga( {{ $i }} );" readonly>
                                                            </td>
                                                            <td class="qty_ga_temp" id="qty_ga_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ga }}
                                                        @else
                                                            <td class="qty_ga" align="right">
                                                                {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                                <input type="text" name="qty_ga[]{{ $i }}" id="qty_ga{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_ga }}" onkeyup="jumlah_ga( {{ $i }} );" required>
                                                            </td>
                                                            <td class="qty_ga_temp" id="qty_ga_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ga }}
                                                        @endif
                                                        
                                                        <td class="qty_prc" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_prc[]{{ $i }}" id="qty_prc{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_pc }}" readonly>
                                                        </td>
                                                        <td class="qty_prc_temp" id="qty_prc_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_pc }}
                                                    @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                        <td class="qty_it" align="right">
                                                            {{-- <input type="text" name="qty_it[]{{ $i }}" id="qty_it[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_it[]{{ $i }}" id="qty_it{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_it }}" readonly>
                                                        </td>
                                                        <td class="qty_it_temp" id="qty_it_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_it }}
                                                        <td class="qty_ops" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops{{ $i }}" style="text-align: right; height: 20px; width: 50px;" class="form-control" value="{{ $val->qty_ops }}" readonly>
                                                        </td>
                                                        <td class="qty_ops_temp" id="qty_ops_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ops }}
                                                        <td class="qty_ga" align="right">
                                                            {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                            <input type="text" name="qty_ga[]{{ $i }}" id="qty_ga{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_ga }}" readonly>
                                                        </td>
                                                        <td class="qty_ga_temp" id="qty_ga_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_ga }}
                                                        
                                                        @if($pengajuan_v->status_validasi_adm_pc  == '1')
                                                            <td class="qty_prc" align="right">
                                                                {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                                <input type="text" name="qty_prc[]{{ $i }}" id="qty_prc{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_pc }}" onkeyup="jumlah_pc( {{ $i }} );" readonly>
                                                            </td>
                                                            <td class="qty_prc_temp" id="qty_prc_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_pc }}    
                                                        @else
                                                            <td class="qty_prc" align="right">
                                                                {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                                <input type="text" name="qty_prc[]{{ $i }}" id="qty_prc{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_pc }}" onkeyup="jumlah_pc( {{ $i }} );" required>
                                                            </td>
                                                            <td class="qty_prc_temp" id="qty_prc_temp{{ $i }}" contenteditable="true" hidden>{{ $val->qty_pc }}
                                                        @endif
                                                        
                                                    @endif
                                                    <!-- filterisasi Qty -->
                                                    <td class="satuan">
                                                        <input class="form-control" type="text" name="satuan[]" id="satuan{{ $i }}" value="{{ $val->satuan }}" hidden/>{{ $val->satuan }}
                                                    </td>
                                                    <td class="harga_satuan" align="right">
                                                        <input type="text" style="text-align:right; height: 20px;" class="form-control" name="harga_satuan[]{{ $i }}" id="harga_satuan[]{{ $i }}" style="font-size: 13px;" value="{{ $val->harga_satuan }}" hidden>{{ number_format($val->harga_satuan) }}
                                                    </td>

                                                    @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                        <td>
                                                            <input type="text" style="text-align:right; height: 20px;" class="form-control" name="total_harga[]{{ $i }}" id="total_harga[]{{ $i }}" style="font-size: 13px;" value="{{ number_format($val->qty_it * $val->harga_satuan) }}" readonly>
                                                        </td>
                                                    @elseif(Auth::user()->kode_divisi == '2') <!-- Jika ops-->
                                                        <td>
                                                            <input type="text" style="text-align:right; height: 20px;" class="form-control" name="total_harga[]{{ $i }}" id="total_harga[]{{ $i }}" style="font-size: 13px;" value="{{ number_format($val->qty_ops * $val->harga_satuan) }}" readonly>
                                                        </td>
                                                    @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                        <td>
                                                            <input type="text" style="text-align:right; height: 20px;" class="form-control" name="total_harga[]{{ $i }}" id="total_harga[]{{ $i }}" style="font-size: 13px;" value="{{ number_format($val->qty_ga * $val->harga_satuan) }}" readonly>
                                                        </td>
                                                    @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                        <td>
                                                            <input type="text" style="text-align:right; height: 20px;" class="form-control" name="total_harga[]{{ $i }}" id="total_harga[]{{ $i }}" style="font-size: 13px;" value="{{ number_format($val->qty_pc * $val->harga_satuan) }}" readonly>
                                                        </td>
                                                    @endif

                                                    <td class="divisi">
                                                        <input style="text-align: right" class="form-control" type="text" name="divisi[]" id="divisi{{ $i }}" value="{{ $val->nama_divisi }}" hidden/>{{ $val->nama_divisi }}
                                                    </td>

                                                    <td>
                                                        <a href="#" class="badge badge-success" data-toggle="modal" data-target="#modalKet{{ $val->kode_product }}">Detail Keterangan</a>
                                                    </td>

                                                    <td hidden>
                                                        <a href="#" data-toggle="modal" data-target="#modal_image{{ $val->kode_product }}">
                                                            {{ $val->image }}
                                                        </a>

                                                        <div class="modal fade" id="modal_image{{ $val->kode_product }}" tabindex="-1" role="dialog" aria-labelledby="modal_image" aria-hidden="true">
                                                          <div class="modal-dialog" style="max-width: 55%; max-height: 55%;" role="document">                               
                                                            <div class="modal-content">                                       
                                                             <div class="modal-body">
                                                                                                 
                                                               <button type="button" class="close" data-dismiss="modal"><span 
                                                               aria-hidden="true">&times;</span><span class="sr- 
                                                               only">Close</span></button>                              
                                                               <img src="{{url('images/pengajuan/'. $val->image)}}" class="imagepreview" style="width: 100%;">
                                                                                              
                                                             </div>                             
                                                           </div>                                  
                                                          </div>
                                                        </div>
                                                    </td>
                                                    <td align="center" class="ceklis">
                                                        @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                            @if($pengajuan_v->status_validasi_adm_it == '0') <!-- Baru -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                            @elseif($pengajuan_v->status_validasi_adm_it == '1') <!-- Approved -->
                                                                @if($val->status_cek_it == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_it == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_it == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_it == '3') <!-- pending -->
                                                                @if($val->status_cek_it == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($val->status_cek_it == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled/>
                                                                @elseif($val->status_cek_it == '3')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                            @if($pengajuan_v->status_validasi_adm_ga == '0') <!-- Baru -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );"  value="1" />
                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '1') <!-- Approved -->
                                                                @if($val->status_cek_ga == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_ga == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '3') <!-- pending -->
                                                                @if($val->status_cek_ga == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($val->status_cek_ga == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled/>
                                                                @elseif($val->status_cek_ga == '3')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled/>
                                                                @endif
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '2') <!-- Jika Operasional-->
                                                            @if($pengajuan_v->status_validasi_adm_ops == '0') <!-- Baru -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                            @elseif($pengajuan_v->status_validasi_adm_ops == '1') <!-- Approved -->
                                                                @if($val->status_cek_ops == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_ops == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_ops == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_ops == '3') <!-- pending -->
                                                                @if($val->status_cek_ops == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($val->status_cek_ops == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled/>
                                                                @elseif($val->status_cek_ops == '3')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled/>
                                                                @endif
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                            @if($pengajuan_v->status_validasi_adm_pc == '0') <!-- Baru -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '1') <!-- Approved -->
                                                                @if($val->status_cek_pc == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_pc == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '3') <!-- pending -->
                                                                @if($val->status_cek_pc == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($val->status_cek_pc == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled/>
                                                                @elseif($val->status_cek_pc == '3')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled/>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="ceklist_temp" id="ceklist_temp{{ $i }}" hidden></td>
                                                    <td class="keterangan">
                                                        @if(Auth::user()->kode_divisi == '3') <!--Jika IT-->
                                                            @if($pengajuan_v->status_validasi_adm_it == '0') <!-- Baru -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="" required>
                                                            @elseif($pengajuan_v->status_validasi_adm_it == '1') <!-- approved -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="{{ $val->keterangan_detail_adm_it }}" readonly>
                                                            @elseif($pengajuan_v->status_validasi_adm_it == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_it == '3') <!-- pending -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="{{ $val->keterangan_detail_adm_it }}" required>
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '2') <!--Jika Ops-->
                                                            @if($pengajuan_v->status_validasi_adm_ops == '0') <!-- Baru -->
                                                                @if($val->status_cek_it == '0')
                                                                    <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="" required>
                                                                @elseif($val->status_cek_it == '1')
                                                                    <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="" required>
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_ops == '1') <!-- approved --> 
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="{{ $val->keterangan_detail_adm_ops }}" readonly>
                                                            @elseif($pengajuan_v->status_validasi_adm_ops == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_ops == '3') <!-- pending -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="{{ $val->keterangan_detail_adm_ops }}">
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '4') <!--Jika GA-->
                                                            @if($pengajuan_v->status_validasi_adm_ga == '0') <!-- Baru -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="" required>
                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '1') <!-- approved -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="{{ $val->keterangan_detail_adm_ga }}" readonly>
                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '3') <!-- pending -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="{{ $val->keterangan_detail_adm_ga }}">
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                            @if($pengajuan_v->status_validasi_adm_pc == '0') <!-- Baru -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="" required>
                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '1') <!-- approved -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="{{ $val->keterangan_detail_adm_pc }}" readonly>
                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '3') <!-- pending -->
                                                                <input type="text" name="ket_detail[]{{ $i }}" id="ket_detail[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" class="form-control" style="height: 20px" value="{{ $val->keterangan_detail_adm_pc }}">
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="keterangan_temp" id="keterangan_temp{{ $i }}" hidden></td>
                                                </tr>
                                                <?php $i++; ?>

                                                <!-- Modal Keterangan -->
                                                <div class="modal fade bd-example-modal-lg" id="modalKet{{ $val->kode_product }}" tabindex="-1" aria-labelledby="modalKet" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Keterangan</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--FORM TAMBAH BARANG-->
                                                                <form action="#" method="get">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <b>{{ $val->kode_pengajuan }}</b>
                                                                        <br>
                                                                        <br>
                                                                        <label for="">keterangan Pengaju:</label>
                                                                        
                                                                        <div class="row">
                                
                                                                            <div class="col-md-4 mb-2">
                                                                                <input type="text" name="tgl" class="form-control" value="{{ $val->nama_barang }}" readonly>
                                                                            </div>
                                                                            <div class="col-md-8 mb-2">
                                                                                <input type="text" name="nama_pemohon" class="form-control" value="{{ $val->description }}" readonly>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        

                                                                        <label for="">keterangan Atasan:</label>
                                                                        
                                                                        <div class="row">
                                
                                                                            <div class="col-md-4 mb-2">
                                                                                <input type="text" name="tgl" class="form-control" value="{{ $val->nama_barang }}" readonly>
                                                                            </div>
                                                                            <div class="col-md-8 mb-2">
                                                                                <input type="text" name="nama_pemohon" class="form-control" value="{{ $val->keterangan_detail_atasan }}" readonly>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        

                                                                        <label for="">keterangan IT:</label>
                                                                        
                                                                        <div class="row">
                                
                                                                            <div class="col-md-4 mb-2">
                                                                                <input type="text" name="tgl" class="form-control" value="{{ $val->nama_barang }}" readonly>
                                                                            </div>
                                                                            <div class="col-md-8 mb-2">
                                                                                <input type="text" name="nama_pemohon" class="form-control" value="{{ $val->keterangan_detail_adm_it }}" readonly>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        

                                                                        <label for="">Keterangan Operasional:</label>
                                                                        
                                                                        <div class="row">
                                
                                                                            <div class="col-md-4 mb-2">
                                                                                <input type="text" name="tgl" class="form-control" value="{{ $val->nama_barang }}" readonly>
                                                                            </div>
                                                                            <div class="col-md-8 mb-2">
                                                                                <input type="text" name="nama_pemohon" class="form-control" value="{{ $val->keterangan_detail_adm_ops }}" readonly>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        

                                                                        <label for="">Keterangan General Affair:</label>
                                                                        
                                                                        <div class="row">
                                
                                                                            <div class="col-md-4 mb-2">
                                                                                <input type="text" name="tgl" class="form-control" value="{{ $val->nama_barang }}" readonly>
                                                                            </div>
                                                                            <div class="col-md-8 mb-2">
                                                                                <input type="text" name="nama_pemohon" class="form-control" value="{{ $val->keterangan_detail_adm_ga }}" readonly>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        

                                                                        <label for="">keterangan Purchasing:</label>
                                                                        
                                                                        <div class="row">
                                
                                                                            <div class="col-md-4 mb-2">
                                                                                <input type="text" name="tgl" class="form-control" value="{{ $val->nama_barang }}" readonly>
                                                                            </div>
                                                                            <div class="col-md-8 mb-2">
                                                                                <input type="text" name="nama_pemohon" class="form-control" value="{{ $val->keterangan_detail_adm_pc }}" readonly>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </form>
                                                                <!--END FORM TAMBAH BARANG-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal Keterangan -->
                                                @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data yang tersedia</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
											<tfoot>
                                                <tr>
                                                    <td colspan="13" align="center"><b>T o t a l</b></td>
                                                    <td><input style="text-align: right" class="form-control" type="text" name="total_all" id="total_all" value="0" style="text-align:right; font-style:bold;" required readonly/></td>
                                                    <td colspan="3"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="input-group mb-2 col-md-2 float-right" hidden>  
                                    <input type="hidden" style="text-align: right;" name="subtotal_harga" id="subtotal_harga" class="form-control" value="0" required readonly>
                                    <input type="text" style="text-align: right;" name="subtotal_harga_temp" id="subtotal_harga_temp" class="form-control" value="0" required readonly>
                                </div> 
                                <div class="row"> 
                                    <div class="col-md-12 mb-2">
                                        <div class="input-group mb-3">
                                            
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($approval_upload as $row)
                                                    <tr>
                                                        <td><i>Attachment_{{ $no }}</i></td>
                                                        <td>
                                                            <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                {{ $row->filename }}
                                                            </a>
                                                            
                                                        </td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                    @empty
                                                    
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                    @if($pengajuan_v->status_validasi_adm_it  == '1') <!-- 1: approved -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_validasi_adm_it == '2') <!-- 2: denied -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_validasi_adm_it == '3') <!-- 3: Pending -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                        </div>
                                    @else
                                        {{-- <div class="col-md-1 mb-2">
                                           <button type="submit" class="btn btn-success btn-sm" id="savedatas" name="savedatas" >Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_pending">
                                               Pending
                                           </button>
                                        </div> --}}

                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                        </div>
                                    @endif
                                @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                    @if($pengajuan_v->status_validasi_adm_ga  == '1') <!-- 2: approved -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_validasi_adm_ga == '2') <!-- 3: denied -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_validasi_adm_ga == '3') <!-- 4: Pending -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @else
                                        {{-- <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-success btn-sm" id="savedatas" name="savedatas" >Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" id="savedatas" name="savedatas" >Pending</button>
                                        </div> --}}
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                        </div>
                                    @endif
                                @elseif(Auth::user()->kode_divisi == '2') <!-- Jika Operasional-->
                                    @if($pengajuan_v->status_validasi_adm_ops  == '1') <!-- 2: approved -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_validasi_adm_ops == '2') <!-- 3: denied -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_validasi_adm_ops == '3') <!-- 4: Pending -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @else
                                        {{-- <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-success btn-sm" id="savedatas" name="savedatas" >Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" id="savedatas" name="savedatas" >Pending</button>
                                        </div> --}}
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                        </div>
                                    @endif
                                @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                    @if($pengajuan_v->status_validasi_adm_pc  == '1') <!-- 2: approved -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_validasi_adm_pc == '2') <!-- 3: denied -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_validasi_adm_pc == '3') <!-- 4: Pending -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @else
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                        </div>
                                    @endif
                                @endif


                                    <!-- MODAL APPROVED -->
                                            <div class="modal fade" id="modalTambahPesan_approve" tabindex="-1" aria-labelledby="modalTambahPesan_approve" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control"></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <!-- MODAL DENIED -->
                                            <div class="modal fade" id="modalTambahPesan_denied" tabindex="-1" aria-labelledby="modalTambahPesan_denied" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan ditolak </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="#" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <!-- MODAL Pending -->
                                            <div class="modal fade" id="modalTambahPesan_pending" tabindex="-1" aria-labelledby="modalTambahPesan_pending" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk keterangan ditunda  </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="#" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->

                                    <!-- MODAL Pending -->
                                    <div class="modal fade" id="modal_pending" tabindex="-1" aria-labelledby="modal_pending" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Informasi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 class="text-center">Apakah anda yakin akan menunda pengajuan dengan kode pengajuan '{{ $pengajuan_v->kode_pengajuan }}' ini?</h4>
                                                
                                                    <form action="{{ route('pengajuan_masuk/view/pending.pending', $pengajuan_v->no_urut) }}" method="get">
                                                        @csrf
                                                        <div class="form-group">
                                                            <input type="hidden" name="kode_pengajuan" id="kode_pengajuan" class="form-control" value="{{ $pengajuan_v->no_urut }}" readonly>
                                                            <label for="">Isi keterangan jika akan ditunda/dipending:</label>
                                                            <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="2" class="form-control" required></textarea>
                                                        </div>
                                                        
                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End MODAL -->

                                    <div class="col-md-10 mb-2" align="right">
                                        @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                            @if($pengajuan_v->status_validasi_adm_it  == '0')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_it  == '1')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_it  == '2')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_it  == '3')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @endif
                                        @elseif(Auth::user()->kode_divisi == '2') <!-- Jika OPS-->
                                            @if($pengajuan_v->status_validasi_adm_ops  == '0')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_ops  == '1')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_ops  == '2')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_ops  == '3')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @endif
                                        @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                             @if($pengajuan_v->status_validasi_adm_ga  == '0')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_ga  == '1')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_ga  == '2')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_ga  == '3')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @endif
                                        @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                             @if($pengajuan_v->status_validasi_adm_pc  == '0')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_pc  == '1')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_pc  == '2')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @elseif($pengajuan_v->status_validasi_adm_pc  == '3')
                                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                            @endif
                                        @endif
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
    </div>
</main>





@endsection






